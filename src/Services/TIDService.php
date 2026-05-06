<?php
namespace Ajtarragona\TID\Services;

use Ajtarragona\TID\Models\TIDUser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Crypt;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TIDService{

    public static $SESSION_NAME = 'aoc_valid_info';



    public function makeBaseUrl($type, $version=null, $env=null){
        $config=config('tid');
        return $config["urls"][$version?$version:$config["version"]][$env?$env:$config["environment"]] . '/'. $config['paths'][$type]; 

    }

    public function makeValidUrl($state=null){
        
        $config=config('tid');
        
        $redirect_uri=$this->getRedirectUri();

       

        // $state=$state?$state:
        $state=$state?$state:$this->cryptOriginUrl();

        // dump($this->getOriginUrl($state));
        return $this->makeBaseUrl('auth')."?response_type=code&client_id={$config["client_id"]}&approval_prompt=auto&access_type={$config["access_type"]}&scope={$config["scope"]}&redirect_uri={$redirect_uri}&state={$state}";
        
    }

    // MODIFICACION CARLOS PARCHE IGUALES 
     public function cryptOriginUrl()
    {
        // Extrae la URL relativa (lo que ya tenías)
        $url = substr(request()->fullUrl(), strlen(request()->root()));
        
        // Encripta la URL
        $url_encriptada = Crypt::encrypt($url);
        
        // SOLUCIÓN: Limpieza para que sea "URL Safe"
        // 1. strtr sustituye '+' por '-' y '/' por '_'
        // 2. rtrim elimina los '=' del final
        return rtrim(strtr($url_encriptada, '+/', '-_'), '=');
    }
     // MODIFICACION CARLOS PARCHE IGUALES 
    public function getOriginUrl($encrypted)
    {
        // 1. Restauramos los caracteres que cambiamos para la URL
        // Convertimos los guiones '-' de vuelta a '+'
        // Convertimos los guiones bajos '_' de vuelta a '/'
        $original_base64 = strtr($encrypted, '-_', '+/');

        // 2. Desciframos
        // Importante: Crypt::decrypt utiliza base64_decode internamente,
        // el cual ignora la falta de los '==' al final y procesa la cadena correctamente.
        try {
            $texto_desencriptado = Crypt::decrypt($original_base64);
            return $texto_desencriptado;
        } catch (\Exception $e) {
            // Opcional: registrar el error si la desencriptación falla
            return null; 
        }
    }

    public function showLoginPage(){
        return response()->view('ajtarragona-tid::login');
    }


    public function renderLoginForm($options=[]){
        if(!is_array($options)) $options=[];
        return view('ajtarragona-tid::parts.login-form',$options)->render();
    }
    
    public function renderUserInfo($options=[]){
       $valid_user=$this->getUser();
       if(!is_array($options)) $options=[];
        return view('ajtarragona-tid::parts.user-info', array_merge($options,compact('valid_user')))->render();
    }
   

    public function renderTokenInfo($options=[]){
        $valid_token=$this->getTokenInfo();
        if(!is_array($options)) $options=[];
        return view('ajtarragona-tid::parts.token-info',array_merge($options, compact('valid_token')))->render();
    }
    public function renderLogoutButton($options=[]){
        if(!is_array($options)) $options=[];
        return view('ajtarragona-tid::parts.logout-button',$options)->render();
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
        // dump('getAuth',self::$SESSION_NAME,session(self::$SESSION_NAME,null) );
        return session(self::$SESSION_NAME,null);
        
    }
    

    /**
     * Retorna la info del usuario en sesion
     */
    public function getUser(){
        $ret=$this->getAuth();
        if($ret && isset($ret["user"])){
            return new TIDUser($ret["user"]);
            // return (is_array($ret["user"])) ? new json_decode(json_encode($ret["user"]), FALSE) : $ret["user"] ;
        }
        return null;
    }

    /**
     * Retorna la token de sesion
     */
    public function getToken(){
        // dump('getToken');
        $ret=$this->getAuth();
        // dd($ret);
        return $this->getTokenInfo()->access_token??null;
    }
    
    public function getTokenInfo(){
        $ret=$this->getAuth();
        if($ret && isset($ret["token"])){
            return (is_array($ret["token"])) ? json_decode(json_encode($ret["token"]), FALSE) : $ret["token"] ;
        }
        return null;
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
        try{

            $url=$this->makeBaseUrl('token');
            

            $params=[
                'code' => $code,
                'client_id' => $config["client_id"],
                'client_secret' => $config["client_secret"],
                'redirect_uri'  => $this->getRedirectUri(),
                'grant_type' => 'authorization_code',
            ];

            if($config["log"]) Log::debug("[TID] Calling POST: ". $url ." with Parameters: \n". json_pretty($params) );

            $response = $client->request('POST', $url,  ['form_params'=>$params]);

            $token_info = json_decode($response->getBody());
            if($config["log"]) Log::debug("[TID] Return \n". json_pretty($token_info)  );
            
            if($token_info->error??null){
                if($config["log"]) Log::debug("[TID] Error: ". $token_info->error );
                abort(401,$token_info->error);
            }else{

                //recomiendan hacer el logout aqui

                $client->request('GET', $this->makeBaseUrl('logout')."?token=".$token_info->access_token);
            

                //recojo info del usuario
                $url=$this->makeBaseUrl('user');
                $params=[
                    'AccessToken' => $token_info->access_token,
                ];
                if($config["log"]) Log::debug("[TID] Calling GET: ". $url ." with Parameters: \n". json_pretty($params) );
    
                $response = $client->request('GET', $url,  ['query'=>$params]);
        
                $user_info=json_decode($response->getBody());
                if($config["log"]) Log::debug("[TID] Return \n". json_pretty($user_info)  );
                if(!$user_info){
                    if($config["log"]) Log::debug("[TID] Error" );
                    abort(401);
                }else if($user_info->status=="ko"){
                    if($config["log"]) Log::debug("[TID] Error: ". $token_info->error );
                    abort(401,$user_info->error);
                }else{
                    $this->setAuth($token_info, $user_info);
                    return true;
                }
            }
        }catch(Exception $e){
            // dd($e);
            if($config["log"]) Log::debug("[TID] Error: ". $e->getMessage() );
                
        }
        return false;
        
    }


    /**
     * Se deautentica en Valid 
     */
    public function deAuthenticate(){
        
        try{
            $config=config('tid');
            $client = new Client();
            
            $client->request('GET', $this->makeBaseUrl('revoke')."?token=".$this->getToken());
            $client->request('GET', $this->makeBaseUrl('logout')."?token=".$this->getToken());
            $this->unsetAuth();
        }catch(Exception $e){
            // dd($e);
            $this->unsetAuth();
            
        }
            
        return;
        
    }

    
}
  