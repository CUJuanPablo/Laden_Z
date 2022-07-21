<?php

namespace App\Clases;

use Illuminate\Support\Facades\Auth;
use App\Clases\NumeroConLetra;

//Para el manejo de response en json
class Tools{

	const TELEFONO = "(####) ##-##-##";
	const RFC = "####-######-####";
	const CURP= "####-######-######-##";

	public static function jsonEncode($data){
		return $data;
	}

	public static function jsonResponse($status="success",$message="",$arrErrors=[],$data=[]){
		return ["status"=>$status,"message"=>$message,"errors"=>[],"data"=>$data];
	}

	public static function jsonResponseSuccess($message="",$data=[]){
		return ["status"=>"success","message"=>$message,"errors"=>[],"data"=>$data];
	}

	public static function jsonResponseError($message="",$arrErrors=[],$data=[]){
		return ["status"=>"error","message"=>$message,"errors"=>$arrErrors,"data"=>$data];
	}

	public static function limpiarCadena($cadena,$arrChars=["(",")","-","/"," "]){

		$cadenaFormateada="";
		foreach ($arrChars as $char) {
			$cadena=str_replace($char,"",$cadena);
		}

		return $cadena;
	}

	public static function getRandName($largo=5,$timestamp=true){

		$text= "ABCDEFGHJKMNPQRSTUVWXYZ123456789";
		$rand= substr(str_shuffle($text),0,$largo);

		if($timestamp){
			$rand=date("Ymdhis")."_".$rand;
		}

		return $rand;

	}

	public static function getRandNumber($largo=4){

		$text= "12345678901234567890123456789012345678901234567890";
		$rand= substr(str_shuffle($text),0,$largo);

		return $rand;

	}	

	public static function getBreadCrumb($index){

		$arrBreadCrumbs=[];

		$arrBreadCrumbs["RegistroEmpresa"]=[
            [
                "titulo"=>"Registro Empresa",
                //"link"=>url("registro/empresa")
            ],
            [
                "titulo"=>"Registro Usuario",
                //"link"=>url("registro/usuario")
            ],
            [
                "titulo"=>"Terminar",
                //"link"=>url("registro/terminar")
            ]
		];

		$arrBreadCrumbs["RegistroEncuestador"]=[
            [
                "titulo"=>"Generales",
                //"link"=>url("registro/empresa")
            ],
            [
                "titulo"=>"Domicilio",
                //"link"=>url("registro/usuario")
            ],
            [
                "titulo"=>"Terminar",
                //"link"=>url("registro/terminar")
            ]
		];

		return (isset($arrBreadCrumbs[$index]))?$arrBreadCrumbs[$index]:[];
	}

	//Convierte un array de modelos a un array para select
	public static function modelsToArray($models,$value,$label,$emptyLabel=""){
		$array=[];
		if($emptyLabel!=""){
			$array[""]=$emptyLabel;
		}

		foreach ($models as $model) {
			$array[$model->$value]=$model->$label;
		}
		return $array;
	}


	public static function formatShortText($text,$size=80){
		if(strlen($text)>$size){
			$text=substr($text,0,$size);
			$text=$text."...";
		}
		return $text;
	}

	public static function formatoFolio($input,$largo=4){
		return str_pad($input, $largo,"0",STR_PAD_LEFT);
	}

	public static function setEmpresaId($id){
		session(["empresa_id"=>$id]);
	}

	public static function getEmpresaId(){
		return session("empresa_id");
	}

	public static function getEmpresa(){

		$empresa=\Modules\Models\Empresa::find(session("empresa_id"));

		if($empresa){
			return $empresa;
		}else{
			return new \Modules\Models\Empresa;
		}
	}

	public static function esCliente(){
		$empresa=\Modules\Models\Empresa::find(session("empresa_id"));
		if($empresa->tipo_licencia=="CLIENTE"){
			return true;
		}else{
			return false;
		}
	}

	public static function esEmpresa(){
		$empresa=\Modules\Models\Empresa::find(session("empresa_id"));
		if($empresa->tipo_licencia=="EMPRESA"){
			return true;
		}else{
			return false;
		}
	}

	public static function esGestion(){
		$empresa=\Modules\Models\Empresa::find(session("empresa_id"));
		if($empresa->tipo_licencia=="GESTION"){
			return true;
		}else{
			return false;
		}
	}

