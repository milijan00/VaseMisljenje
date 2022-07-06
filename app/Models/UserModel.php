<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UserModel extends Model
{
    use HasFactory;

    public function authentification($email, $password){
        $password = md5($password);
        return DB::table("users")->where([
            ["email" , "=",  $email],
            ["password", "=", $password]
        ])->first();
    }

    public function store(
        $firstname,
        $lastname,
        $email,
        $date,
        $password
    ){
       $id =  DB::table("users")->insertGetId([
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "password"=>md5($password),
            "birthDate" => $date
        ]);

        DB::table("images")->insert([
            "src"=>"profilePicture1.jpg",
            "idUser"=>$id
        ]);
        return true;
    }
    public function getUser($id){
        $active = 1;
        return DB::table("users")
            ->select("users.idUser", "users.firstname", "users.lastname", "images.src", "users.email", "users.birthDate", "users.password")
            ->join("images", "images.idUser", "=", "users.idUser")
            ->where([
                ["users.idUser" , $id],
                ["images.active", $active]
            ])->first();
    }
    public function isFollowed($id){
        return DB::table("followers")
            ->where("idFollowedUser", "=", $id)
            ->first();
    }
    public function unfollow($id){
        $idAuth = session()->get("user") ->idUser;
       return DB::table("followers")
            ->where([
                ["idFollowedUser", "=", $id],
                ["idUser" , "=", $idAuth]
        ])
            ->delete();
    }
    public function follow($id){
        $idAuth = session()->get("user")->idUser;
        return DB::table("followers")
            ->insert([
                "idUser"=>$idAuth,
                "idFollowedUser"=>$id
            ]);
    }
    public function getUserFollowers($id, $search= null){
        if($search == null){
            return DB::table("users")
                ->select("users.firstname", "users.lastname", "users.idUser", "images.src")
                ->join("followers", "followers.idFollowedUser", "=", "users.idUser")
                ->join("images", "images.idUser" , "=" ,"users.idUser")
                ->where([
                    ["followers.idUser", $id],
                    ["images.active", 1]
                ])->get();
        }
        return DB::table("users AS u1")
            ->select("u2.firstname", "u2.lastname", "u2.idUser", "images.src")
            ->join("followers", "followers.idUser", "=", "u1.idUser")
            ->join("users AS u2", "followers.idFollowedUser", "=", "u2.idUser")
            ->join("images", "images.idUser", "=", "u2.idUser")
            ->where([
                ["images.active", "=",1],
                ["u1.idUser", "=", $id],
            ])
            ->where(function($query) use($search){
                $query->where("u2.firstname", "like", "%$search%")
                    ->orWhere("u2.lastname", "like", "%$search%")
                    ->orWhere("u2.email", "like", "%$search%");
            })
            ->get();
    }
    public function updateUserData($data){
       return  DB::table("users")->where("users.idUser", session()->get("user")->idUser)
            ->update($data);

    }
}
