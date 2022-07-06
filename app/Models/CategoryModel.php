<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CategoryModel extends Model
{
    use HasFactory;
    public function get(){
       return DB::table("categories")->get();
    }
    public function getWithDebateCount(){
        $categories =  DB::table("categories")
            ->get();
        foreach($categories as $c){
            $c->discusionsNum = DB::table("discusions")
                                ->where([
                                    ["active", 1],
                                    ["idCategory", $c->idCategory]
                                ])->count("idDiscusion");
        }
       return $categories;
    }
}