	public static function esPrincipal(){
		$empresa=\Modules\Models\Empresa::find(session("empresa_id"));
		if($empresa->es_principal){
			return true;
		}else{
			return false;
		}
	}

	public static function getEmpresaPrincipal(){
		$empresa=\Modules\Models\Empresa::where("es_principal",1)->first();
		return $empresa;
	}

	public static function getUserId(){
		return \Auth::id();
	}

	public static function getUser(){
		return \Auth::user();
	}

	public static function formatoMoneda($cantidad,$llevaSimbolo=true,$decimales=2){

		//Cortamos la cantidad para que no redondee
		$posPunto=strpos($cantidad,".");
		if($posPunto!==false){
			$cantidad=substr($cantidad,0,$posPunto+3);
		}

		$simbolo=($llevaSimbolo)?"$ ":$simbolo="";
		$label = $simbolo.number_format($cantidad,$decimales);
		return $label;
	}	

	public static function formatoCantidad($cantidad,$decimales=2){

		
		$label = preg_replace("/\.?0*$/",'',$cantidad);
		return $label;
	}


	public static function formatoFechaCliente($string){
		if($string!=""){		
			if(strlen($string)==10){
				return date('d-m-Y',strtotime($string));
			}elseif(strlen($string)>=10){
				return date('d-m-Y H:i',strtotime($string));
			}
		}else{
			return "";
		}
	}

	public static function formatoFechaServidor($date){
		$arrDate=explode("/",$date);
        return $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
	}

	public static function formatoFechaDMY($fecha){
		if($fecha!=""){
			$arrDate=explode("-",$fecha);
	        return $arrDate[2]."/".$arrDate[1]."/".$arrDate[0];
	    }
	}

	public static function formatoFechaDocumento($string){
		if($string!=""){		
			if(strlen($string)==10){
				return date('d-m-y',strtotime($string));
			}elseif(strlen($string)>=10){
				return date('d-m-y H:i',strtotime($string));
			}
		}else{
			return "";
		}
	}

	public static function getMesFormatoCorto($mes){
		$meses= [
			""=>"MES",
			"01"=>"Ene",
			"02"=>"Feb",
			"03"=>"Mar",
			"04"=>"Abr",
			"05"=>"May",
			"06"=>"Jun",
			"07"=>"Jul",
			"08"=>"Ago",
			"09"=>"Sep",
			"10"=>"Oct",
			"11"=>"Nov",
			"12"=>"Dic",
		];

		return (isset($meses[$mes]))?$meses[$mes]:"MES";
	}

	public static function getMesFormatoLargo($mes){
		$meses= [
			""=>"MES",
			"01"=>"Enero",
			"02"=>"Febrero",
			"03"=>"Marzo",
			"04"=>"Abril",
			"05"=>"Mayo",
			"06"=>"Junio",
			"07"=>"Julio",
			"08"=>"Agosto",
			"09"=>"Septiembre",
			"10"=>"Octubre",
			"11"=>"Noviembre",
			"12"=>"Diciciembre",
		];

		return (isset($meses[$mes]))?$meses[$mes]:"MES";
	}	

	public static function formatoFechaCorta($fecha,$glue="-"){

		$formatoFecha="";

		if($fecha!=""){
			$anio=substr($fecha,0,4);
			$mes=substr($fecha,5,2);
			$dia=substr($fecha,8,2);

			$mesFormato=self::getMesFormatoCorto($mes);

			return $dia.$glue.$mesFormato.$glue.$anio;
		}

		
	}

	public static function formatoFechaLarga($fecha){

		$formatoFecha="";

		if($fecha!=""){
			$anio=substr($fecha,0,4);
			$mes=substr($fecha,5,2);
			$dia=substr($fecha,8,2);

			$mesFormato=self::getMesFormatoLargo($mes);

			return "$dia de $mesFormato de $anio";
		}

		
	}

	public static function formatoFechaHoraCorta($fechaHora){

			if($fechaHora=="")return "";

			$fechaFormato=self::formatoFechaCorta($fechaHora);

			$horaFormato=self::formatoHoraCorta($fechaHora);

			return $fechaFormato." ".$horaFormato;
		
	}	

