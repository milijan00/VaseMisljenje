<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuthorModel;
class AuthorController extends Controller
{
    //
    public function index(){
        return view("pages.author");
    }
    public function getAuthorInfo(){
        $model = new AuthorModel();
        return $model->get();
    }

}
