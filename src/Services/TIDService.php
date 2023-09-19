<?php
namespace Ajtarragona\TID\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Crypt;
use Illuminate\Support\Facades\Hash;

class TIDService{

    public static $SESSION_NAME = 'aoc_valid_info';


    public function makeValidUrl($state=null){
        
        $config=config('tid');
        
        $redirect_uri=$this->getRedirectUri();

       

        // $state=$state?$state:
        $state=$state?$state:$this->cryptOriginUrl();

        // dump($this->getOriginUrl($state));
        return "{$config["auth_url"]}?response_type=code&client_id={$config["client_id"]}&approval_prompt=auto&access_type={$config["access_type"]}&scope={$config["scope"]}&redirect_uri={$redirect_uri}&state={$state}";
        
    }

    public function cryptOriginUrl(){
        $url=substr(request()->fullUrl(), strlen(request()->root()));
        $url_encriptada = Crypt::encrypt($url);
        // $url_encriptada = substr($url_encriptada, 0, 20);
        // $url_encriptada = bin2hex($url_encriptada);
        return  $url_encriptada;
        // return  substr($url_encriptada, 0, 16);


    }
    public function getOriginUrl($encrypted){
        // Desciframos la clase encriptada
        // $texto_desencriptado = hex2bin($url);
        $texto_desencriptado = Crypt::decrypt($encrypted); //, config('app.key'), 'chacha20');
        return $texto_desencriptado;
    }

    public function showLoginForm(){
       return response()->view('ajtarragona-tid::login');
    }


    /**
     * Retorna si hay una sesion iniciada en valid para la aplicacion
     */
    public function isAuthenticated(){
       $ret = $this->getAuth();
       return !is_null($ret);
    }

    /**
     * Retorna la info de  sesion
     */
    public function getAuth(){
        return session(self::$SESSION_NAME,null);
        
    }
    

    /**
     * Retorna la info del usuario en sesion
     */
    public function getUser(){
        $ret=$this->getAuth();
        return $ret["user"]??null;
    }

    /**
     * Retorna la token de sesion
     */
    public function getToken(){
        $ret=$this->getAuth();
        return $ret["token"]["access_token"]??null;
    }

 
    /**mete la info del token y el usuario en sesion */
    public function setAuth($token,$user){
        return session([self::$SESSION_NAME => [
            'token'=>$token,'user'=>$user
        ]]);
    }
    public function unsetAuth(){
        return session()->forget(self::$SESSION_NAME);
    }
 

     public function getRedirectUri(){
        $config=config('tid');
        //si se especifica en la config, se coge la url de ahí, si no se coge la por defecto del package
        return $config["redirect_uri"] ? $config["redirect_uri"] : route('tid.handleResponse');
        
     }

    /**
     * Se valida en Valid y retorna la info del usuario
     */
    public function authenticate($code){
        $config=config('tid');
     
        $client = new Client();

        $response = $client->request('POST', $config["token_url"],  ['form_params'=>[
            'code' => $code,
            'client_id' => $config["client_id"],
            'client_secret' => $config["client_secret"],
            'redirect_uri'  => $this->getRedirectUri(),
            'grant_type' => 'authorization_code',
        ]]);

        $token_info = json_decode($response->getBody());

        if($token_info->error??null){
            abort(401,$token_info->error);
        }else{
            //recojo info del usuario
            $response = $client->request('GET', $config["user_url"],  ['query'=>[
                'AccessToken' => $token_info->access_token,
            ]]);
    
            $user_info=json_decode($response->getBody());
    
            if($user_info->status=="ko"){
                abort(401,$user_info->error);
            }else{
                $this->setAuth($token_info, $user_info);
                return true;
            }
        }
        return false;
        
    }


    /**
     * Se deautentica en Valid 
     */
    public function deAuthenticate(){
        $this->unsetAuth();
        return;

        $config=config('tid');
        $client = new Client();

        $client->request('GET', $config["logout_url"],  ['query'=>[
            'token' => $this->getToken(),
        ]]);

        
    }

    
}
  