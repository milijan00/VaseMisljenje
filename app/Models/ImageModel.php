<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ImageModel extends Model
{
    use HasFactory;

    public function insertImage($filename, $idUser){
        return DB::table("images")
            ->insert([
                "src" =>$filename,
                "idUser"=>$idUser
            ]);
    }
    public function getForUser($id){
        return DB::table("images")
            ->select("src")
            ->where([
                ["idUser" , "=" , $id],
                ["active", "=", 1]
            ])->first();
    }
    public function softDeleteImage($id){
        return DB::table("images")
            ->where([
                ["idUser", $id],
                ["active" , 1]
                ])
            ->update([
                    "active"=>0
                ]);
    }
    public function hardDeleteImage($id){
        $destination = "public/images/";
        $filename = DB::table("images")
            ->select("src")
            ->where([
                ["idUser", $id],
                ["active" , 1]
            ])->first();
        Storage::delete($destination . $filename);
        return DB::table("images")
            ->where([
                ["idUser", $id],
                ["active" , 1]
            ])
            ->delete();
    }
}
