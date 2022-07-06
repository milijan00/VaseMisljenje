<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\CommentModel;
class DiscusionModel extends Model
{
    use HasFactory;
    public function getUsersDiscusions($id){
       $discusions = DB::table("discusions")
           ->select(
               "discusions.*",
               "users.firstname",
               "users.lastname",
               "users.idUser",
               "categories.name as category",
               "images.src"
           )
           ->join("users", "users.idUser", "=","discusions.idUser")
           ->join("categories", "categories.idCategory", "=", "discusions.idCategory")
           ->join("images", "images.idUser", "=", "users.idUser")
           ->where([
               ["discusions.active", 1],
               ["users.idUser", "=", $id],
               ["images.active", "=", 1]
           ])
           ->get();
        // after fetching all discusions, fetch all comemnts for fetched posts
        $commentModel = new CommentModel();
        foreach($discusions as $dis){
            $dis->comments = $commentModel->getCommentsForDiscusion($dis->idDiscusion);
        }
        return $discusions;
    }
    public function get(){
        $discusions = DB::table("discusions")
            ->select(
                "discusions.*",
                "users.firstname",
                "users.lastname",
                "users.idUser",
                "categories.name as category",
                "images.src"
            )
            ->join("users", "users.idUser", "=","discusions.idUser")
            ->join("categories", "categories.idCategory", "=", "discusions.idDiscusion")
            ->join("images", "images.idUser", "=", "users.idUser")
            ->where([
                ["discusions.active", 1]
            ])
            ->get();
        // after fetching all discusions, fetch all comemnts for fetched posts
        $commentModel = new CommentModel();
        foreach($discusions as $dis){
            $dis->comments = $commentModel->getCommentsForDiscusion($dis->idDiscusion);
        }
        return $discusions;
    }

    public function find($id){
        return DB::table("discusions")
            ->where("idDiscusion", $id)
            ->first();
    }


    public function getDiscusionFromCategory($idCategory)
    {
        $discusions = DB::table("discusions")
            ->select(
                "discusions.*",
                "users.firstname",
                "users.lastname",
                "users.idUser",
                "categories.name as category",
                "categories.idCategory",
                "images.src"
            )
            ->join("users", "users.idUser", "=","discusions.idUser")
            ->join("categories", "categories.idCategory", "=", "discusions.idCategory")
            ->join("images", "images.idUser", "=", "users.idUser")
            ->where([
                ["discusions.active", "=", 1],
                ["discusions.idCategory", "=",$idCategory],
                ["images.active", "=", 1]
            ])
            ->get();
        // after fetching all discusions, fetch all comemnts for fetched posts
        $commentModel = new CommentModel();
        foreach($discusions as $dis){
            $dis->comments = $commentModel->getCommentsForDiscusion($dis->idDiscusion);
        }
        return $discusions;
    }

    public function insertDiscusion(
        $subject,
        $message,
        $categoryId
    ){
        return DB::table("discusions")
            ->insert([
                "title" => $subject,
                "content"=>$message,
                "idCategory"=>$categoryId,
                "idUser"=>session()->get("user")->idUser
            ]);
    }

    public function deleteDiscusion($id){

        if( DB::table("discusions")
            ->where("idDiscusion", $id)
            ->update([
                "active"=>0
            ])){
             DB::table("comments")
                ->where("idDiscusion", $id)
                ->update([
                    "active"=>0
                ]);
             return true;
        }
        return false;
    }

    public function updateDiscusion($data){
        return DB::table("discusions")
            ->where("idDiscusion", $data["idDiscusion"])
            ->update([
                "title"=>$data["title"],
                "content"=>$data["content"],
                "idCategory"=>$data["idCategory"]
            ]);
    }
}
