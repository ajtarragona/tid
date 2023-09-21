<?php

namespace Ajtarragona\TID\Controllers;

use Illuminate\Http\Request;
use \Artisan;
use TID;


class TIDController extends Controller
{

    public function login(Request $request){
        //mostrar página de login
        // dd("HOLA");
        // Artisan::call('vendor:publish', [
        //     '--tag' => 'ajtarragona-tid-assets', 
        //     '--force' => 1
        // ]);
        return view('ajtarragona-tid::login');
    }   



    public function logout(){
        // dd("LOGOUT");
        TID::deauthenticate();
        return redirect()->back();

    }

    public function setsession(){

        TID::setAuth([
            "access_token"=>"tokennnnn",
            "refresh_token"=>"refressssh",
            "expires_in"=>55,
            "token_type"=>"Bearer",

        ],[
            "identifier"=>"IDDDD",
            "phone"=>"phoneeeeee",
            "name"=>"Nommmm",
            "surname1"=>"Cognommmmm",
            "surname2"=>"Cognommmmm2222",
            "email"=>"Emailllll",
        ]);

    }


    public function handleReponse(Request $request)
    {
       
        // dd($request->all());
        $return_url=TID::getOriginUrl($request->state);
                
        if($request->error){
            if($request->error == "SESSION_CANCEL"){
                return response()->redirectTo($return_url);
            }
            //Trato el error
            // abort(500, $request->error);
            return response()->redirectTo($return_url)."?error=UNKNOWN_ERROR";

        }else if($request->code){
            //aquí se llama desde, pasando un codigo generado
            //Con este código obtendré un token y a info del usuario 
            $ret=TID::authenticate($request->code,$request->state);
            // dd($ret);
            if($ret){
                return response()->redirectTo($return_url);
            }else{
                return response()->redirectTo($return_url)."?error=AUTH_ERROR";
            }
        }else{
            //algo ha pasao
            return response()->redirectTo($return_url)."?error=UNKNOWN_ERROR";
        }

        
    }
}
