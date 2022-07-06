<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentModel;
use App\Regex;
use Illuminate\Support\Facades\Log;
use App\Models\DiscusionModel;
use App\Models\ImageModel;
class CommentController extends DataManagerController
{
    //
    public function store(Request $request){
        $content = $request->get("content");
        $idDiscusion = $request->get("idDiscusion");
        $idUser = session()->get("user")->idUser;
        if(preg_match(Regex::message(), $content)){
            // insert comment
            try{
                $model = new CommentModel();
                if($model->insertComment(
                    $content,
                    $idDiscusion,
                    $idUser
                )){
                    if($request->has("idCategory")){
                        $model = new DiscusionModel();
                        $id = $request->get("idCategory");
                        $data = $model->getDiscusionFromCategory($id);
//                        dd($data);
                        return response()->json([
                            "success"=>true,
                            "discusions" =>$data
                        ]);
                    }else {
                        $id = $request->get("idUser");
                        $data = $this->getUserDiscusionsAndComments($id);
                        return response()->json([
                            "success"=>true,
                            "discusions" =>$data["discusions"]
                        ]);
                    }
                }else {
                    return response()->json([
                        "error"=>true
                    ]);
                }
            }catch(Exception $ex){
                Log::error($ex->getMessage());
                return response()->json([
                    "error"=>true
                ]);
            }
        }else {
            return redirect()->route("home");
        }
//        return $request->all();
    }
    public function delete(Request $request){
        try{
           $id = $request->get("idComment") ;
           $model = new CommentModel();
           if($model->deleteComment($id)){
               if($request->has("idCategory")){
                   $model = new DiscusionModel();
                   $id = $request->get("idCategory");
                   $data = $model->getDiscusionFromCategory($id);
                   return response()->json([
                       "success"=>true,
                       "discusions" =>$data
                   ]);
               }else {
                   $idUser = $request->get("idUser");
                   $data = $this->getUserDiscusionsAndComments($idUser);
                   return response()->json([
                       "success"=>true,
                       "userImage" =>$data["image"],
                       "discusions"=>$data["discusions"]
                   ]);
               }
           }else {
               return response()->json([
                   "error"=>true
               ]);
           }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json([
                "error"=>true
            ]);

        }
    }
    public function edit($id){
        $model = new CommentModel();
        $comment = $model->find($id) ;
        return view("pages.editcomment", ["comment"=>$comment]);
    }
    public function updateComment(Request  $request){
        $content = $request->get("content");
        if(preg_match(Regex::message(), $content) && $request->get("id")){
            try{
                $model  = new CommentModel();
                if($model->updateComment([
                    "content"=>$content,
                    "idComment"=>$request->get("id")
                ])){
                    return response()->json([
                        "success"=>true
                    ]);
                }else {
                    return response()->json([
                        "nothingUpdated"=>true
                    ]);
                }
            }catch(Exception $ex){
                Log::error($ex->getMessage());
                return response()->json([
                    "error"=>true
                ]);
            }
        }else {
            return redirect()->route("home");
        }
    }

}
