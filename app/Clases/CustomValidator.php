<?php

namespace App\Clases;

use Validator;
use App\Clases\Tools;

//Para el manejo de response en json
class CustomValidator
{
    var $errors=array();
    var $_rules=[];
    var $_cErrors=[];
    var $_attributeLabels=[];

    public function validate($arrData,$arrRules,$arrCustmoMessages=[]){
        $validator = Validator::make($arrData,$arrRules,$arrCustmoMessages);
        
        $validator->setAttributeNames($this->_attributeLabels); 
        
        if($validator->fails()){
            foreach ($validator->errors()->messages() as $attribute => $message) {
                foreach ($message as $m) {
                    $this->addCustomError($attribute,$m);
                }
            }
            return false;
        }else{
            return true;
        }
    }

    public function addCustomError($attribute,$message){
        $message=mb_strtoupper($message);
        $arrAux=[];
        $find=false;
        foreach ($this->errors as $error) {
            if($error["attribute"]==$attribute){
                $error["message"][]=$message;
                $find=true;
            }
            $arrAux[]=[
                "attribute"=>$error["attribute"],
                "message"=>$error["message"]
            ];
        }
        if(!$find){
            $arrAux[]=[
                "attribute"=>$attribute,
                "message"=>[$message],
            ];
        }

        $this->errors=$arrAux;
    }

    public function getAttributeLabels(){
        return $this->_attributeLabels;
    }

    public function setAttributeLabels($arrAttributeLabels){
        $this->_attributeLabels=$arrAttributeLabels;
    } 

    public function isValid(){
        if(count($this->errors)){
            return false;
        }else{
            return true;
        }
    }


    //Validaciones y manejo de errores VALIDATOR
    public function setRules($arrRules){
        $this->_rules=$arrRules;
    }

    public function clearErrors(){
        $this->errors=[];
    }    

    public function getErrors(){
        return $this->errors;
    }

    public function getHtmlFormatErrors(){

        $string="";

        foreach($this->errors as $errors){

            foreach ($errors as $attr) {
                $string.="<li>".$attr["message"]."</li>";
            }

        }

        return "<ul>".$string."</ul";
    }

    public function getFormatErrors(){

        $arrErrors=[];

        foreach ($this->errors as $error) {
            foreach ($error["message"] as $message) {
                $arrErrors[]=$message;
            }
            
        }

        return $arrErrors;
    }

}