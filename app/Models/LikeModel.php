<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class LikeModel extends Model
{
    use HasFactory;

    public function insertLike($idComment, $idUser){
        return DB::table("likes")
            ->insert([
                "idUser"=>$idUser,
                "idComment"=>$idComment
            ]);
    }
    public function deleteLike($idComment, $idUser){
        return DB::table("likes")
            ->where([
                ["idComment", "=", $idComment],
                ["idUser", "=", $idUser]
            ])
            ->delete();
    }
    public function getNumberOfLikes($idComment){
        return DB::table("likes")
            ->where("idComment", $idComment)
            ->count("idLike");

    }
}