	public static function formatoDiaFechaCorta($fecha){

			if($fecha!=""){
				$anio=substr($fecha,0,4);
				$mes=substr($fecha,5,2);
				$dia=substr($fecha,8,2);

				$diaNumero=date('w',strtotime($fecha));

				$arrDias=self::getArrDias();

				$nombreDia=(isset($arrDias[$diaNumero]))?$arrDias[$diaNumero]:"";

				$mesFormato=self::getMesFormatoCorto($mes);

				if(date("Y")==$anio){
					return "$nombreDia $dia-$mesFormato";
				}else{
					return "$nombreDia $dia-$mesFormato-$anio ";
				}

				
			}

			
		
	}	

	public static function formatoDiaFechaHoraCorta($fechaHora){

			if($fechaHora!=""){
				$anio=substr($fechaHora,0,4);
				$mes=substr($fechaHora,5,2);
				$dia=substr($fechaHora,8,2);

				$diaNumero=date('w',strtotime($fechaHora));

				$arrDias=self::getArrDias();

				$nombreDia=(isset($arrDias[$diaNumero]))?$arrDias[$diaNumero]:"";

				$mesFormato=self::getMesFormatoCorto($mes);

				$horaFormato=self::formatoHoraCorta($fechaHora);

				if(date("Y")==$anio){
					return "$nombreDia $dia-$mesFormato $horaFormato";
				}else{
					return "$nombreDia $dia-$mesFormato-$anio $horaFormato";
				}

				
			}

			
		
	}	

	public static function formatoRangoFechas($fechaInicio,$fechaFinal){

		$formato="";

		if($fechaInicio!="" && $fechaFinal!=""){
			$formato=$fechaInicio." al ".$fechaFinal;
		}

		if($fechaInicio!="" && $fechaFinal==""){
			$formato=$fechaInicio." a la actualidad";
		}

		if($fechaInicio!="" && $fechaFinal==""){
			$formato="no definido al ".$fechaFinal;
		}

		return $formato;

	}

	public static function getHoras(){
		$arrHoras=[];
		for ($i=0; $i < 24 ; $i++) { 
			$hora=str_pad($i, 2,"0",STR_PAD_LEFT);
			$arrHoras[$hora]=$hora;
		}
		return $arrHoras;
	}

	public static function getHorasFormato(){
		$arrHoras=[
			"07"=>"07 AM",
			"08"=>"08 AM",
			"09"=>"09 AM",
			"10"=>"10 AM",
			"11"=>"11 AM",
			"12"=>"12 IM",
			"13"=>"01 PM",
			"14"=>"02 PM",
			"15"=>"03 PM",
			"16"=>"04 PM",
			"17"=>"05 PM",
			"18"=>"06 PM",
			"19"=>"07 PM",
			"20"=>"08 PM",
			"21"=>"09 PM",
			"22"=>"10 PM",
		];
		

		return $arrHoras;
	}

	public static function getMinutos(){
		$arrMinutos=[];
		for ($i=0; $i < 60 ; $i++) { 
			$minuto=str_pad($i, 2,"0",STR_PAD_LEFT);
			$arrMinutos[$minuto]=$minuto;
		}
		return $arrMinutos;
	}

	public static function getMinutosFormato(){
		$arrMinutos=[];
		for ($i=0; $i < 60 ; $i+=10) { 
			$minuto=str_pad($i, 2,"0",STR_PAD_LEFT);
			$arrMinutos[$minuto]=$minuto;
		}
		return $arrMinutos;
	}

	public static function getMesesFormato(){
		return [
			""=>"MES",
			"01"=>"ENE",
			"02"=>"FEB",
			"03"=>"MAR",
			"04"=>"ABR",
			"05"=>"MAY",
			"06"=>"JUN",
			"07"=>"JUL",
			"08"=>"AGO",
			"09"=>"SEP",
			"10"=>"OCT",
			"11"=>"NOV",
			"12"=>"DIC",
		];
	}

	public static function getArrDias(){
		return [
			0=>"Dom",
			1=>"Lun",
			2=>"Mar",
			3=>"Mié",
			4=>"Jue",
			5=>"Vie",
			6=>"Sáb",
		];
	}

	public static function getMeses(){
		return [
			""=>"MES",
			1=>"ENE",
			2=>"FEB",
			3=>"MAR",
			4=>"ABR",
			5=>"MAY",
			6=>"JUN",
			7=>"JUL",
			8=>"AGO",
			9=>"SEP",
			10=>"OCT",
			11=>"NOV",
			12=>"DIC",
		];
	}

