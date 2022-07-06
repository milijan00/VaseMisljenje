<?php

namespace App\Http\Controllers;

use App\Models\ProfileMenuModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\DiscusionModel;
use App\Models\ImageModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Regex;
class UserController extends DataManagerController
{
    //
    public function index(){
        $id = session()->get("user")->idUser;
        return view("pages.profile", ["data"=>$this->fetchUserData($id)]);
    }
    public function show($id)
    {
        if($id == session()->get("user")->idUser){
            return redirect()->route("profile");
        }
        $model = new UserModel();
        $isAFollower = $model->isFollowed($id) != null ;
        return view("pages.profile", ["data"=>$this->fetchUserData($id), "isAFollower"=>$isAFollower]);
    }
    public function create(){
        return view("pages.newdiscusion");
    }
    public function editProfile(){
        return view("pages.editprofile");
    }
    public function follow(Request $request){
        $id = $request->get("id");
        try{
            $model = new UserModel();
            if($model->follow($id)){
                return response()->json([
                    "success"=>true,
                    "id"=>$id
                ]);
            }else {
                return response()->json([
                    "error"=>true
                ]);
            }
        }catch(Exception $ex){
           Log::error($ex->getMessage()) ;
           return response()->json([
               "error"=>true
           ]);
        }

    }
    public function unfollow(Request  $request){
        $id = $request->get("id");
        try{
            $model = new UserModel();
            $isFollowing = $model->isFollowed($id) != null;
            if($isFollowing){
                if($model->unfollow($id)){
                    if($request->has("returnFollowers")){
                        $search = $request->get("search");
                        $idAuth = session()->get("user")->idUser;
                        if(preg_match(Regex::subject(), $search)){
                            $followers = $model->getUserFollowers($idAuth, $search);
                        }else {
                            $followers = $model->getUserFollowers($idAuth);
                        }

                        return response()->json([
                            "success"=>true,
                            "followers" =>$followers
                        ]);
                    }
                    return response()->json([
                        "success"=>true,
                        "id"=>$id
                    ]);
                }else {
                    return response()->json([
                        "error"=>true
                    ]);
                }
            }
        }catch(Exception $ex){
           Log::error($ex->getMessage()) ;
            return response()->json([
                "error"=>true
            ]);
        }

    }
    // it's called whenever a follower search is commited
    public function followers(Request $request){
        $id = session()->get("user")->idUser;
        $search = $request->query("search");
        if(preg_match(Regex::search(), $search)){
            try{
                $model = new UserModel();
                return $model->getUserFollowers($id, $search);
            }catch(Exception $ex){
                Log::error($ex->getMessage()) ;
                return null;
            }
        }else {
            return redirect()->route("home") ;
        }

    }
    private function fetchUserData($id){
        $initialData = [];
        $userModel = new UserModel();
        $data = $this->getUserDiscusionsAndComments($id);
        $initialData["userImage"] = $data["image"];
        $initialData["userData"] = $userModel->getUser($id);
        $initialData["discusions"] = $data["discusions"];
        $initialData["followers"] = $userModel->getUserFollowers($id);
        $profileMenuModel  = new ProfileMenuModel();
        $initialData["menu"] = $profileMenuModel->get();
        return $initialData;
    }
    public function update(Request  $request){
        $data = $request->all();

        $errorNum = 0;
        if(isset($data["firstname"]) && !preg_match(Regex::firstLastName(), $data["firstname"])){
            $errorNum++;
        }
        if(isset($data["lastname"]) && !preg_match(Regex::firstLastName(), $data["lastname"])){
            $errorNum++;
        }


        if(isset($data["email"]) && !preg_match(Regex::email(), $data["email"])){
            $errorNum++;
        }
        if(
            (isset($data["passwordOld"]) && isset($data["password"])) && (!preg_match(Regex::password(), $data["passwordOld"]) || !preg_match(Regex::password(), $data["password"]) || $data["passwordOld"] == $data["password"] || md5($data["passwordOld"])  != session()->get("user")->password)
        ){
            $errorNum++;
        }
        if(isset($data["birthDate"]) && !preg_match(Regex::date(), $data["birthDate"])){
            $errorNum++;
        }
        $model = new UserModel();
        if($errorNum == 0){
            try{
                if(isset($data["passwordOld"])){
                    unset($data["passwordOld"]);
                    $data["password"] = md5($data["password"]);
                }
                if($model->updateUserData($data)){
                    session()->put("user", $model->getUser(session()->get("user")->idUser));
                    return response()->json([
                        "success"=>true
                    ]);
                }
                else{
                    return response()->json([
                        "success"=>false
                    ]);
                }
            }catch(Exception $ex){
               Log::error($ex->getMessage()) ;
               return response()->status(500);
            }
        }else {
           return response()->json([
               "error"=>true
           ]);
        }
    }

    public function updateProfilePicture(Request $request)
    {
        if(!$request->has("pictureEditProfile")){
            return redirect()->back()->with("error", "Niste odabrali fotografiju.");
        }
//        $image = $_FILES["pictureEditProfile"];
        $image = $request->file("pictureEditProfile");
        // validation
        if (!in_array($image->getMimeType(), ["image/png", "image/jpg", "image/jpeg"])) {
            return redirect()->back()->with("message", "Tip fotografije nije dobar.");
        }
        try{
            $destination = "public/images";
            $filename = time() . $image->getClientOriginalName();
            $model = new ImageModel();
            $id = session()->get("user")->idUser;
            if($model->softDeleteImage($id)){
                $model->insertImage($filename, $id) ;
                $path = $image->storeAs($destination, $filename);
                return redirect()->back()->with("success", "Uspešno ste promenili profilnu fotografiju.");
            }else {
                return redirect()->back()->with("error", "Promena profilne fotogragije nije moguća.");
            }
//            echo($filename);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return redirect()->back()->with("error", "Došlo je do greške na serveru, molimo Vas pokušajte kasnije.");
        }

    }
}
