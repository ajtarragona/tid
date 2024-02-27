<?php

namespace Ajtarragona\TID\Models;

use Exception;
use TID;

class TIDUser
{
    
   
    public function __construct($attributes = [])
    {
        foreach($attributes as $key=>$value){
            $this->{$key} = $value;
        }
        if($this->identifier && !$this->identifierType){
            $this->identifierType=self::validaNifCifNie($this->identifier);
        }
        if($this->surnames && !$this->surname1 ){
            $sur=explode(" ",$this->surnames);
            $this->surname1=  $sur[0] ??null;
            $this->surname2=  $sur[1] ??null;
        }
    }
    

    public $identifier;//	Document identificador de l’usuari. L’identificador por ser un NIF, un NIE o un número de passaport.
    public $prefix;//	Codi o prefix internacional del telèfon. Per exemple 0034 per al territori espanyol.
    public $phone;//	Número de telèfon mòbil de l’usuari.
    public $identifierType;//	Tipus de document d'identitat. 1=NIF, 2=NIE, 3=Passaport, 4=Altres (targeta de residència comunitària, permís de residència de treball, document identificador d’un país de la CE). Només si l’usuari s’ha autenticat amb idCAT Mòbil o MobileID.
    public $name;//	El nom de l’usuari (en cas que el mecanisme de validació el proporcioni).
    public $surnames;//	Els cognoms de l’usuari (en cas que el mecanisme de validació el proporcioni).
    public $surname1;//	Primer cognom de l’usuari (en cas que el mecanisme de validació proporcioni els cognoms per separat).
    public $surname2;//	Segon cognom de l’usuari (en cas que el mecanisme de validació proporcioni els cognoms per separat i el segon cognom estigui informat).
    public $countryCode;//	Codi de país de l’usuari en format ISO 3166-1 (en cas que el mecanisme de validació el proporcioni).
    public $email;//	El correu de l’usuari (en cas que el mecanisme de validació el proporcioni).
    public $userCertificate;//	Certificat digital de l’usuari si aquest s’ha autenticat mitjançant certificat.
    public $certificateType;//	En cas d’autenticació amb certificat digital, tipus de certificat:
   
    public $companyId;//	En cas d’autenticació amb certificat digital, CIF vinculat al certificat si aquest està informat.
    public $companyName;//	En cas d’autenticació amb certificat digital, nom de l’empresa vinculat al certificat si aquest està informat.
    public $method;//	Mètode d’autenticació emprat per l’usuari (idcatmobil, certificat, clave, mobileid, mobileconnect).
    public $assuranceLevel;//	Nivell de seguretat de l’autenticació practicada d’acord amb el ReIdAS (low, substantial, high):
    public $error;//	En cas d’error, missatge descriptiu de l’error que s’ha produït.
    
    protected static  $assuranceLevelDescriptions = [
        "Baix" =>"idCAT Mòbil acreditat telemàticament.",
        "Substancial" =>"idCAT Mòbil acreditat amb certificat o presencialment, idCAT Mobile Connect, Cl@ve, certificat qualificat en programari.",
        "Alt" =>"certificat qualificat en targeta."
    ];

    protected static $certificateTypeDescriptions = [
        0 =>"Persona física",
        1 =>"Persona jurídica",
        2 =>"Component SSL",
        3 =>"Seu electrònica",
        4 =>"Segell electrònic",
        5 =>"Empleat públic",
        6 =>"Entitat sense personalitat jurídica",
        7 =>"Empleat públic amb pseudònim",
        8 =>"Qualificat de segell",
        9 =>"Qualificat d’autenticació de lloc web",
        10 =>"Certificat de segell de temps",
        11 =>"Representant de persona jurídica",
        12 =>"Representant d’entitat sense personalitat jurídica"
    ];

    protected static $identifierTypeDescriptions = [
        1=>"NIF (Número d'identificació fiscal)", 
        2=>"NIE (Número d'identificació de l'estranger) ", 
        3=>"Passaport", 
        4=>"Altres (targeta de residència comunitària, permís de residència de treball, document identificador d'un país de la CE)",
        5=>"CIF (Codi d'Identificació Fiscal)"
    ];

