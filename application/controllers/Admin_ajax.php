<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Pruebas Con el servidor de hostingerrrrrrrrrrrrrrrr

class Admin_ajax extends CI_Controller {
	private $data;
	public function __construct(){
		parent::__construct();
		
		if(isset($_SESSION['sucursal'])){
			$this->sucursal = $_SESSION['sucursal'];
		}
		$this->data = array('view'=>'addUser');
		
	}
	public function index()	{
		$this->load->view('admin/index',$this->data);
		//
	}
	public function nameStudent(){
		$idUser = $this->input->get('id');
		$sql = $this->db->select('name')->where('id',$idUser)->get('users')->result()[0];
		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function nameSession(){
		$b['content'] = $_SESSION['name'];
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function nameSucursal(){
		$b['content'] = $_SESSION['sucursal'];
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function addClassUser(){
		$idUser = $this->input->get('idUser');
		$idClassHead = $this->input->get('idClassHead');
		$nHours = $this->input->get('nHours');
		$dateStart = $this->input->get('dateStart');
		$idInstrument = $this->input->get('idInstrument');
		$instrument = $this->db->where('id',$this->input->get('idInstrument'))->get('instrumentos')->result()[0];
		$hoursRest = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		$checkClass = $this->db->select('id')->where('idStudent',$idUser)->where('idClassHead',$idClassHead)->where('type',0)->get('relStudentClassHead');
		$nAlumns = $this->db->select('COUNT(id) AS n')->where('idClassHead',$idClassHead)->where('type',0)->get('relStudentClassHead')->result()[0]->n; //aqui solo voy a contar los que esten regularmente 
		if($checkClass->num_rows()==0){
			$classHead = $this->db->where('id',$idClassHead)->get('clasesHead');
			if($classHead->num_rows()>0){
				$classHead = $classHead->result()[0];
				if($classHead->private==0){
					if($nAlumns < $instrument->cupos ){
						if($hoursRest >0){
							// $a = array(
							// 	'idStudent' => $idUser,
							// 	'idClassHead' => $idClassHead,
							// 	'nHours' => $nHours,
							// 	'dateStart' => $dateStart,
							// 	'idInstrument' => $idInstrument
							// );
							// $this->db->insert('clases',$a);
							
							$a = array(
								'idStudent' => $idUser,
								'idClassHead' => $idClassHead,
								'dateStart' => $dateStart.' '.$this->input->get('time'),
								'nHours' => $nHours,
								'nDay' => $this->input->get('nDay'),
								'type' => $this->input->get('type'),
							);
							$this->db->insert('relStudentClassHead',$a);
							$id = $this->db->insert_id();
							// $sql = $this->db->where('id',$id)->get('clases');
							$this->mainModel->addLog('classStudenAdded','',$id);
							$r['response'] = 2;
							$r['content'] = 'added';
							$r['horasRestantes']=$hoursRest;
						}else{
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
	public function reasignClassUser(){
		// SE DEBEN HACER LAS MISMAS MODIFICACIONES ACA QUE EN EL RET SERVER PARA LAS APIS DE LA APLICACION/////////
		////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////
		////////////////////////////////////
		///////////////////////////
		$idUser = $this->input->get('idUser');
		$nHours = $this->input->get('nHours');
		$dateStart = $this->input->get('dateStart');
		$time = $this->input->get('time').':00';
		$idInstrument = $this->input->get('idInstrument');
		$nDay = $this->input->get('nDay');
		$instrument = $this->db->where('id',$idInstrument)->get('instrumentos')->result()[0];
		/*echo '<pre>';
			var_dump($dateStart);
			var_dump($idInstrument);
			var_dump($time);
			
		echo '</pre>';*/
		$checkClassHead = $this->db/*->where('dateStart',$dateStart)*/->where('idInstrument',$idInstrument)->where('nDay',$nDay)->where('time',$time)->get('clasesHead');//esta comprobacoio no la esta haciendo, quite la comprobacion del date start para que reconozca el idclashead que se ve regularmente todas las semanas
		
		if($checkClassHead->num_rows()==0){
			/*echo '<pre>';
				echo 'no encontro ninguna class head';
				var_dump($checkClassHead->result());
			echo '</pre>';*/
			$idInstrument = $this->input->get('idInstrument');
			$nHours = 1;
			$date = $this->input->get('date');
			$a = array(
				'idInstrument' => $idInstrument,
				'dateStart' => $dateStart,
				'hours' => 1,
				'nDay' => $this->input->get('nDay'),
				'idSucursal' => $_SESSION['sucursal'],
				'time' => $time
			);
			$this->db->insert('clasesHead',$a);
			$idClassHead = $this->db->insert_id();
		}else{
			$idClassHead = $checkClassHead->result()[0]->id;

		}
		$hoursRest = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		$checkClass = $this->db->select('id')->where('idStudent',$idUser)->where('idClassHead',$idClassHead)->where('dateStart',$time)->get('relStudentClassHead');// mira si el estudiante esta en esa clase
		$nAlumns = $this->db->select('COUNT(id) AS n')->where('idClassHead',$idClassHead)->where('type',0)->get('relStudentClassHead')->result()[0]->n;//el tipo tiene que ser 0 por que los cupos que valen son los de estudiante regular

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
								'date'=> date('y-m-d H:i:s'),//para la fecha actual
								'nHours' => $nHours,
								'nDay' => $this->input->get('nDay'),
								'type' => 2
							);
							/*cho '<pre>';
								echo 'AL estudiante voy a meterlo en la clase';
								var_dump($idClassHead);
								var_dump($a);
							echo '</pre>';*/
							$this->db->insert('relStudentClassHead',$a);
							$id = $this->db->insert_id();
							// $sql = $this->db->where('id',$id)->get('clases');
							$this->mainModel->addLog('classStudenAdded','',$id);
							$r['response'] = 2;
							$r['content'] = 'added';
						}else{
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
	public function addHeadClass(){
		$idInstrument = $this->input->get('idInstrument');
		$nHours = 1;
		$date = $this->input->get('date');
		$a = array(
			'idInstrument' => $idInstrument,
			'dateStart' => $date,
			'hours' => $nHours,
			'nDay' => $this->input->get('dayWeek'),
			'idSucursal' => $_SESSION['sucursal'],
			'time' => $this->input->get('time')
		);
		$this->db->insert('clasesHead',$a);
		$id = $this->db->insert_id();
		$this->mainModel->addLog('classHeadCreated','',$id);
		$sql = $this->db->where('id',$id)->get('clasesHead');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function addEgresoEfectivo(){
		$r = array(
			'fecha'=> date('y-m-d H:i:s'),
			'valor'=>$this->input->get('valorEgresoEfectivo'),
			'medioPago'=>0,
			'concepto'=>$this->input->get('descripcionEgresoEfectivo'),
			'idSucursal'=> $_SESSION['sucursal'],
			'tipo'=>$this->input->get('conceptoEgresoEfectivo')
		);
		$this->db->insert('egresos',$r);
		$ultimoid = $this->db->insert_id();
		$this->mainModel->addLog('Egreso Efectivo Añadido','',$ultimoid);
		$sql = $this->db->where('id',$ultimoid)->get('egresos')->result();
		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function addEgresoBanco(){
		$r = array(
			'fecha'=> date('y-m-d H:i:s'),
			'valor'=>$this->input->get('valorEgresoBanco'),
			'medioPago'=>1,
			'concepto'=>$this->input->get('descripcionEgresoBanco'),
			'idSucursal'=> $_SESSION['sucursal'],
			'tipo'=>$this->input->get('conceptoEgresoBanco')
		);
		$this->db->insert('egresos',$r);
		$ultimoid = $this->db->insert_id();
		$this->mainModel->addLog('Egreso Banco Añadido','',$ultimoid);
		$sql = $this->db->where('id',$ultimoid)->get('egresos')->result();
		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function addHoursToInstrumentStudent(){	
		$idUser = $this->input->get('idUser');
		$idInstrument = $this->input->get('idInstrument');
		$check = $this->mainModel->checkInstrumentStudent($idUser, $idInstrument);
		$hoursRest = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		if($check){
			$nHours = $this->input->get('nHours');
			$price = $this->input->get('price');
			$totalHours = $nHours + $hoursRest;
			$a = array(
				'idStudent' => $idUser,
				'idInstrument' => $idInstrument,
				'hours' => $nHours,
				'price' => $price,
				'date' => date('y-m-d H:i:s'),
				'bono' => $this->input->get('bono'),
				'medioPago' => $this->input->get('medioPago'),
				'tipoDescuento' => $this->input->get('tipoDescuento'),
				'hoursRest' => $hoursRest,
				'idSucursal' => $this->sucursal,
				'nRecibo' => $this->input->get('nRecibo'),
				'pago' => $this->input->get('pago'),
				'porcentaje' => $this->input->get('porcentaje'),
				'conceptoIngreso'=>$this->input->get('conceptoPaquete'),
				'totalHours' => $totalHours
			);
			$this->db->insert('clasesBuys',$a);
			$id = $this->db->insert_id();
			$this->mainModel->addLog('hourAddedToInstrumentStuden','',$id);
			$sql = $this->db->where('id',$id)->get('clasesBuys');
			$r['response'] = 2;
			$r['content'] = $sql->result()[0];
		}else{
			$r['response'] = 1;
			$r['content'] = 'userHaveNotInstrument';
		}
		echo json_encode($r);
	}
	public function addInstrumentToUser(){
		$idUser = intval($this->input->get('idUser'));
		$idInstrument = intval($this->input->get('idInstrument'));
		if($idUser > 0 && $idInstrument > 0){
			$check = $this->mainModel->checkInstrumentStudent($idUser, $idInstrument);
			if(!$check){
				$a = array('idUser'=>$idUser,'idInstrument'=>$idInstrument);
				$this->db->insert('userRelInstrument',$a);
				$id = $this->db->insert_id();
				$this->mainModel->addLog('instrumentAddedToUser',$idInstrument,$id);
				$sql = $this->db->where('id',$id)->get('userRelInstrument');
				$r['response'] = 2;
				$r['content'] = $sql->result()[0];
			}else{
				$r['response'] = 1;
				$r['content'] = 'relationExisted';
			}
		}else{
			$r['response'] = 1;
			$r['content'] = 'dataError';
		}
		echo json_encode($r);
	}
	public function addTeacherToClass(){
		$idClassHead = $this->input->get('idClassHead');
		$idTeacher = $this->input->get('idTeacher');
		$idClassHead = $this->input->get('idClassHead');
		$idInstrument = $this->db->where('id',$idClassHead)->get('clasesHead')->result()[0]->idInstrument;
		$idUser = $this->input->get('idStudent');
		$horasDisponibles = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		$val = $this->input->get('val');
		$currentDate = $this->input->get('currentDate');
		$class = $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->get('relStudentClassHead');
		//if ($horasDisponibles>0 ){
			if($class->num_rows()>0){
				$checkClass = $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->get('clases');
				if($checkClass->num_rows()>0){
					//$this->db->where('id',$checkClass->result()[0]->id)->update('clases',array('idTeacher'=>$idTeacher,'date' => date('Y-m-d h:i:s')));
					$this->db->set('date',date('Y-m-d h:i:s'))->set('idTeacher',$idTeacher)->where('id',$checkClass->result()[0]->id)->update('clases');
					$r['response'] = 2;
					$r['content'] = 'Actualizado';
					$r['horasRestantes'] = $horasDisponibles;
				}else{
					$a = array(
						'idClassHead'=> $idClassHead,
						'idStudent' => $idUser,
						'idTeacher' => $idTeacher,
						'idInstrument' => $idInstrument,
						'date' => date('Y-m-d H:i:s'),
						'dateClass' => $currentDate
					);
					$this->db->insert('clases',$a);
					$r['response'] = 2;
					$r['content'] = 'Asignado';
					$r['horasRestantes'] = $horasDisponibles;
					
				}
			}else{
				$r['response'] = 1;
				$r['content'] = 'La Clase no se encontro';
			}
		//}else{
		//	$r['response'] = 1;
		//	$r['content'] = 'No Tienes Horas Disponibles Accion Bloqueada';
		//}
		echo json_encode($r);			
	}
	public function addIngreso(){
		$r = array(
			'date'=> date('y-m-d H:i:s'),
			'price'=>$this->input->get('valor'),
			'medioPago'=>0,
			'nRecibo'=>$this->input->get('nRecibo'),
			'conceptoIngreso'=>$this->input->get('concepto'),
			'idSucursal'=> $_SESSION['sucursal']
		);
		$this->db->insert('clasesBuys',$r);
		$ultimoid = $this->db->insert_id();
		$this->mainModel->addLog('Ingreso Añadido','',$ultimoid);
		$sql = $this->db->where('id',$ultimoid)->get('clasesBuys')->result();
		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function addIngresoBanco(){
		$r = array(
			'date'=> date('y-m-d H:i:s'),
			'price'=>$this->input->get('valor'),
			'nRecibo'=>$this->input->get('nRecibo'),
			'medioPago'=>1,
			'conceptoIngreso'=>$this->input->get('concepto'),
			'idSucursal'=> $_SESSION['sucursal']
		);
		$this->db->insert('clasesBuys',$r);
		$ultimoid = $this->db->insert_id();
		$this->mainModel->addLog('Ingreso Añadido','',$ultimoid);
		$sql = $this->db->where('id',$ultimoid)->get('clasesBuys')->result();
		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function statusClass(){
		
		$idClassHead = $this->input->get('idClassHead');
		$idInstrument = $this->db->where('id',$idClassHead)->get('clasesHead')->result()[0]->idInstrument;
		$idUser = $this->input->get('idStudent');
		$val = $this->input->get('val');
		$currentDate = $this->input->get('currentDate');
		$horasDisponibles = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		$date=date('Y-m-d h:i:s');
		$class = $this->db->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->get('relStudentClassHead');
		//if ($horasDisponibles>0 ){
			if($class->num_rows()>0){
				// echo '<pre>';
				// 	var_dump($idClassHead);
				// 	var_dump($idUser);
				// 	var_dump($currentDate);
				// echo '</pre>';
				$checkClass = $this->db->select('id, status')->where('idClassHead',$idClassHead)->where('idStudent',$idUser)->where('dateClass',$currentDate)->get('clases');
				if($checkClass->num_rows()==0){
					$a = array(
						'idClassHead'=> $idClassHead,
						'idStudent' => $idUser,
						'status' => $val,
						'idInstrument' => $idInstrument,
						'date' => $date,
						'dateClass' => $currentDate
					);
					$this->db->insert('clases',$a);
					$r['response'] = 2;
					$r['content'] = 'saved';
					$r['timezone']= "hi";
				}else{
					if($checkClass->result()[0]->status==0){
						$r['response'] = 2;
						$r['content'] = 'saved';
						//$this->db->where('id',$checkClass->result()[0]->id)->update('clases',array('status'=>$val,'date' => Date('Y-m-d h:i:s'))); 
						$this->db->set('status', $val)->set('date',date('Y-m-d H:i:s'))->where('id',$checkClass->result()[0]->id)->update('clases');//areglado para que no se cambie la fecha al actualizar los profesores o el estado de clase
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
		//	$r['response'] = 1;
		//	$r['content'] = 'Accion Bloqueada Por que no tienes Horas Disponibles';
		//}
			echo json_encode($r);
	}
	public function setRevisarCancelacion(){
		$id = $this->input->get('id');
		
		$this->db->set('status',1)->where('id',$id)->update('relStudentClassHead');
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function setRevertirRevisionCancelacion(){
		$id = $this->input->get('id');
		
		$this->db->set('status',0)->where('id',$id)->update('relStudentClassHead');
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function addUser(){
		// echo '<pre>';
		// 	var_dump($_GET);
		// echo '</pre>';
		$id = $this->input->get('id');
		$r = array(
			'name' => $this->input->get('name'),
			'idHuellero' => $this->input->get('idHuellero'),
			'type_document' => $this->input->get('type_document'), //int -  0 Ti, 1: cedula, 
			'document' => $this->input->get('document'), // int 
			'birthday' => $this->input->get('birthday'), // string: yyyy-mm-dd
			'date' => date('Y-m-d H:i:s'), // string: yyyy-mm-dd
			'observaciones' => $this->input->get('observaciones'),
			'level' => $this->input->get('level'), // 0: admin, 1: secretario, 2: profesor, 3:alumno,
			'email' => $this->input->get('email'), //
			'tel' => $this->input->get('tel'), //
			'password' => do_hash($this->input->get('password')),
			'tel2'=> $this->input->get('tel2'), // para el telefono 2 
			'nombreAcudiente' => $this->input->get('nombreAcudiente'), //
			'numeroInscripcion'=> $this->input->get('numeroInscripcion'),
			'direccion'=> $this->input->get('direccion'),
			'idSucursal'=> $_SESSION['sucursal']
			);
		if($id==0){
			$this->db->insert('users',$r);
			$id = $this->db->insert_id();
			$this->mainModel->addLog('userCreated','',$id);
		}else{
			$this->db->where('id',$id)->update('users',$r);
			$this->mainModel->addLog('userEdited','',$id);
		}
		$sql = $this->db->where('id',$id)->get('users')->result();
		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function sendTeacher(){
		$id = $this->input->get('id');
		$imagen = $this->input->get('hojaVida');
		/*
		if(is_uploaded_file($_FILES[$this->input->get('hojaVida')]["tmp_name"]))
			move_uploaded_file($_FILES[$this->input->get('hojaVida')]["tmp_name"],'https://www.eddymusic.tk/assets/hojasVida'.$_FILES[$this->input->get('hojaVida')]["name"]);
			*/
		$config['upload_path'] = 'https://www.eddymusic.tk/assets/hojasVida';
		
		$this->load->library('upload',$config);
		
		if(!$this->upload->do_upload($imagen) ){
			$error = array( 'error' => $this->upload->display_errors() );
		}
		else{
			$data = array( 'upload_data' => $this->upload->data() );
		}
		$a = array(
			'name' => $this->input->get('name'),
			'type_document' => 1, //int -  0 Ti, 1: cedula, 
			'document' => $this->input->get('document'), // int 
			'birthday' => $this->input->get('birthday'), // string: yyyy-mm-dd
			'date' => date('Y-m-d H:i:s'), // string: yyyy-mm-dd
			'level' => 2, // 0: admin, 1: secretario, 2: profesor, 3:alumno,
			'email' => $this->input->get('email'), //
			'tel' => $this->input->get('tel'),
			'password' => do_hash($this->input->get('password')),
			'idSucursal'=> $_SESSION['sucursal']
		);
		if($id==0){
			$this->db->insert('users',$a);
			$id = $this->db->insert_id();
			$this->mainModel->addLog('Teacher Created','',$id);
		}else{
			$this->db->where('id',$id)->update('users',$a);
			$this->mainModel->addLog('Teacher Edited','',$id);
		}
		$sql = $this->db->where('id',$id)->get('users')->result();

		$b['content'] = $sql;
		$b['response'] = 2;
		echo json_encode($b);
	}
	public function autenticar(){
		$user= $this->input->get('user');
		$pass = $this->input->get('pass');
		$sql = $this->db->where('name',$user)->where('password',$pass)->get('users');
		if($sql->num_rows()==0){
			$r['response'] = 2;
			$r['content'] = 'userNotExist';
		}else{
			$r['response'] = 1;
			$r['content'] = 'userExist';
		}
		echo json_encode($r);
	}
	public function checkData(){
		echo '<pre>';
			var_dump($_GET);
		echo '</pre>';
	}
	public function deleteClassStudent(){
		// echo '<pre>';
		// 	var_dump($_GET);
		// echo '</pre>';
		$this->db
		->where('idStudent',$this->input->get('idUser'))
		->where('idClassHead',$this->input->get('idClassHead'))
		->update('relStudentClassHead',array('status'=>1));
		$r['response'] = 2;
		$r['content'] = 'deleted';
		echo json_encode($r);
	}
	public function changeSucursal(){
		$idSucursal = $this->input->get('idSucursal');
		//if($_SESSION['data_user']['level']==0)		{
			$_SESSION['sucursal'] = $idSucursal;
			$r['response'] = 2;
			$r['content'] = 'setted';
			echo json_encode($r);
		//}
	}
	public function checkDocument(){
		$doc = $this->input->get('doc');
		$type = $this->input->get('type');
		$sql = $this->db->where('type_document',$type)->where('document',$doc)->get('users');
		if($sql->num_rows()==0){
			$r['response'] = 2;
			$r['content'] = 'userNotExist';
		}else{
			$r['response'] = 1;
			$r['content'] = 'userExist';
		}
		echo json_encode($r);
	}
	public function calcularDineroIngresos(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$this->db->select_sum('price');
		$this->db->from('clasesBuys cb');
		$this->db->where('medioPago',0);
		$this->db->where('cb.date >=',$fechaInicio.' 00:00:00');
		$this->db->where('cb.date <=',$fechaFin.' 23:59:59');
		$this->db->where('idSucursal',$_SESSION['sucursal']);
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		$r['sucursal'] = $_SESSION['sucursal'];
		echo json_encode($r);
	}
	public function calcularDineroEgresos(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$this->db->select_sum('valor');
		$this->db->from('egresos');
		$this->db->where('medioPago',0);
		$this->db->where('egresos.fecha >=',$fechaInicio.' 00:00:00');
		$this->db->where('egresos.fecha <=',$fechaFin.' 23:59:59');
		$this->db->where('idSucursal',$_SESSION['sucursal']);
		////falta el where para que hale los datos de la sucursal de quien esta en la sesion
		//$this->db->order_by('date desc');
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function calcularDineroEgresosBanco(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$this->db->select_sum('valor');
		$this->db->from('egresos');
		$this->db->where('medioPago',1);
		$this->db->where('egresos.fecha >=',$fechaInicio.' 00:00:00');
		$this->db->where('egresos.fecha <=',$fechaFin.' 23:59:59');
		$this->db->where('idSucursal',$_SESSION['sucursal']);
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function calcularDineroIngresosBanco(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$this->db->select_sum('price');
		$this->db->from('clasesBuys cb');
		$this->db->where('medioPago',1);
		$this->db->where('cb.date >=',$fechaInicio.' 00:00:00');
		$this->db->where('cb.date <=',$fechaFin.' 23:59:59');
		$this->db->where('idSucursal',$_SESSION['sucursal']);
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function deleteInstrument(){
		$id = $this->input->get('id');
		$sql2 = $this->db->where('idInstrument',$id)->delete('userRelInstrument');
		$sql = $this->db->where('id',$id)->delete('instrumentos');
		$sql2 = $this->db->where('idInstrument',$id)->delete('userRelInstrument');
		$this->mainModel->addLog('insturmentDeleted','',$id);
		$r['response'] = 2;
		$r['content'] = 'deleted';
		echo json_encode($r);
	}
	public function deleteUser(){
		$id = $this->input->get('id');
		$sql = $this->db->where('idUser',$id)->delete('userRelInstrument');
		//$sql = $this->db->where('idUser',$id)->delete('directorios');
		$sql = $this->db->where('id',$id)->delete('users');
		$this->mainModel->addLog('Usuario Eliminado','',$id);
		$r['response'] = 2;
		$r['content'] = 'deleted';
		echo json_encode($r);
	}
	public function deleteClassHistoryStudent(){
		$id = $this->input->get('id');
		$this->db->where('id',$id)->delete('clases');
		$this->mainModel->addLog('Clase Historico eliminada','',$id);
		$r['response'] = 2;
		$r['content'] = 'Clase Borrada';
		echo json_encode($r);
	}
	public function deleteIngreso(){
		$id = $this->input->get('id');
		$this->db->where('id',$id)->delete('clasesBuys');
		$this->mainModel->addLog('Ingreso Borrado','',$id);
		$r['response'] = 2;
		$r['content'] = 'IngresoBorrado';
		echo json_encode($r);
	}
	public function deleteEgreso(){
		$id = $this->input->get('id');
		$this->db->where('id',$id)->delete('egresos');
		$this->mainModel->addLog('Egreso Borrado','',$id);
		$r['response'] = 2;
		$r['content'] = 'Egreso Borrado ';
		echo json_encode($r);
	}
	public function editUser(){
		$id = $this->input->get('id');
		$a = array(
			'name' => $this->input->get('name'),
			'idHuellero' => $this->input->get('idHuellero'),
			'type_document' => $this->input->get('type_document'), //int -  0 Ti, 1: cedula, 
			'document' => $this->input->get('document'), // int 
			'birthday' => $this->input->get('birthday'), // string: yyyy-mm-dd
			'observaciones' => $this->input->get('observaciones'),
			'password' => do_hash($this->input->get('password')),
			);
		$this->db->where('id',$id); //inserto el usuaruo en la tabla
		$this->db->update('users',$a);
		$this->mainModel->addLog('Informacion de Usuario Editada','',$id);
		$r['response'] = 2;
		$r['content'] = 'Actualizado';
	}
	public function editInfoUser(){
		// $r = array(
		// 	'name' => $this->input->get('name'),
		// 	'type_document' => $this->input->get('type_document'), //int -  0 Ti, 1: cedula, 
		// 	'document' => $this->input->get('document'), // int 
		// 	'birthday' => $this->input->get('birthday'), // string: yyyy-mm-dd
		// 	'date' => date('Y-m-d H:i:s'), // string: yyyy-mm-dd
		// 	'observaciones' => $this->input->get('observaciones'),
		// 	'level' => $this->input->get('level'), // 0: admin, 1: secretario, 2: profesor, 3:alumno,
		// 	'email' => $this->input->get('email'), //
		// 	'tel' => $this->input->get('tel'), //
		// 	'password' => do_hash($this->input->get('password')),
		// 	'tel2'=> $this->input->get('tel2'), // para el telefono 2 
		// 	//'address'=> $this->input->get('address'), 
		// 	'nombreAcudiente' => $this->input->get('nombreAcudiente'), //
		// 	// 'nClases'=> $this->input->get('nClases'), // para el numero de clases
		// 	'numeroInscripcion'=> $this->input->get('numeroInscripcion'),
		// 	'direccion'=> $this->input->get('direccion')
		// 	);
		// $name = $this->input->get('nameEdit');
		// $name = $this->input->get('nameEdit');
		// $name = $this->input->get('nameEdit');
		// $name = $this->input->get('nameEdit');
		// $name = $this->input->get('nameEdit');
		echo '<pre>';
			var_dump($_GET);
		echo '</pre>';
	}
	public function formClassUser(){
		$idUser = $this->input->get('idUser');
		$this->data['idUser'] = $idUser;
		$this->load->view('admin/clasesStudent', $this->data,FALSE);
	}
	public function filtrarIngresosEfectivo(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$this->db->select('cb.*,i.name,es.name nombre');
		$this->db->from('clasesBuys cb');
		$this->db->join('instrumentos i','cb.idInstrument = i.id','left outer' );
		$this->db->join('users es','cb.idStudent = es.id','left outer' );
		$this->db->where('medioPago',0);
		$this->db->where('cb.date >=',$fechaInicio.' 00:00:00');
		$this->db->where('cb.date <=',$fechaFin.' 23:59:59');
		$this->db->where('cb.idSucursal',$_SESSION['sucursal']);
		////falta el where para que hale los datos de la sucursal de quien esta en la sesion
		$this->db->order_by('date desc');
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function filtrarIngresosBanco(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$this->db->select('cb.*,i.name,es.name nombre');
		$this->db->from('clasesBuys cb');
		$this->db->join('instrumentos i','cb.idInstrument = i.id','left outer' );
		$this->db->join('users es','cb.idStudent = es.id','left outer' );
		$this->db->where('medioPago',1);
		$this->db->where('cb.date >=',$fechaInicio.' 00:00:00');
		$this->db->where('cb.date <=',$fechaFin.' 23:59:59');
		$this->db->where('cb.idSucursal',$_SESSION['sucursal']);
		////falta el where para que hale los datos de la sucursal de quien esta en la sesion
		$this->db->order_by('date desc');
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function filtrarEgresosEfectivo(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$sql = $this->db->where('medioPago',0)->where('fecha >=',$fechaInicio.' 00:00:00')->where('fecha <=',$fechaFin.' 23:59:59')->where('idSucursal',$_SESSION['sucursal'])->get('egresos'); //0 para medio pago efectivo 1 para medio pago banco 
		$r['response'] = 2;	
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function filtrarEgresosBanco(){
		$fechaInicio= $this->input->get('fechaInicio');
		$fechaFin= $this->input->get('fechaFin');
		$sql = $this->db->where('medioPago',1)->where('fecha >=',$fechaInicio.' 00:00:00')->where('fecha <=',$fechaFin.' 23:59:59')->where('idSucursal',$_SESSION['sucursal'])->get('egresos'); //0 para medio pago efectivo 1 para medio pago banco 
		$r['response'] = 2;	
		$r['content'] = $sql->result();
		echo json_encode($r);	
	}
	public function flujoDeCajaEfectivo(){
		$total=$this->mainModel->obtenerDineroEfectivo();
		$r['response'] = 2;
		$r['content'] = $total;
		echo json_encode($r);
	}
	public function flujoDeCajaBanco(){
		
		$total=$this->mainModel->obtenerDineroBanco();
		$r['response'] = 2;
		$r['content'] = $total;
		echo json_encode($r);
	}
	public function cumpleanos(){
		$sql = $this->db->select('name title,birthday start')->where('level',3)->where('idSucursal',$_SESSION['sucursal'])->get('users');/*Los renombro como title y start por que asi los coje el front del calendario*/ 
		//$auxiliar = $sql->result()[20]->start;
		foreach ($sql->result() as $key => $c) {
			///Esta funcion me toma la fecha y le cambiar el año al actual
			$year = date('Y');
			$myMonthDay = date('m-d', strtotime($c->start)); 			
			$c->start = $year . '-' . $myMonthDay;
			$data[] = array('title'=>$c->title,'start'=>$c->start);
		}
		$r['response']=$data;
		echo json_encode($r);
	}
	public function getClassAvailableStudent(){
		$sql = $this->db->where('idInstrument',$this->input->get('idInstrument'))->where('idSucursal',$_SESSION['sucursal'])->order_by('nDay asc, time asc')->get('clasesHead');//Obtiene las Cabeceras de clase (Esta bien hecha la consulta)
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
			$nAlumns = $this->db->select('COUNT(id) AS n')->where('status',0)->where('type',0)->where('idClassHead',$c->id)->get('relStudentClassHead')->result()[0]->n; //aqui cuento cuantos estudiantes hay matriculados con 0 o 1
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
	public function getEgresosEfectivo(){
		$sql = $this->db->where('medioPago',0)->where('idSucursal',$_SESSION['sucursal'])->get('egresos'); //0 para medio pago efectivo 1 para medio pago banco 
		$r['response'] = 2;	
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getEgresosBancos(){
		$sql = $this->db->where('medioPago',1)->where('idSucursal',$_SESSION['sucursal'])->get('egresos'); 
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function deleteClassHead(){
		$id = $this->input->get('id');
		$this->db->where('id',$id)->delete('clasesHead');
		$this->mainModel->addLog('Se elimino Una clase',$_SESSION['sucursal'],$id);
		$r['response'] = 2;
		$r['content'] = "Se Borro la clase";
		echo json_encode($r);
	}
	public function getHeadClassInstrumentHour(){
		$time = $this->input->get('time');
		$nDay = $this->input->get('nDay');
		$sql = $this->db->where('time',$time)->where('nDay',$nDay)->where('idSucursal',$_SESSION['sucursal'])->get('clasesHead');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getHoursResidual(){
		$idUser = $this->input->get('idUser');
		$idInstrument = $this->input->get('idInstrument');
		$nHours = $this->mainModel->horasRestantesEstudiante($idUser, $idInstrument);
		$r['response'] = 2;
		$r['content'] = $nHours;
		echo json_encode($r);
	}
	public function getIngresosEfectivo(){
		$this->db->select('cb.*,i.name,es.name nombre,es.idSucursal');
		$this->db->from('clasesBuys cb');
		$this->db->join('instrumentos i','i.id=cb.idInstrument', 'left outer');
		$this->db->join('users es','es.id=cb.idStudent', 'left outer');
		$this->db->where('medioPago',0);
		$this->db->where('cb.idSucursal',$_SESSION['sucursal']);
		$this->db->order_by('date desc');
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getIngresosBanco(){
		$this->db->select('cb.*,i.name,es.name nombre,es.idSucursal');
		$this->db->from('clasesBuys cb');
		$this->db->join('instrumentos i','i.id=cb.idInstrument', 'left outer');
		$this->db->join('users es','es.id=cb.idStudent', 'left outer' );
		$this->db->where('medioPago',1);
		$this->db->where('cb.idSucursal',$_SESSION['sucursal']);
		$this->db->order_by('date desc');
		$sql=$this->db->get();
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getBitacoras(){
		$instrumento = $this->input->get('id');
		$sql = $this->db->select('users.name estudiante ,instrumentos.name instrumento,clases.bitacora bitacora,clases.dateClass fecha,clases.idTeacher profesor')
						->where('idInstrument',$instrumento)
						//->where('clases.bitacora is not null')
						->where('clases.status',1)
						->join('users','users.id=clases.idStudent')
						//->join('users','users.id=clases.idTeacher')
						->join('instrumentos','instrumentos.id=clases.idInstrument')
						->order_by('clases.date desc')
						->get('clases');
		/*echo '<pre>';
		 	var_dump($sql->result()[0]);
		
		 echo '</pre>';*/
		if($sql->num_rows()>0){
			$data = array();
			foreach($sql->result() as $key => $c){ // con esto cambio el id del profesor por su nombre en cada registro de la consulta
				$idProfesor = $c->profesor;
				if($idProfesor!=0){
					$c->profesor = $this->db->select('name')->where('id',$idProfesor)->get('users')->result()[0]->name;
				}
			}
			$r['content'] = $sql->result();
			$r['response']=2;
		}else{
			$r['content'] = "No Hay Resultados";
			$r['response']=1;
		}
		
		echo json_encode($r);
	}
	public function getInstruments(){
		if(isset($_GET['id'])){
			$this->db->where('id',$_GET['id']);
		}
		$sql = $this->db->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getInstrumentosSucursal(){
		$sql = $this->db->select('A.*')->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos A');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getInstrumentsStudent(){
		$idUser = $this->input->get('idUser');
		$sql = $this->db->select('A.*')->join('instrumentos A','A.id=B.idInstrument')->where('B.idUser',$idUser)->get('userRelInstrument B');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getInstrumentPackageStudent(){
		$idUser = $this->input->get('idUser');
		$idInstrument = $this->input->get('idInstrument');
		$sql = $this->db->where('idStudent',$idUser)->where('idInstrument',$idInstrument)
						->order_by('clasesBuys.date desc')->get('clasesBuys');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getInsturmentById(){
		$id = $this->db->where('id',$id)->get('instrumentos');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getClassWeek(){
		$f = $this->input->get('dateStart');
		$data = array();
		$b = 1;
		for($i=0; $i<7;$i++){
			$date = $f;
			$stro = strtotime($date. '+'.$i.' days');
			$date = date('Y-m-d',$stro);
			$start = $date.' 00:00:00';
			$end = $date.' 23:59:59';
			$sqlRecurrent = $this->db->where('clasesHead.nDay',$b)->where('A.type',0)->where('clasesHead.idSucursal',$_SESSION['sucursal'])->where('A.status',0)->join('relStudentClassHead A','A.idClassHead=clasesHead.id')->get('clasesHead');
			$sqlUnique = $this->db->where('A.dateStart >',$start)->where('A.dateStart <',$end)->where('A.type >',0)->where('clasesHead.idSucursal',$_SESSION['sucursal'])->join('relStudentClassHead A','A.idClassHead=clasesHead.id')->get('clasesHead');
			$data[$date] = array('regular'=>$sqlRecurrent->result(),'single'=> $sqlUnique->result());
			$b++;
		}
		$r['response'] = 2;
		$r['content'] = $data;
		echo json_encode($r);
		// echo '<pre>';
		// 	var_dump($stro);
		// 	var_dump($date);
		// echo '</pre>';
	}
	public function getLevelCurrentUser(){
		$r['response'] = 2;
		$r['content'] = $_SESSION['data_user']->level;
		echo json_encode($r);
	}
	public function getListStudentClass(){
		// echo '<pre>';
		// 	var_dump($_GET);
		// echo '</pre>';
		$date = $this->input->get('date');
		$time = $this->input->get('time');
		$idClassHead = $this->input->get('idClassHead');
		$sql = $this->db->select('U.name as nameStudent, U.id as idStudent, C.*, c.id as idClass, clases.status AS asistenciaClase, clases.idTeacher, c.type')->join('relStudentClassHead c','c.idClassHead=C.id')->join('users U','U.id=c.idStudent')->join('clases','clases.idClassHead=C.id AND clases.dateClass="'.$date.'" AND clases.idStudent=U.id', 'left outer')->where('C.id',$idClassHead)->where('(((c.type="2" OR c.type="1") AND c.dateStart="'.$date.' '.$time.'") OR (c.type="0"))')->get('clasesHead C');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		$r['data'] = $_GET;
		echo json_encode($r);
	}
	public function getSoonClassStudentInstrument(){
		$idUser = $this->input->get('idUser');
		$idInstrument = $this->input->get('idInstrument');
		$date = date('Y-m-d').' 00:00:00';
		$sql = $this->db->select('A.*, A.id AS idClassStudentRel')->where('A.idStudent',$idUser)->join('clasesHead C','C.id=A.idClassHead')->where('C.idInstrument',$idInstrument)->where('A.status',0)->where('type',0)->get('relStudentClassHead A');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getSucursales(){
		$sql = $this->db->get('sucursales');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getSucursalActive(){
		$sql = $this->db->where('id',$this->sucursal)->get('sucursales');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUsers(){ //Para llenar la tabla de los usuarios
		$sql = $this->db->where('level',3)->where('idSucursal',$_SESSION['sucursal'])->order_by('name asc')->get('users'); //ordena pro orden alfabetico
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getTeachers(){ //Para llenar la tabla de los usuarios
		$sql = $this->db->where('level',2)->where('idSucursal',$_SESSION['sucursal'])->order_by('name asc')->get('users'); //ordena pro orden alfabetico
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUserById(){
		$id = $this->input->get('idseleccion');
		$sql = $this->db->where('id',$id)->where('idSucursal',$_SESSION['sucursal'])->get('users');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUserByIdDirectory(){
		$id = $this->input->get('idseleccion');
		$sql = $this->db->where('idUser',$id)->where('idSucursal',$_SESSION['sucursal'])->get('directorios');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUsersDirectory(){
		$sql = $this->db->where('level',3)->where('idSucursal',$_SESSION['sucursal'])->get('users');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUserLevel(){
		$level = $this->input->get('level');
		if($level!=null){
			$this->db->where('level',$level);
		}
		$this->db->where('idSucursal',$_SESSION['sucursal']);
		$sql = $this->db->get('users');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getCancelaciones(){
		/*Esta funcion me permite obtener las clases que han sido reprogramadas en la ultima semana*/ 
		$day = date('w');
		$week_start = date('Y-m-d', strtotime('-'.$day.' days')).' 00:00:00';
		$week_end = date('Y-m-d', strtotime('+'.(6-$day).' days')).' 00:00:00';
		$sql = $this->db->select('relStudentClassHead.*,users.name,instrumentos.name instrumento')
						->where('type',2)
						->where('relStudentClassHead.date>',$week_start)
						->where('relStudentClassHead.date<',$week_end)
						->join('users','relStudentClassHead.idStudent = users.id')
						->join('clasesHead','relStudentClassHead.idCLassHead = clasesHead.id')
						->join('instrumentos','clasesHead.idInstrument = instrumentos.id')
						->order_by('relStudentClassHead.date desc')
						->get('relStudentClassHead')->result();
		$r['response'] = 2;
		$r['content'] = $sql;
		echo json_encode($r);
	}
	public function historyClassStudent(){ //sirve para buscar el historial de clases de un estudiante por istrumento 
		$f1 = $this->input->get('dateFrom');
		$f2 = $this->input->get('dateEnd');
		$idInstrument = $this->input->get('idInstrument');
		$idStudent = $this->input->get('idStudent');
		$sql = $this->db->select('clases.id,clases.dateClass,idStudent,idTeacher,users.name,clases.status')->join('users','clases.idTeacher = users.id', 'left outer')->/*where('dateClass >=',$f1.' 00:00:00')->where('dateClass <=',$f2.' 23:59:59')->*/where('idInstrument',$idInstrument)->where('idStudent',$idStudent)->where('status!=',0)->order_by('clases.dateClass','desc')->get('clases');
		if($sql->num_rows()==0){
			$r['response'] = 1;
			$r['content'] = $sql->result();
			echo json_encode($r);
		}else{
			$r['response'] = 2;
			$r['content'] = $sql->result();
			echo json_encode($r);
		}
	}
	public function loadHandleClassInstruments(){
		$data['date'] = $this->input->get('date');
		$this->load->view('admin/addClassForm', $data, FALSE);
	}
	public function nav(){
		$uri = $this->uri->segment(3);
		if($uri!=null){
			$this->data['view'] = $uri;
		}
		$this->load->view('admin/index',$this->data);
	}
	public function precioHoraClase(){
		$instrumento = $this->input->get('idInstrument');
		$horas= $this->input->get('nHours');
		$costoHora= $this->db->select('precioHora')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora;
		if ($horas == 4){
			$costoHora= $this->db->select('precioHora')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora;
		}
		if ($horas == 8){
			$costoHora= $this->db->select('precioHora8')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora8;
		}
		if ($horas == 12){
			$costoHora= $this->db->select('precioHora12')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora12;
		}
		if ($horas == 16){
			$costoHora= $this->db->select('precioHora16')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora16;
		}
		if ($horas == 20){
			$costoHora= $this->db->select('precioHora20')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora20;
		}
		if ($horas == 24){
			$costoHora= $this->db->select('precioHora24')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora24;
		}
		if ($horas == 72){
			$costoHora= $this->db->select('precioHora72')->where('id',$instrumento)->where('idSucursal',$_SESSION['sucursal'])->get('instrumentos')->result()[0]->precioHora72;
		}
		$valor= $costoHora;//aqui saco el costo de lo que valdrian esas horas
		$r['response'] = 2;
		$r['content'] = $valor;
		echo json_encode($r);
	}
	public function sendInstrument(){
		// echo '<pre>';
		// 	var_dump($_GET);
		// echo '</pre>';
		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$precio = $this->input->get('precioHora');
		$precio8 = $this->input->get('precioHora8');
		$precio12 = $this->input->get('precioHora12');
		$precio16 = $this->input->get('precioHora16');
		$precio20 = $this->input->get('precioHora20');
		$precio24 = $this->input->get('precioHora24');
		$precio72 = $this->input->get('precioHora72');
		$cupos = isset($_GET['nCupo']) ? $this->input->get('nCupo') : 0;
		//$a = array('name'=>$name, 'cupos'=>$this->input->get('nCupos'));
		$a = array('name'=>$name,
					'cupos'=>$cupos,
					'idSucursal'=>$_SESSION['sucursal'],
					'precioHora'=>$precio,
					'precioHora8'=>$precio8,
					'precioHora12'=>$precio12,
					'precioHora16'=>$precio16,
					'precioHora20'=>$precio20,
					'precioHora24'=>$precio24,
					'precioHora72'=>$precio72
				);
		if($id==0){
			$this->db->insert('instrumentos',$a);
			$id = $this->db->insert_id();
		}else{
			$this->db->where('id',$id)->update('instrumentos',$a);
		}
		$sql = $this->db->where('id',$id)->get('instrumentos');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function removeClassStudent(){
		$id = $this->input->get('id');
		//$this->db->where('id',$id)->update('relStudentClassHead',array('status'=>1));
		$this->db->where('id',$id)->delete('relStudentClassHead');
		$this->mainModel->addLog('Clase de horario eliminada a estudiante','',$id);
		$r['response'] = 2;
		$r['content'] = 'removed';
		echo json_encode($r);
	}
	public function toggleBlockedClass(){
		$idClassHead = $this->input->get('idClassHead');
		$val = $this->input->get('val');
		$this->db->where('id',$idClassHead)->update('clasesHead',array('private'=>$val));
		$r['response'] = 2;
		$r['content'] = 'saved';
		echo json_encode($r);
	}
	public function sendHojaVideMaestro(){
		$id = $this->input->post('idMaster');
		$file = file_get_contents($_FILES['file']['tmp_name']);
		$check = $this->db->where('idMaestro',$id)->get('maestrosHojaVida')->num_rows() > 0;
		$a = array(
			'file' => $file,
			'date' => date('Y-m-d H:i:s')
		);
		if($check){
			$this->db->where('idMaestro',$id)->update('maestrosHojaVida',$a);
		}else{
			$a['idMaestro'] = $id;
			$this->db->insert('maestrosHojaVida',$a);
		}
		$r['response'] = 2;
		$r['content'] = 'saved';
		echo json_encode($r);

	}
	public function getHojaVidaMaestro(){
		$id = $this->input->get('idMaster');
		$sql = $this->db->where('idMaestro',$id)->get('maestrosHojaVida');
		$r['response'] = 2;
		if($sql->num_rows()==0){
			$r['file'] = null;
		}else{

			$r['file'] = base64_encode($sql->result()[0]->file);
		}
		echo json_encode($r);
	}
}
