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
        Artisan::call('vendor:publish', [
            '--tag' => 'ajtarragona-tid-assets', 
            '--force' => 1
        ]);
        return view('ajtarragona-tid::login');
    }   



    public function logout(){
        // dd("LOGOUT");
        TID::deauthenticate();

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
       
        if($request->error){
            //Trato el error
            abort(500, $request->error);
        }else if($request->code){
            //aquí se llama desde, pasando un codigo generado
            //Con este código obtendré un token y a info del usuario 
            $ret=TID::authenticate($request->code,$request->state);
            if($ret){
                $return_url=TID::getOriginUrl($request->state);
                return response()->redirectTo($return_url);
            }else{
                abort(500,"Error desconegut");
            }
        }else{
            //algo ha pasao
        }

        
    }
}