	public static function getMesesLargo(){
		return [
			""=>"MES",
			1=>"ENERO",
			2=>"FEBRERO",
			3=>"MARZO",
			4=>"ABRIL",
			5=>"MAYO",
			6=>"JUNIO",
			7=>"JULIO",
			8=>"AGOSTO",
			9=>"SEPTIEMBRE",
			10=>"OCTUBRE",
			11=>"NOVIEMBRE",
			12=>"DICIEMBRE",
		];
	}

	public static function getAnios($anioFin=null,$anioInicio=null){
		$arrAnios=[];

		if(is_null($anioInicio)){
			$anioInicio=date('Y')-90;
		}

		if(is_null($anioFin)){
			$anioFin=date('Y');
		}

		$arrAnios[""]="AÑO";
		for ($i=$anioFin; $i >= $anioInicio ; $i--) { 
			$arrAnios[$i]=$i;
		}

		return $arrAnios;
	}

	public static function getDias(){
		$arrAnios=[];

		$arrAnios[""]="DIA";
		for ($i=1; $i <= 31 ; $i++) { 
			$arrAnios[$i]=$i;
		}

		return $arrAnios;
	}

	public static function getFechaHora($fechaHora){
		
		$arrFechaHora=["fecha"=>"","hora"=>"","minuto"=>""];

		if($fechaHora!=""){
			$arrFechaHora["fecha"]=substr($fechaHora,0,10);
			$arrFechaHora["hora"]=substr($fechaHora,11,2);
			$arrFechaHora["minuto"]=substr($fechaHora,14,2);
		}

		return $arrFechaHora;
	}

	public static function getRangoPorcentaje($inicio=0){

		$arrPorcentaje=[];
		for ($i=$inicio; $i <= 100 ; $i+=10) { 
			$arrPorcentaje[$i]=$i." %";
		}
		return $arrPorcentaje;

	}

	/*public static function getOpcionesEvidencias(){
		return [
			"NO PRESENTA EVIDENCIA"=>"NO PRESENTA EVIDENCIA",
			"CONSTANCIA"=>"CONSTANCIA",
			"CERTIFICADO"=>"CERTIFICADO"
		];
	}*/

	public static function getSiNo(){
		return [
			"SI"=>"SI",
			"NO"=>"NO"
		];
	}

	public static function getMesAnio(){
		return [
			""=>"SELECCIONAR",
			"MES"=>"MES(ES)",
			"ANIO"=>"AÑO(S)"
		];
	}

	public static function getSiNoEntero($emptyLabel=""){
		if($emptyLabel==""){
			return [
				1=>"SI",
				0=>"NO"
			];
		}else{
			return [
				""=>$emptyLabel,
				1=>"SI",
				0=>"NO"
			];
		}
	}

	public static function getTramitadoEntero(){
		return [
			1=>"TRAMITADO",
			0=>"NO TRAMITADO"
		];
	}	

	public static function getEntero($inicio,$fin,$emptyLabel){
			
		$arr=[];

		if($emptyLabel!=""){
			$arr[""]=$emptyLabel;
		}

		for($i=$inicio;$i<=$fin;$i++){
			$arr[$i]=$i;
		}

		return $arr;
	}

	public static function getTipoContrato(){
		return [
			""=>"SELECCIONAR",
			"DETERMINADO"=>"DETERMINADO",
			"EVENTUAL"=>"EVENTUAL",
			"INDETERMINADO"=>"INDETERMINADO",
			"PRACTICAS PROFESIONALES"=>"PRACTICAS PROFESIONALES",
			"PRUEBA"=>"PRUEBA",
			"SOCIEDAD"=>"SOCIEDAD",			
		];
	}

	public static function getDictamen(){
		return [
			""=>"SELECCIONAR",
			"RECOMENDADO"=>"RECOMENDADO",
			"CON RESERVAS"=>"CON RESERVAS",
			"NO RECOMENDADO"=>"NO RECOMENDADO"
		];
	}

	public static function getOrigenEmpleo(){
		return [
			""=>"SELECCIONAR",
			"IMSS"=>"IMSS",
			"CV"=>"CV"
		];
	}

