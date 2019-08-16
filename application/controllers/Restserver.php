<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

header('Access-Control-Allow-Origin: *'); //esto se debe colocar para que se puedan hacer peticiones 
header("Access-Control-Allow-Methods: GET, OPTIONS");// Esto se debe colocar para que se puedan hacer peticiones
//date_default_timezone_set("America/Bogota");
class Restserver extends REST_Controller {
    
    public function test_get(){
        $array = array("Hola","mundo");
        $this->response($array);
    }
    public function autenticar_get(){
		$user = $this->input->get('user');
		$pass = $this->input->get('pass');
		//$sql = $this->db->where('(name="'.$user.'") AND document="'.$pass.'"')->get('users'); // Solo inicia con el nombre
		$sql = $this->db->where('name',$user)->where('document',$pass)->get('users'); // Solo inicia con el nombre
		if($sql->num_rows()==1){
			$user = $sql->result()[0];
			//$_SESSION['data_user'] = $user;
			//$_SESSION['name'] = $user->name;
			//$_SESSION['sucursal'] = $user->idSucursal;
			$r['username'] = $user->name;
			$r['level'] = $user->level;
            $r['sucursal'] = $user->idSucursal;
            $r['id'] = $user->id;
			//$r['data'] = $user;
			$response = 2;
		}else{	
			$r['Estado'] = "Ups, Revisa Tus datos e intenta de nuevo";
			$response = 1;
		}
		$r['response'] = $response;
		echo json_encode($r);
    } 
    public function historialClasesEstudiante_get(){
        $user = $this->input->get('nombre');
        $sucursal = $this->input->get('sucursal');
        $idStudent = $this->db->select('users.id id')->where('users.name',$user)->where('idSucursal',$sucursal)->get('users');//aca podria usar  like('users.name',$user)
        if ($idStudent->num_rows()>0){
            $nameStudent = $this->db->select('users.name estudiante')->where('id',$idStudent->result()[0]->id)->get('users')->result()[0]->estudiante;
            $sql = $this->db->select('clases.dateClass,clases.bitacora,instrumentos.name instrumento,users.name profesor')
                            ->where('idStudent',$idStudent->result()[0]->id)
                            ->where('status',1)
                            //->where('bitacora is not null')
                            ->join('instrumentos','instrumentos.id=clases.idInstrument')
                            ->join('users','users.id=clases.idTeacher')
                            ->order_by('dateClass desc')->get('clases');

            if($sql->num_rows()> 0){
                $r['fechaActual'] = date('Y-m-d');
                $r['estudiante']= $nameStudent;
                $r['response'] = $sql->result();
            }
            
        }else{
            $r['content'] = 'Ups, No hay concidencias con ese estudiante, intenta con otro.';
            $r['response'] = 1;
        }
        echo json_encode($r);
        
    }
    public function bitacorasPendientes_get(){
        $user = $this->input->get('id');
        $date = date('Y-m-d');
        $nameTeacher = $this->db->select('users.name profesor')->where('id',$user)->get('users')->result()[0]->profesor;
        $sql = $this->db->select('clases.dateClass,instrumentos.name instrumento,users.name estudiante,clases.id')
                        ->where('bitacora is null')
                        ->where('status',1)
                        ->where('dateClass',date('Y-m-d'))
                        ->where('clases.idTeacher',$user)
                        ->join('instrumentos','instrumentos.id=clases.idInstrument')
                        ->join('users','users.id=clases.idStudent')
                        ->order_by('dateClass desc')->get('clases');
        //$r['profesor']= $nameTeacher;
        $r = $sql->result();
        //$b = array_slice($r,0,40);    
        echo json_encode($r);
        
        
    }
    public function updateBitacora_get(){
        $idBitacora = $this->input->get('id');
        $comentario= $this->input->get('comentario');
        $this->db->set('bitacora', $comentario)->set('date',date('Y-m-d H:i:s'))->where('id', $idBitacora)->update('clases');
        $r['estado']= "Se actualizo Correctamente";
        echo json_encode($r);
    }
    public function listStudents_get(){
        $sucursal = $this->input->get('sucursal');
        $sql = $this->db->select('id,name')->where('idSucursal',$sucursal)->where('level',3)->order_by('name asc')->get('users')->result();
        echo json_encode($sql);
    }
    /*****************************************************************************
     ***************************************************************************** 
     *****************************************************************************
     ***************************************************************************** 
     ********************PETICIONES PARA LOS ESTUDIANTES**************************
      **************************************************************************** 
     *****************************************************************************
     ******************************************************************************/

