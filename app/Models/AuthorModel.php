<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class AuthorModel extends Model
{
    use HasFactory;
    public function getAll(){

    }
    public function get(){
        return DB::table("authors")->select("name", "school", "student_index")->first();
    }
}