	public static function getTipoEmpleo(){
		return [
			""=>"SELECCIONAR",
			"DECLARADO"=>"DECLARADO",
			"NO DECLARADO"=>"NO DECLARADO"
		];
	}

	public static function getTipoReferencia(){
		return [
			""=>"SELECCIONAR",
			"COMPLETA"=>"COMPLETA",
			"CORREO"=>"CORREO",
			"SIN CONTACTO"=>"SIN CONTACTO"
		];
	}

	public static function getCalidadReferencia(){
		return [
			""=>"SELECCIONAR",
			"INSTITUCIONAL"=>"INSTITUCIONAL",
			"CANDIDATO"=>"CANDIDATO",
		];
	}


	//# es el lugar de cada caracter
	public static function setMask($string,$mask){

		if($string==""){
			return "";
		}

		$formato="";

		$length = strlen($mask);

		$c=0;

		for ($i=0; $i<$length; $i++) {
		    
			if($mask[$i]=="#" || $mask[$i]=="0" || $mask[$i]=="A" ){
				if(isset($string[$c])){
					$formato.=$string[$c];
					$c++;
				}				
			}else{
				$formato.=$mask[$i];
			}

		}

		return strtoupper($formato);
	}

	public static function setBooleanFormato($bool,$cadenaTrue,$cadenaFalse){

		if($bool==="" || is_null($bool)){
			return "";
		}

		if($bool){
			return $cadenaTrue;
		}else{
			return $cadenaFalse;
		}	


	}

	public static function setVacioFormato($string,$cadenaTrue){
		if($string==""){
			return $cadenaTrue;
		}else{
			return $string;
		}	
	}

	public static function coalesce($valor1,$valor2="",$valor3=""){

		if($valor1!=""){
			return $valor1;
		}

		if($valor2!=""){
			return $valor2;
		}

		if($valor3!=""){
			return $valor3;
		}

	}

	public static function formatoCantidadVivienda($cantidad){

		if($cantidad==0 || $cantidad==""){
			return "--";
		}
		
		$label = number_format($cantidad,0);
		return $label;
	}	

	public static function setPeriodoFormato($cantidad,$periodo){

		$formato="";

		if($cantidad==1){
			if($periodo=="MES"){
				return "1 MES";
			}

			if($periodo=="ANIO"){
				return "1 AÑO";
			}
		}

		if($cantidad>1){
			if($periodo=="MES"){
				return "$cantidad MESES";
			}

			if($periodo=="ANIO"){
				return "$cantidad AÑOS";
			}
		}

	}

	public static function version(){
		return "?v=".date('YmdHis');
	}

	public static function getFechaFormato($anio="",$mes="",$dia=""){
		if($anio=="" && $mes=="" && $dia==""){
			return null;
		}else{

			if($mes<10)$mes="0".$mes;
			if($dia<10)$dia="0".$dia;

			return $anio."-".$mes."-".$dia;
		}

	}

	//Devuelve el html de un badge para el estatus de un estudio
	public static function getBadgeEstatusEstudio($estatus){

		$html="<span class=\"badge badge-light\">$estatus</span>";

		
		if(in_array($estatus,["PENDIENTE"])){
			$html="<span class=\"badge badge-secondary\">$estatus</span>";
		}

		if(in_array($estatus,["RECHAZADO AN","RECHAZADO CMC","RECHAZADO ENC"])){
			$html="<span class=\"badge badge-danger\">$estatus</span>";
		}

		if(in_array($estatus,["PROCESO"])){
			$html="<span class=\"badge badge-info\">$estatus</span>";
		}

		if(in_array($estatus,["UPGRADE","VISITA"])){
			$html="<span class=\"badge badge-warning\">$estatus</span>";
		}

		/*if(in_array($estatus,["INFO"])){
			$html="<span class=\"badge badge-info\">$estatus</span>";
		}*/

		if(in_array($estatus,["REVISION","PRELIMINAR","EVALUACION"])){
			$html="<span class=\"badge badge-primary\">$estatus</span>";
		}

		if(in_array($estatus,["CERRADO"])){
			$html="<span class=\"badge badge-success\">$estatus</span>";
		}

		if(in_array($estatus,["ELIMINADO"])){
			$html="<span class=\"badge badge-dark\">$estatus</span>";
		}

		//PARA CONTROL DE FACTURACION Y PAGOS, no afecta el campo estatus de conceptos
		if(in_array($estatus,["FACTURADO"])){
			$html="<span class=\"badge badge-info\">$estatus</span>";
		}

		if(in_array($estatus,["PAGADO"])){
			$html="<span class=\"badge badge-success\">$estatus</span>";
		}

		return $html;
	}