    public function horasRestantes_get(){ // Esta peticion me da la informacion del estudiante y tamben me da la informacion de cuantas horas le quedan disponibles por cada instrumento
        $idEstudiante = $this->input->get('id');
        $sql = $this->db->select('instrumentos.id idInstrumento,instrumentos.name nombreInstrumento')
                        ->where('idUser',$idEstudiante)
                        ->join('instrumentos','instrumentos.id=userRelInstrument.idInstrument')->get('userRelInstrument');//Obtiene los isntrumentos que tiene asociado cada estudiante
        foreach ($sql->result() as $key => $instrumento) {
            $horasRestantes = $this->mainModel->horasRestantesEstudiante($idEstudiante,$instrumento->idInstrumento);
            $data[]=array('instrumento'=>$instrumento->nombreInstrumento,'horasRestantes'=>$horasRestantes);
        }
        $r['datos'] = $data;
		echo json_encode($r);
    }
    public function perfilEstudiante_get(){//da la informacion del estudiante solamente
        $idEstudiante = $this->input->get('id');
        $perfil= $this->db->select('name,document,tel,direccion,email')->where('id',$idEstudiante)->get('users');
        $r = $perfil->result()[0];
        echo json_encode($r);
    }
    public function clasesDisponiblesEstudiante_get(){//no esta en funcionamiento, pero es para saber a que clases se puede matricular un estudiante
		$sql = $this->db->where('idInstrument',$this->input->get('idInstrument'))->where('idSucursal',1)->order_by('nDay asc, time asc')->get('clasesHead');//Obtiene las Cabeceras de clase (Esta bien hecha la consulta)
		/*echo '<pre>';
			var_dump($sql->result());
		echo '</pre>';*/
		$instrument = $this->db->where('id',$this->input->get('idInstrument'))->get('instrumentos')->result()[0]->name; //Asi Saco el nombre del instrumento
		$data = array();
		foreach ($sql->result() as $key => $c) {
			$idStudent = $this->db->where('idStudent',$this->input->get('idUser'))->where('status',0)->where('type<',1)->where('idClassHead',$c->id)->get('relStudentClassHead')->num_rows() == 0 ? null : $this->input->get('idUser');
			//$this->db->where('idStudent',$this->input->get('idUser'))->where('idClassHead',$c->id)/*->join('clasesHead','clasesHead.id = relStudentClassHead.idClassHead')*/->get('relStudentClassHead')->num_rows() == 0 ? null : $this->input->get('idUser');
			// echo '<pre>';
			// 	var_dump($c->id);
			// echo '</pre>';
			$c->idStudent = $idStudent;
			//No borrar ni por el putas, info requerida en el front
			$nAlumns = $this->db->select('COUNT(id) AS n')->where('status',0)->where('type<',2)->where('idClassHead',$c->id)->get('relStudentClassHead')->result()[0]->n;
			$data[] = array('dataClass'=>$c,'studentsInscribed'=>$nAlumns);
		}
		//echo '<pre>';
		//	var_dump($data);
		//echo '</pre>';
		$r['response'] = 2;
		$r['content'] = $data;
		$r['instrument'] = $instrument;
		echo json_encode($r);
	}
    public function horarioEstudiante_get(){ ///devolver un arreglo con todos los horarios de todos los instrumentos 
        $idUser = $this->input->get('id');
        $instrumentos = $this->db->select('idInstrument,instrumentos.name nombre')->where('idUser',$idUser)->join('instrumentos','instrumentos.id = userRelInstrument.idInstrument')->get('userRelInstrument');
		//$idInstrument = $this->input->get('idInstrument');
        $date = date('Y-m-d').' 00:00:00';
        foreach($instrumentos->result() as $key => $instrumento){
            $sql = $this->db->select('A.*, A.id AS idClassStudentRel,C.idInstrument,A.id idGlobal, A.idClassHead idClassHead,')
                            ->where('A.idStudent',$idUser)
                            ->join('clasesHead C','C.id=A.idClassHead')
                            ->where('C.idInstrument',$instrumento->idInstrument)
                            ->where('A.status',0)
                            ->order_by('A.nDay asc')
                            ->where('type',0)->get('relStudentClassHead A');
            foreach($sql->result() as $key2 => $clase){
                /*Solamente esto es para darle formato a la fecha y a la hora que voy a dar para el front*/
                $fecha = $clase->dateStart;
                $horacompleta = explode(' ',$fecha);
                $horafinal= date("h a", strtotime($horacompleta[1]));
                $dia = $clase->nDay;
                if($dia == '1'){
                    $dia = 'Lunes';
                }
                if($dia == '2'){
                    $dia = 'Martes';
                }
                if($dia == '3'){
                    $dia = 'Miercoles';
                }
                if($dia == '4'){
                    $dia = 'Jueves';
                }
                if($dia == '5'){
                    $dia = 'Viernes';
                }
                if($dia == '6'){
                    $dia = 'Sabado';
                }
                /******************** Final de formato a la fecha */ 
                $data[]=array(
                                'id'=>$clase->idGlobal,
                                'idClassHead'=>$clase->idClassHead,
                                'instrumento'=>$instrumento->idInstrument,
                                'nombre' =>$instrumento->nombre,
                                'dia'=>$dia,
                                'hora'=>$horafinal,
                                'numeroDia'=>$clase->nDay
                            );
            }
        }
        $r= $data;
		echo json_encode($r);
    }
    public function statusClass_get(){
        
        $idClassHead = $this->input->get('idClassHead');
        $idInstrument = $this->db->where('id',$idClassHead)->get('clasesHead')->result()[0]->idInstrument;
        $idUser = $this->input->get('idStudent');
        $val = $this->input->get('val'); //este es el valor de si cancelo, asistio o no asistio
        $currentDate = $this->input->get('currentDate');//Esta fecha se necesita para cancelar la clase y es el dia de la clase 
        $horasDisponibles = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
        $class = $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->get('relStudentClassHead');
        //if ($horasDisponibles>0 ){    
            if($class->num_rows()>0){
                // echo '<pre>';
                //  var_dump($idClassHead);
                //  var_dump($idUser);
                //  var_dump($currentDate);
                // echo '</pre>';
                $checkClass = $this->db->select('id, status')->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->get('clases');
                if($checkClass->num_rows()==0){
                    $a = array(
                        'idClassHead'=> $idClassHead,
                        'idStudent' => $idUser,
                        'status' => $val,
                        'idInstrument' => $idInstrument,
                        'date' => date('Y-m-d H:i:s'),
                        'dateClass' => $currentDate
                    );
                    $this->db->insert('clases',$a);
                    $r['response'] = 2;
                    $r['content'] = 'saved';
                }else{
                    if($checkClass->result()[0]->status==0){
                        $r['response'] = 2;
                        $r['content'] = 'saved';
                        $this->db->where('id',$checkClass->result()[0]->id)->update('clases',array('status'=>$val));
                    }else{
                        $r['response'] = 1;
                        $r['content'] = 'laClaseYaFueActuliazada';
                    }
                }
            }else{
                $r['response'] = 1;
                $r['content'] = 'classNotFound';
            }
        //}else{
        //  $r['response'] = 1;
        //  $r['content'] = 'Accion Bloqueada Por que no tienes Horas Disponibles';
        //}
            echo json_encode($r);
    }
    public function reasignClassUser_get(){
		$idUser = $this->input->get('idUser');
		$nHours = $this->input->get('nHours');
		$dateStart = $this->input->get('dateStart');
		$time = $this->input->get('time').':00';
		$idInstrument = $this->input->get('idInstrument');
		$nDay = $this->input->get('nDay');
        $instrument = $this->db->where('id',$idInstrument)->get('instrumentos')->result()[0];
        $idSucursal = $this->db->select('idSucursal')->where('id',$idUser)->get('users')->result()[0];
		//echo '<pre>';
		//	var_dump($_GET);
		 //echo '</pre>';
		$checkClassHead = $this->db/*->where('dateStart ',$dateStart)*/->where('idInstrument',$idInstrument)->where('nDay',$nDay)->where('time',$time)->get('clasesHead');
		
		if($checkClassHead->num_rows()==0){
		
			$idInstrument = $this->input->get('idInstrument');
			$nHours = 1;
			$date = $this->input->get('date');
			$a = array(
				'idInstrument' => $idInstrument,
				'dateStart' => $dateStart,
				'hours' => 1,
				'nDay' => $this->input->get('nDay'),
				'idSucursal' => $idSucursal->idSucursal,/** DEBO SACAR EL ID DE LA SUCURSAL A DONDE PERTENECE EL ESTUDIANTE*/
				'time' => $time
			);
			$this->db->insert('clasesHead',$a);
			$idClassHead = $this->db->insert_id();
		}else{
			$idClassHead = $checkClassHead->result()[0]->id;

		}
		$hoursRest = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		$checkClass = $this->db->select('id')->where('idStudent',$idUser)->where('idClassHead',$idClassHead)->where('dateStart',$time)->get('relStudentClassHead');// mira si el estudiante esta en esa clase
		$nAlumns = $this->db->select('COUNT(id) AS n')->where('type',0)->where('idClassHead',$idClassHead)->get('relStudentClassHead')->result()[0]->n;
		if($checkClass->num_rows()==0){
			$classHead = $this->db->where('id',$idClassHead)->get('clasesHead');
			if($classHead->num_rows()>0){
				$classHead = $classHead->result()[0];
				if($classHead->private==0){
					if($nAlumns < $instrument->cupos ){
						if($hoursRest >= $nHours){
							$a = array(
								'idStudent' => $idUser,
								'idClassHead' => $idClassHead,
								'dateStart' => $dateStart.' '.$this->input->get('time'),
								'nHours' => $nHours,
								'nDay' => $this->input->get('nDay'),
								'type' => 2
							);
							$this->db->insert('relStudentClassHead',$a);
							$id = $this->db->insert_id();
							// $sql = $this->db->where('id',$id)->get('clases');
							$this->mainModel->addLog('Reprogramacion Clase desde Api(idestudiante,idregistro)',$idUser,$id);
							$r['response'] = 2;
                            $r['content'] = 'added';
                            $r['idReprogramacion']=$id;
                            $r['idInstrument'] = $idInstrument;
                            $r['idUser'] = $idUser;
                            $r['hoursRest'] = $hoursRest;
                            $r['nHours'] = $nHours;
						}else{
                            //$r['hoursRest'] = $hoursRest;
                            //$r['$nHours'] = $nHours;
                            //$r['idInstrument'] = $idInstrument;
                            //$r['$idUser'] = $idUser;
							$r['response'] = 1;
							$r['content'] = 'exceededHours';
						}
					}else{
						$r['response'] = 1;
						$r['content'] = 'alumnsExceded';
					}
				}else{
					$r['response'] = 1;
					$r['content'] = 'classPrivate';
				}
			}else{
				$r['response'] = 1;
				$r['content'] = 'classNotExist';
			}
		}else{
			$r['response'] = 1;
			$r['content'] = 'classRegistered';	
		}
		echo json_encode($r);
		
    }
    public function deleteCancelacion_get(){
        $idClassHead = $this->input->get('idClassHead');
        $idInstrument = $this->db->where('id',$idClassHead)->get('clasesHead')->result()[0]->idInstrument;
        $idUser = $this->input->get('idStudent');
        $val = $this->input->get('val'); //este es el valor de si cancelo, asistio o no asistio
        $currentDate = $this->input->get('currentDate');//Esta fecha se necesita para cancelar la clase y es el dia de la clase 
        $horasDisponibles = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
        $class = $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->get('relStudentClassHead');
        if($class->num_rows()>0){
            // echo '<pre>';
            //  var_dump($idClassHead);
            //  var_dump($idUser);
            //  var_dump($currentDate);
            // echo '</pre>';
            $checkClass = $this->db->select('id, status')->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->get('clases');
            if($checkClass->num_rows()==0){
                $r['response'] = 1;
                $r['content'] = 'no Exists';
            }else{
                $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->delete('clases')[0];
                $r['response'] = 2;
                $r['content'] = 'done';
            }
            echo json_encode($r);
        }
    }
    public function deleteClaseReasignada_get(){
        $idClassHead = $this->input->get('idClassHead');
        $idInstrument = $this->db->where('id',$idClassHead)->get('clasesHead')->result()[0]->idInstrument;
        $idUser = $this->input->get('idStudent');
        $val = $this->input->get('val'); //este es el valor de si cancelo, asistio o no asistio
        $currentDate = $this->input->get('currentDate');//Esta fecha se necesita para cancelar la clase y es el dia de la clase 
        $horasDisponibles = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
        $class = $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->get('relStudentClassHead');
        if($class->num_rows()>0){
            // echo '<pre>';
            //  var_dump($idClassHead);
            //  var_dump($idUser);
            //  var_dump($currentDate);
            // echo '</pre>';
            $checkClass = $this->db->select('id, status')->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->get('clases');
            if($checkClass->num_rows()==0){
                $r['response'] = 1;
                $r['content'] = 'no Exists';
            }else{
                $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->delete('clases')[0];
                $r['response'] = 2;
                $r['content'] = 'done';
            }
            echo json_encode($r);
        }
    }
















































































