<?php

namespace Ajtarragona\TID\Controllers;

use Illuminate\Http\Request;
use \Artisan;
use TID;
use Illuminate\Support\Str;

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

    public function setsession(Request $request){
        // dd($request->all());
        if(config('tid.test_mode')){
            $surnames=explode(" ",$request->surnames);
            $surname1=$surnames[0];
            $surname2=$surnames[1] ??null;
            
            // dd($request->all());
            TID::setAuth([
                "access_token"=>"dummy_token",
                "refresh_token"=>"dummy_token_refresh",
                "expires_in"=>55,
                "token_type"=>"Bearer",

            ],
                array_merge($request->except('_token'),[
                    'surname1'=>$surname1,
                    'surname2'=>$surname2,
                    'identifierType'=>1,
                    'method '=>'certificat',
                    'certificateType'=>0
                ])
             );
             
        }
        
        return redirect()->back(); 
        

    }


    public function handleReponse(Request $request)
    {
       
        // dd($request->all());
        $return_url=TID::getOriginUrl($request->state);
        $has_params=Str::contains($return_url,"?");

        if($request->error){
            if($request->error != "SESSION_CANCEL"){
                $return_url.=($has_params?'&':'?').'error=UNKNOWN_ERROR';
            }
        }else if($request->code){
            //aquí se llama desde valid, pasando un codigo generado
            //Con este código obtendré un token y a info del usuario 
            $ret=TID::authenticate($request->code,$request->state);
            // dd($ret);
            if(!$ret){
                $return_url.=($has_params?'&':'?').'error=AUTH_ERROR';
            }
        }else{
            $return_url.=($has_params?'&':'?').'error=UNKNOWN_ERROR';
        }

        return response()->redirectTo($return_url);

        
    }
}
