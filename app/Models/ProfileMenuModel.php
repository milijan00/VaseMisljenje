<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProfileMenuModel extends Model
{
    use HasFactory;

    public function get(){
        return DB::table("profileMenu")    ->get();
    }
}
