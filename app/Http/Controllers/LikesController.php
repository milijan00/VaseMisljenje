<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikeModel;
use Illuminate\Support\Facades\Log;
class LikesController extends Controller
{
    public function store(Request $request){
        $id = $request->get("id");
        $idUser =$request->session()->get("user")->idUser;
        try{
            $model = new LikeModel();
            if($model->insertLike($id, $idUser)){
                return response()->json([
                    "success" =>true,
                    "idComment"=>$id,
                    "numberOfLikes" =>$model->getNumberOfLikes($id)
                ]);
            }else {
                return response()->json([
                   "error" =>true
                ]);
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json([
                "error" =>true
            ]);
        }
    }
    public function deleteLike(Request $request){
        $id = $request->get("id");
        $idUser =$request->session()->get("user")->idUser;
        try{
            $model = new LikeModel();
            if($model->deleteLike($id, $idUser)){
                return response()->json([
                    "success" =>true,
                    "idComment"=>$id,
                    "numberOfLikes" =>$model->getNumberOfLikes($id)
                ]);
            }else {
                return response()->json([
                    "error" =>true
                ]);
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json([
                "error" =>true
            ]);
        }
    }
}