    public function claseDisponibles(){
		$sql = $this->db->where('idInstrument',$this->input->get('idInstrument'))->where('idSucursal',$_SESSION['sucursal'])->order_by('nDay asc, time asc')->get('clasesHead');//Obtiene las Cabeceras de clase (Esta bien hecha la consulta)
		/*echo '<pre>';
			var_dump($sql->result());
		echo '</pre>';*/
		$instrument = $this->db->where('id',$this->input->get('idInstrument'))->get('instrumentos')->result()[0]->name; //Asi Saco el nombre del instrumento
		$data = array();
		foreach ($sql->result() as $key => $c) {
			$idStudent = $this->db->where('idStudent',$this->input->get('idUser'))->where('status',0)->where('type<',2)->where('idClassHead',$c->id)->get('relStudentClassHead')->num_rows() == 0 ? null : $this->input->get('idUser');
			//$this->db->where('idStudent',$this->input->get('idUser'))->where('idClassHead',$c->id)/*->join('clasesHead','clasesHead.id = relStudentClassHead.idClassHead')*/->get('relStudentClassHead')->num_rows() == 0 ? null : $this->input->get('idUser');
			// echo '<pre>';
			// 	var_dump($c->id);
			// echo '</pre>';
			$c->idStudent = $idStudent;
			//No borrar ni por el putas, info requerida en el front
			$nAlumns = $this->db->select('COUNT(id) AS n')->where('status',0)->where('type<',2)->where('idClassHead',$c->id)->get('relStudentClassHead')->result()[0]->n;
			$data[] = array('dataClass'=>$c,'studentsInscribed'=>$nAlumns);
		}
		//echo '<pre>';
		//	var_dump($data);
		//echo '</pre>';
		$r['response'] = 2;
		$r['content'] = $data;
		$r['instrument'] = $instrument;
		echo json_encode($r);
	}
    	
}
