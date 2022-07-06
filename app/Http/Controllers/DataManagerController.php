<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscusionModel;
use App\Models\ImageModel;
class DataManagerController extends Controller
{
    //

    public function getUserDiscusionsAndComments($id = null){
       try{
           if($id == null){
               $id = session()->get("user")->idUser;
           }
           $model = new DiscusionModel();
           $imageModel = new ImageModel();
           $userImage =$imageModel->getForUser($id)->src;
           $discusions = $model->getUsersDiscusions($id);
           return [
               "image"=>$userImage,
               "discusions"=>$discusions
           ];
       } catch(Exception $ex){
           Log::error($ex->getMessage());
       }
    }
}
