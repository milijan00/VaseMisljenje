<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;
use App\Regex;
class AuthController extends Controller
{
    //
    public function index(){

    }
    public function login(Request  $request){
//        dd($request->all());
        $data = $request->all();
        $errorNum = 0;
        try{
            if(!preg_match(Regex::email(), $data["email"])){
                $errorNum++;
            }
            if(!preg_match(Regex::password(), $data["password"])){
                $errorNum++;
            }
            // pass data to model
            if($errorNum > 0){
                return redirect()->route("home");
            }
            $model = new UserModel();
            $user = $model->authentification($data["email"], $data["password"]);
            if($user){
                // begin with session
                session()->put("user", $user);
                return response()->json(["success"=>true]);
            }else {
                return response()->json(["error"=>"Pogrešno korisnicko ime ili lozinka."]);
            }
        }catch(Exception $sql){
            Log::error($sql->getMessage());
            return response()->status(500);
        }
    }
    public function register(){
        return view("pages/registration");
    }
    public function createAccount(Request $request){
        $data = $request->all();
        $errorNum = 0;
        if(!preg_match(Regex::firstLastName(), $data["firstname"])){
            $errorNum++;
        }
        if(!preg_match(Regex::firstLastName(), $data["lastname"])){
            $errorNum++;
        }
        if(!preg_match(Regex::email(), $data["email"])){
            $errorNum++;
        }

        if(!preg_match(Regex::password(), $data["password"])){
            $errorNum++;
        }
        if(!preg_match(Regex::password(), $data["passwordAgain"])){
            $errorNum++;
        }
        if($data["password"] != $data["passwordAgain"]){
            $errorNum++;
        }
        if($errorNum == 0) {
            try{
                $model = new UserModel();
                $user  = $model->authentification($data["email"], $data["password"]);
                if($user == null){
                    if($model->store(
                        $data["firstname"],
                        $data["lastname"],
                        $data["email"],
                        $data["date"],
                        $data["password"]
                    )){
                        return response()->json([
                            "success"  => true,
                            "message" => "Uspešno ste naprvili nalog."
                        ]);
                    }else {
                        return response()->json([
                            "message"=> "Nastao je problem sa serverom, molimo Vas pokušajte kasnije."
                        ]);
                    }
                }else {
                   return response()->json([
                       "message"=>"Već postoji korisnik sa istim email-om i lozinkom."
                   ]) ;
                }
            }catch(Exception $ex){
                Log::error($ex->getMessage());
            }
        }else {
            // not sent from the client
            return redirect()->route("home");
        }


    }
    public function logout(){
       session()->forget("user");
       return redirect()->route("home");
    }
}
