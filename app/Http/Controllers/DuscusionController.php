<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DiscusionModel;
use Illuminate\Http\Request;
use App\Regex;
class DuscusionController extends DataManagerController
{
    public function index(){
        $model = new CategoryModel();
        $data["categories"] = $model->getWithDebateCount();
        return view("pages.discusions", ["data" => $data]);
    }
    public function create(){
        $model = new CategoryModel() ;
        return view("pages.newdiscusion", ["categories"=>$model->get()]);
    }

    public function showFromCat($id){
        $model =  new DiscusionModel();
        $data["discusions"] = $model->getDiscusionFromCategory($id) ;
        return view("pages.discusionsfromcategory", ["data"=>$data]);
    }
    public function store(Request $request){
       $subject = $request->get("subject") ;
       $message = $request->get("message");
       $categoryId = $request->get("categoryId");
       $errorNum = 0;
       if(!preg_match(Regex::subject(), $subject )){
            $errorNum++;
       }
       if(!preg_match(Regex::message(), $message)){
           $errorNum++;
       }
       if(!preg_match(Regex::category(), $categoryId)){
           $errorNum++;
       }

       if($errorNum == 0){
            // insert post into table
           $model = new DiscusionModel();
           try{
               if($model->insertDiscusion($subject, $message, $categoryId)){
                   return response()->json([
                       "success"=>true
                   ]);
               }else {
                return response()->json([
                    "error"=>true
                ]);
               }
           }catch(Exception $ex){
                Log::error($ex->getMessage());
                return response()->json([
                    "errorServer"=>true
                ]);
           }
       }else {
            return redirect()->route('home') ;
       }

//        return $request->all();
    }

    public function deleteDiscusion(Request $request){
//        return $request->all();
        $idDiscusion = $request->get("idDiscusion");
        try{
            $model = new DiscusionModel();
            if($model->deleteDiscusion($idDiscusion)){
                if($request->has("idCategory")){
                    $model = new DiscusionModel();
                    $idCategory = $request->get("idCategory");
                    $data = $model->getDiscusionFromCategory($idCategory);
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
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json([
                "error"=>true
            ]);
        }
    }

    public function edit($id){
        $model = new DiscusionModel();
        $data["dis"] = $model->find($id);
        $model = new CategoryModel();
        $data["categories"]  =$model->get();
        return view("pages.editdiscusion", ["data"=>$data]);
    }


    public function update(Request  $request){
        $subject = $request->get("subject");
        $idDiscusion  = $request->get("id");
        $content = $request->get("content");
        $idCategory  =$request->get("category");
        $errorNum = 0;
        if(!preg_match(Regex::subject(),$subject)){
            $errorNum++;
        }
        if(!preg_match(Regex::message(), $content)){
            $errorNum++;
        }

        if(!preg_match(Regex::category(), $idCategory)){
            $errorNum++;
        }
        if($errorNum == 0){
            try{
                $model = new DiscusionModel();
                if($model->updateDiscusion([
                    "content" =>$content,
                    "title"=>$subject,
                    "idCategory"=>$idCategory,
                    "idDiscusion"=>$idDiscusion
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
