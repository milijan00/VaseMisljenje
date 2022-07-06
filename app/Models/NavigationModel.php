<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NavigationModel extends Model
{
    use HasFactory;
    public function get(){
        $links = DB::table("navigation")->get();
        $i = 0;
        $explodedURLNames = [
            "user",
            "contact",
            "author",
            "discusions",
            "auth"
        ];
        foreach($links as $link)     {
            $link->explodedURLName = $explodedURLNames[$i++];
        }
        return $links;
    }
}