    public static function getIdentifierTypeDescriptions(){

        return collect(self::$identifierTypeDescriptions)->map(function($item){
            return __('messages.'.$item);
        })->all();
    }
    public function getIdentifierTypeDescription(){
        $ret=self::$identifierTypeDescriptions[$this->identifierType??4] ?? null;
        if($ret) return __('messages.'.$ret);
        return $ret;
    }
    public function getCertificateTypeDescription(){
        return self::$certificateTypeDescriptions[$this->certificateType??0] ?? null;
    }
    public function getAssuranceLevelDescription(){
        return self::$assuranceLevelDescriptions[$this->assuranceLevel??0] ?? null;
    }
    
    public function getFullName(){
        $ret=[
            $this->name
        ];
        if($this->surname1) $ret[]=$this->surname1;
        if($this->surname2) $ret[]=$this->surname2;
        return implode(" ", $ret);
    }


 
    public function isNIF(){
        return $this->identifierType==1;
    }

    public function isNIE(){
        return $this->identifierType==2;
    }

    public function isPassaport(){
        return $this->identifierType==3;
    }

    public function isCIF(){
        return $this->identifierType==5;
    }

    public function getPersonType(){
        // 5== CIF, son empresas
        return $this->isCIF() ? "J":"F";
    }


    
    public function getIdentifierNumber(){
        if($this->isNIF() || $this->isCIF()){
            //nif y cifs cojo todo menos el último caracter
            return substr($this->identifier,0,strlen($this->identifier)-1);
        }else{
            //nies cojo todo
            return $this->identifier;
        }
    }




    public function getIdentifierCntrlDigit(){
       
        // $tipus=self::validaNifCifNie($this->identifier);
        if($this->isNIF() || $this->isCIF()){
            //nif y cifs cojo el último caracter
            return substr($this->identifier,strlen($this->identifier)-1);
        }else{
            //resto cojo todo
            return null;
        }
        
    }


    public static function validaPasaporte($pasaporte)
    {
        return true;
        // $patron = '/^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}$/';
        // return preg_match($patron, $pasaporte);
    }

    public static function validaNifCifNie($identidad)
    {
        try {
            //Copyright ©2005-2011 David Vidal Serra. Bajo licencia GNU GPL.
            //Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
            //puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt(1)
            //Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
            //con la condicion de que el autor jamas sera responsable de su uso.
            //Returns: 1 = NIF ok, 5 = CIF ok, 3 = NIE ok, -1 = NIF bad, -5 = CIF bad, -3 = NIE bad, 0 = ??? bad
            $identidad = strtoupper($identidad);
            for ($i = 0; $i < 9; $i++) {
                $num[$i] = substr($identidad, $i, 1);
            }
            //si no tiene un formato valido devuelve error
            if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $identidad)) {
                return 0;
            }
            //comprobacion de NIFs estandar
            if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $identidad)) {
                if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($identidad, 0, 8) % 23, 1)) {
                    return 1;
                } else {
                    return -1;
                }
            }
            //algoritmo para comprobacion de codigos tipo CIF
            $suma = $num[2] + $num[4] + $num[6];
            // dd($suma);
            // dd($num);
            for ($i = 1; $i < 8; $i += 2) {
                // echo ($i);
                // dump("I:" +$i,  intval(substr((2 * $num[$i]), 0, 1)), intval(substr((2 * $num[$i]), 1, 1)));
                    
                $suma += intval(substr((2 * $num[$i]), 0, 1)) + intval(substr((2 * $num[$i]), 1, 1));
            }
            // dump("SUMA",$suma);
            $n = 10 - substr($suma, strlen($suma) - 1, 1);
            //comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
            if (preg_match('/^[KLM]{1}/', $identidad)) {
                if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($identidad, 1, 8)
                    % 23, 1)) {
                    return 1;
                } else {
                    return -1;
                }
            }
            //comprobacion de CIFs
            if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $identidad)) {
                if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)) {
                    return 5;
                } else {
                    return -5;
                }
            }
            //comprobacion de NIEs
            if (preg_match('/^[XYZ]{1}/', $identidad)) {
                if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(
                    array('X', 'Y', 'Z'),
                    array('0', '1', '2'),
                    $identidad
                ), 0, 8) % 23, 1)) {
                    return 2;
                } else {
                    return -2;
                }
            }
            //si todavia no se ha verificado devuelve error
            return 0;
        } catch (Exception $e) {
            // dd($e);
            return false;
        }
    }

}