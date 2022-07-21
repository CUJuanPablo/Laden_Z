<?php

use Illuminate\Support\Facades\Storage;


namespace App\Clases;

/**
* Clase para gestionar solicitudes a servidores velneo
*/
class ApiEmde{
	
	var $url="";
	var $status="";
	var $servicio="";
	var $message="";
	var $arrErrors=array();
	var $data=array();
	var $token="";
	var $clave="";

	function __construct()
	{
		$this->url=env("API_EMDE_ENDPOINT");
		$this->token=env("API_EMDE_TOKEN");
		$this->clave=env("API_EMDE_CLAVE");

		$this->data=[];
	}

	public function getErrors(){
		return $this->arrErrors;
	}

	public function validar(){
		return (count($this->arrErrors)>0)?false:true;
	}

	public function llamarServicio($servicio,$arrParams=[]){

		$this->data=array();
		$this->arrErrors=array();		
		$this->servicio=$servicio;
		try {

			$response=\Illuminate\Support\Facades\Http::withToken($this->token)
				->withHeaders(["Clave"=>$this->clave])
				->accept('application/json')
				->post($this->url.$this->servicio,
						$arrParams
					);

			if(isset($response->object()->status)){
				$this->status=$response->object()->status;
			}
			
			if(isset($response->object()->data)){
				$this->data = $response->object()->data;
			}
			
			if(isset($response->object()->message)){
				$this->message = $response->object()->message;
			}
			
			if(isset($response->object()->errors)){
				$this->arrErrors[]=$response->object()->errors;
			}
			
    	}catch (Exception $e) {
    		$this->status="error";
		    $this->arrErrors[]=array("servicio"=>$e->getMessage());
		    $this->saveLog($servicio,$arrParams,$response->body(),$this->arrErrors);
		    //echo "error";
		    return;
		}

		if(env('APP_DEBUG')){
			$this->saveLog($servicio,$arrParams,$response->body(),$this->arrErrors);
		}

	}

	public function saveLog($servicio,$request,$response,$arrErrors){
		
		$log="";
		$log.="SERVICIO: {$this->url}{$servicio}"."?v=".date("YmdHis")."\n";
		$log.="FECHA HORA: ".date("Y-m-d H:i:s")." \n";
		$log.="PARAM ENVIADOS:\n";
		$log.=print_r($request, true);
		$log.="\nPARAM RETORNO:\n";
		$log.=print_r($response, true);
		$log.="\nERRORES REG:\n";
		$log.=print_r($arrErrors, true);

		$servicio=str_replace("/","_",$servicio);

		\Storage::put("apilogs/{$servicio}_".date("Y_m_d_H_i_s").".log",$log);

	}

}