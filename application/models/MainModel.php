<?php

class MainModel extends CI_Model{

    public function __construnct(){
        parent::__construct();
    }

    public function addLog($type, $desc, $id){
    	$idUser = !isset($_SESION['data_user']) ? 0 : $_SESION['data_user']->id;
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date('y-m-d H:i:s');
    	$this->db->insert('aLog',
    		array(
    			'idUser'=>$idUser,'date'=>$date,
    			'ip'=>$ip,'type'=>$type,'description'=>$desc,'idVal'=>$id
    		)
    	);
    }

    public function checkInstrumentStudent($idUser, $idInstrument){
    	$check = $this->db->where('idUser',$idUser)->where('idInstrument',$idInstrument)->get('userRelInstrument');
    	if($check->num_rows()>0){
    		return true;
    	}else{
    		return false;
    	}

    }
    public function horasRestantesEstudiante($idUser, $idInstrument){
        $lastPackage = $this->db->where('idStudent',$idUser)->where('idInstrument',$idInstrument)->order_by('id','desc')->get('clasesBuys');

        if($lastPackage->num_rows()==0){
            $hoursRest = 0;
        }else{
            $lastPackage = $lastPackage->result()[0];
            $totalHoursLast = $lastPackage->totalHours;
            $horasTotales = $this->db->select_sum('clasesBuys.hours')->where('idStudent',$idUser)->where('idInstrument',$idInstrument)->get('clasesBuys')->result()[0];
            $sumadorHorasTotales = $horasTotales->hours;
            $dateLastPackage = explode(' ', $lastPackage->date);//explode separa el string por el primer caracter, en este caso por el espacio por lo que es una fecha y una hora
            //$hoursTaked = $this->db->select('COUNT(id) AS n')->where('dateClass >=',$dateLastPackage[0])->where('idStudent',$idUser)->where('idInstrument',$idInstrument)->where('status>"0" AND status<"3"')->get('clases')->result()[0]->n;
            $hoursTaked = $this->db->select('COUNT(id) AS n')->where('idStudent',$idUser)->where('idInstrument',$idInstrument)->where('status>"0" AND status<"3"')->get('clases')->result()[0]->n;
            $hoursRest = $sumadorHorasTotales- $hoursTaked;
            
        }
        return  $hoursRest;
    }
    public function obtenerDineroEfectivo(){
        $ingresos=$this->db->select('sum(price) as ingresos')->where('idSucursal',$_SESSION['sucursal'])->where('medioPago',0)->get('clasesBuys')->result()[0];
        $egresos=$this->db->select('sum(valor) as egresos')->where('idSucursal',$_SESSION['sucursal'])->where('medioPago',0)->get('egresos')->result()[0];
        //$ingresos= $ingresos-$egresos;
        return ($ingresos->ingresos)-($egresos->egresos);

    }
    public function obtenerDineroBanco(){
        $ingresos=$this->db->select('sum(price) as ingresos')->where('idSucursal',$_SESSION['sucursal'])->where('medioPago',1)->get('clasesBuys')->result()[0];
        $egresos=$this->db->select('sum(valor) as egresos')->where('idSucursal',$_SESSION['sucursal'])->where('medioPago',1)->get('egresos')->result()[0];
        //$ingresos= $ingresos-$egresos;
        return ($ingresos->ingresos)-($egresos->egresos);

    }
}