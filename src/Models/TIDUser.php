<?php

namespace Ajtarragona\TID\Models;

use TID;

class TIDUser
{
    
   
    public function __construct($attributes = [])
    {
        foreach($attributes as $key=>$value){
            $this->{$key} = $value;
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
    
    protected $assuranceLevelDescriptions = [
        "Baix" =>"idCAT Mòbil acreditat telemàticament.",
        "Substancial" =>"idCAT Mòbil acreditat amb certificat o presencialment, idCAT Mobile Connect, Cl@ve, certificat qualificat en programari.",
        "Alt" =>"certificat qualificat en targeta."
    ];

    protected $certificateTypeDescriptions = [
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

    protected $identifierTypeDescriptions = [
        1=>"NIF (Número d'identificació fiscal)", 
        2=>"NIE (Número d'identificació de l'estranger) ", 
        3=>"Passaport", 
        4=>"Altres (targeta de residència comunitària, permís de residència de treball, document identificador d'un país de la CE)",
        5=>"CIF (Codi d'Identificació Fiscal)"
    ];

    public function getIdentifierTypeDescription(){
        return $this->identifierTypeDescriptions[$this->identifierType??4] ?? null;
    }
    public function getCertificateTypeDescription(){
        return $this->certificateTypeDescriptions[$this->certificateType??0] ?? null;
    }
    public function getAssuranceLevelDescription(){
        return $this->assuranceLevelDescriptions[$this->assuranceLevel??0] ?? null;
    }
    
    public function getFullName(){
        $ret=[
            $this->name
        ];
        if($this->surname1) $ret[]=$this->surname1;
        if($this->surname2) $ret[]=$this->surname2;
        return implode(" ", $ret);
    }

}