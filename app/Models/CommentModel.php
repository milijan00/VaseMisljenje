<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CommentModel extends Model
{
    use HasFactory;
    public function getCommentsForDiscusion($id){
        $comments =  DB::table("comments AS com")->
        select(
            "com.idComment",
            "com.content",
            "com.date",
            "images.src as profilePic",
            "users.firstname",
            "users.lastname",
            "users.idUser"
        )
            ->join("users", "users.idUser" , "=", "com.idUser")
            ->join("images", "images.idUser", "=", "com.idUser")
            ->where([
                ["com.idDiscusion", "=",  $id],
                ["com.active", "=", 1],
                ["images.active", "=", 1]
            ])
            ->get();
        $idAuth = session()->get("user")->idUser;
        foreach($comments as $c){
            $c->likes = DB::table("likes")
                ->where("idComment", $c->idComment)
                ->count("idLike");
            $c->AuthUserLiked = DB::table("likes")
                ->where("idComment", $c->idComment)
                ->where("idUser", $idAuth)
                ->first() != null;
        }
        return $comments;
    }
    public function find($id){
        return DB::table("comments")
            ->where("idComment", "=", $id)
            ->first();
    }
    public function insertComment(
        $content,
        $idDiscusion,
        $idUser
    ){
        return DB::table("comments")
            ->insert([
                "idDiscusion"=>$idDiscusion,
                "idUser"=>$idUser,
                "content"=>$content
            ]);
    }

    public function deleteComment($id){
        return DB::table("comments")
            ->where("idComment" ,"=" ,$id)
            ->update([
                "active"=> 0
            ]);
    }

    public function updateComment($data){
        return DB::table("comments")
            ->where("idComment", $data["idComment"])
            ->update([
                "content"=>$data["content"]
            ]);
    }
}
