<?php

namespace App\Http\Controllers;

use App\Regex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactAdmin;
class ContactController extends Controller
{
    //
    public function index(){
        return view("pages.contact") ;
    }
    public function sendEmail(Request $request){
        $email = $request->get('email');
        $subject = $request->get("subject");
        $message = $request->get("message");
        $errorNum = 0;
        if(!preg_match(Regex::email(), $email)){
            $errorNum ++;
        }
        if(!preg_match(Regex::subject(), $subject)){
            $errorNum++;
        }
        if(!preg_match(Regex::message(), $message)){
            $errorNum++;
        }
        try{
            if($errorNum == 0){
                //send email
                $contact = new \stdClass();
                $contact->email = $email;
                $contact->subject =$subject;
                $contact->message = $message;
                Mail::to("aleksandar.milijanovic.91.19@ict.edu.rs")->send(new ContactAdmin($contact));
                return response()->json([
                    "success"=>true
                ]);
            }else {
                return redirect()->route("home");
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return response()->json([
                "error"=>true
            ]);
        }
    }
}