	public static function getBadgeEstatusOrdenServicio($estatus){

		$html="<span class=\"badge badge-light\">$estatus</span>";

		if(in_array($estatus,["PENDIENTE"])){
			$html="<span class=\"badge badge-secondary\">$estatus</span>";
		}		
		
		if(in_array($estatus,["REVISION","RECIBIDA","PROCESO","TERMINADO"])){
			$html="<span class=\"badge badge-primary\">$estatus</span>";
		}

		if(in_array($estatus,["FINALIZADO","FACTURADO","PAGADO"])){
			$html="<span class=\"badge badge-success\">$estatus</span>";
		}

		return $html;
	}

	public static function getFlagsEstatusOrdenServicio($estatus){

		$html="<i class=\"fas fa-circle fa-stack-2x text-light\" ></i>";

		if(in_array($estatus,["PENDIENTE"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-secondary\" ></i>";
		}		
		
		if(in_array($estatus,["REVISION","RECIBIDA","PROCESO","TERMINADO"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-primary\" ></i>";
		}

		if(in_array($estatus,["FINALIZADO","FACTURADO","PAGADO"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-success\" ></i>";
		}		

		return $html;
	}

		public static function getRGBtatusOrdenServicio($estatus){		

		if(in_array($estatus,["PENDIENTE"])){
			$html="#6c757d"; //Secondary
		}		
		
		if(in_array($estatus,["REVISION","RECIBIDA","PROCESO","TERMINADO"])){
			$html="#007bff"; //text-primary";
		}

		if(in_array($estatus,["FINALIZADO","FACTURADO","PAGADO"])){
			$html="#28a745"; //text-success";
		}		

		return $html;
	}

	public static function getFlagsEstatusSolicitud($estatus){

		$html="<i class=\"fas fa-circle fa-stack-2x text-light\" ></i>";

		if(in_array($estatus,["PENDIENTE"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-secondary\" ></i>";
		}		

		if(in_array($estatus,["ACTIVO"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-primary\" ></i>";
		}

		if(in_array($estatus,["COMPLETADO"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-success\" ></i>";
		}

		if(in_array($estatus,["CANCELADO"])){
			$html="<i class=\"fas fa-circle fa-stack-2x text-dark\" ></i>";
		}

		return $html;
	}

	public static function getBadgeEstatusSolicitud($estatus){

		$html="<span class=\"badge badge-light\">$estatus</span>";

		if(in_array($estatus,["PENDIENTE"])){
			$html="<span class=\"badge badge-secondary\">$estatus</span>";
		}		

		if(in_array($estatus,["ACTIVO"])){
			$html="<span class=\"badge badge-primary\">$estatus</span>";
		}

		if(in_array($estatus,["COMPLETADO"])){
			$html="<span class=\"badge badge-success\">$estatus</span>";
		}

		if(in_array($estatus,["CANCELADO"])){
			$html="<span class=\"badge badge-dark\">$estatus</span>";
		}

		return $html;
	}

	public static function echoPre($data){

		//if(!$view)return;

		print_r("<pre>");

		print_r($data);

		print_r("</pre");

		exit;

	}

	//Formato 09:00:00 en 24 Horas
	//retorna 09:00 AM
	public static function formatoHoraCorta($horario){

		$time=strtotime($horario);

		return 	date("h:i A",$time);

	}
	
	public static function periodoTriMestral(){

		$arr=[];

		$arr[]=[
			"nombre"=>"T1",
			"inicio"=>"01-01", // 1 de enero
			"fin"=>"03-31", //31 de marzo
		];

		$arr[]=[
			"nombre"=>"T2",
			"inicio"=>"04-01",
			"fin"=>"06-30",
		];

		$arr[]=[
			"nombre"=>"T3",
			"inicio"=>"07-01",
			"fin"=>"09-30",
		];

		$arr[]=[
			"nombre"=>"T4",
			"inicio"=>"10-01",
			"fin"=>"12-31",
		];


		return $arr;
	}	

	public static function periodoSemestral(){

		$arr=[];

		$arr[]=[
			"nombre"=>"S1",
			"inicio"=>"01-01", // 1 de enero
			"fin"=>"06-30", //31 de marzo
		];

		$arr[]=[
			"nombre"=>"S2",
			"inicio"=>"07-01",
			"fin"=>"12-31",
		];

		return $arr;
	}	

	public static function validarPeriodo($pInicio,$pFinal,$fechaInicio,$fechaFinal){

		$esValido=false;

		if($fechaFinal==""){
			$fechaFinal=date("Y-m-d");
		}

		if( ($fechaInicio=="" && $fechaFinal=="") || $fechaInicio=="" ){
			return false;
		}

		if($fechaInicio>=$pInicio && $fechaInicio<=$pFinal){
			return true;
		}

		if($pInicio>=$fechaInicio && $pFinal<=$fechaFinal){
			return true;
		}

		if($fechaFinal>=$pInicio && $fechaFinal<=$pFinal){
			return true;
		}

		return $esValido;
	}

	public static function cantidadHojas($capacidad,$registros){

		$total=1;

		if(!$registros) return $total; // Si no hay registros, devolver la hoja

		if($capacidad>0){
			$total=$registros/$capacidad;
			if( ($registros % $capacidad) ){
				$total=(int)$total+1;
			}
		}

		return $total;
	}

	public static function primeraPalabra($cadena,$separador=" "){

		$arr=explode($separador,$cadena);

		if(isset($arr[0])){
			return $arr[0];
		}else{
			return "";
		}

	}

	//////////////////////////////////////////////////////////////////////
	//PARA: Date Should In YYYY-MM-DD Format
	//RESULT FORMAT:
	// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
	// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
	// '%m Month %d Day'                                            =>  3 Month 14 Day
	// '%d Day %h Hours'                                            =>  14 Day 11 Hours
	// '%d Day'                                                        =>  14 Days
	// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
	// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
	// '%h Hours                                                    =>  11 Hours
	// '%a Days                                                        =>  468 Days
	//////////////////////////////////////////////////////////////////////
	public static function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
	{
	    $datetime1 = date_create($date_1);
	    $datetime2 = date_create($date_2);
	   
	    $interval = date_diff($datetime1, $datetime2);
	   
	    return $interval->format($differenceFormat);
	   
	}

	public static function currenteDateTime(){
		return date("Y-m-d H:i:s");
	}

	public static function formatoSeparadorTicket($texto="---",$largo=45){

		$cadena="";
		$contador=0;
		$indice=0;
		while ($contador<$largo) {

			$cadena.=$texto[$indice];

			if($indice<strlen($texto)-1){
				++$indice;	
			}else{
				$indice=0;
			}
			
			++$contador;
		}

		return $cadena;
	}


	public static function formatoTextoTicket($texto,$largo=45,$alineacion="IZQ"){

		//Cortamos el texto en varias lineas y las convertirnos en
		//arreglo por linea.
		$texto=strtoupper($texto);
		$texto=str_replace("Ñ","N",$texto);
		$texto=str_replace("Á","A",$texto);
		$texto=str_replace("É","E",$texto);
		$texto=str_replace("Í","I",$texto);
		$texto=str_replace("Ó","O",$texto);
		$texto=str_replace("Ú","U",$texto);
		$texto=str_replace("´","",$texto);

		$cadena="";

		if(strlen($texto)>$largo){
			$texto=substr($texto,0,$largo);
		}

		if($alineacion=="IZQ"){
			$cadena=str_pad($texto, $largo," ",STR_PAD_RIGHT);
		}

		if($alineacion=="DER"){
			$cadena=str_pad($texto, $largo," ",STR_PAD_LEFT);
		}

		if($alineacion=="CEN"){

			$aux=$largo-strlen($texto);

			$margen=round($aux/2);

			$cadena=str_repeat(" ",$margen).$texto.str_repeat(" ",$margen);

			$cadena=substr($cadena,0,$largo);
		}

		return $cadena;
	}

	public static function formatoParrafoTicket($texto,$largo=60){
		$texto=strtoupper($texto);
		$texto=str_replace("Ñ","N",$texto);
		$texto=str_replace("Á","A",$texto);
		$texto=str_replace("É","E",$texto);
		$texto=str_replace("Í","I",$texto);
		$texto=str_replace("Ó","O",$texto);
		$texto=str_replace("Ú","U",$texto);
		$texto=str_replace("´","",$texto);
		//$texto=str_replace("\n"," ",$texto);

		$length = strlen($texto);
		$cadena = array();
		$arrLineas=array();
		$cont=0;

		for ($i=0; $i<$length; $i++) {

			if($texto[$i]!="\n"){
				$cadena[$i] = $texto[$i];
			}

			if($cont>=$largo || $texto[$i]=="\n"){
				$arrLineas[]=implode("",$cadena);
				$cadena = array();
				$cont=0;
			}

			$cont++;
		}

		$arrLineas[]=implode("",$cadena);

		return $arrLineas;
	}

	public static function cantidadLetras($cantidad,$unidad="PESOS",$unidadDecimal="/100 M.N."){
		$letras=new NumeroConLetra($cantidad,$unidad,$unidadDecimal);

		return $letras->montoLetras;
	}

	public static function selectDB($dbName){
        try{
            $dm = app("Illuminate\\Database\\DatabaseManager");
            $dm->disconnect();
            app()->config->set("database.connections.mysql.database", $dbName);
            $dm->reconnect("mysql");
            return true;

        }catch(\Exception $ex){            

            return false;
        }
    }

    public static function recolectarData($arrayCabeceras,$inputFileName){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        //Identificamos las columnas 
        for ($col = 1; $col <= $highestColumnIndex; ++$col) {
            $nombre=$worksheet->getCellByColumnAndRow($col,1)->getValue();
            if(isset($arrayCabeceras[$nombre])){
                $arrayCabeceras[$nombre]["col"]=$col;                
            }
        }

        //print_r($arrayCabeceras);
        $arrRows=[];
        $error=false;
        for ($row = 2; $row <= $highestRow; ++$row) {
            //Cargamos la info de acuerdo al orden de las cabeceras (Por el momento no manejamos fechas)
            foreach ($arrayCabeceras as $cabecera=>$attr) {
                if(!isset($attr["col"])){
                    $this->error("\nCabecera no encontrada: ".$cabecera);
                    $error=true;
                }else{

                	$data[$cabecera]=$worksheet->getCellByColumnAndRow($attr["col"],$row)->getValue();

                	if(isset($attr["tipo"]) && $attr["tipo"]=="fecha"){
                		//$data[$cabecera]=date("Y-m-d",\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($data[$cabecera]));
                		$dateObject=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[$cabecera]);
                		$data[$cabecera]=$dateObject->format('Y-m-d');
                		if($data[$cabecera]=="1970-01-01"){
                			$data[$cabecera]=null;
                		}
                	}

                    
                }                
            }

            if($error){
                return false;
            }

            $arrRows[]=$data;            
        }

        return $arrRows;
    }

    public static function getFileImageBase64($filePath){

        $ext = \File::extension($filePath);

        //Recuperamos el contenido del archivo
        $data=\Storage::get($filePath);
        return "data:image/".strtolower($ext).";base64,".base64_encode($data);

    }

    public static function getEstatus(){
    	return [
    		//"PENDIENTE"=>"PENDIENTE",

    		//"RESERVADO"=>"RESERVADO",
    		"DISPONIBLE"=>"DISPONIBLE",    		
    		"VENDIDO"=>"VENDIDO",

    		//"BLOQUEADA"=>"BLOQUEADA",
    	];
    }

    public static function getTiposUsuarios(){
    	return [
    		"ADMIN"=>"ADMIN",
    		"ADMINISTRATIVO"=>"ADMINISTRATIVO",
    		"VENTAS"=>"VENTAS",
    	];
    }

    public static function getFormasPago(){
    	return [
    		"3 PAGOS"=>"3 PAGOS",
    		"24 MENSUALIDADES"=>"24 MENSUALIDADES",
    		"ANTICIPO Y PAGO FINAL"=>"ANTICIPO Y PAGO FINAL",
    	];
    }

    public static function getClassEstatus($arrPropiedades,$numero){

    	$estatus=strtolower($arrPropiedades[$numero]["estatus"]);

    	if($estatus=="disponible"){
    		return "map-departamento-target ".$estatus;
    	}else{
    		return $estatus;
    	}

    }

}

