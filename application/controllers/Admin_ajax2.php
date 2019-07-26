<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pruebas desde visuallll stuidoooo
class Admin_ajax extends CI_Controller {
	private $data;
	public function __construct(){
		parent::__construct();
		$this->data = array('view'=>'addUser');
	}
	public function index()	{
		$this->load->view('admin/index',$this->data);
	}
	public function addClassUser(){
		$idUser = $this->input->get('idUser');
		$idClassHead = $this->input->get('idClassHead');
		$nHours = $this->input->get('nHours');
		$dateStart = $this->input->get('dateStart');
		$idInstrument = $this->input->get('idInstrument');
		$hoursRest = $this->mainModel->horasRestantesEstudiante($idUser,$idInstrument);
		$checkClass = $this->db->select('id')->where('idStudent',$idUser)->where('idClassHead',$idClassHead)->get('relStudentClassHead');

		if($checkClass->num_rows()==0){
			$classHead = $this->db->where('id',$idClassHead)->get('clasesHead');
			if($classHead->num_rows()>0){

				$classHead = $classHead->result()[0];
				if($classHead->private==0){
					if($hoursRest > $nHours){
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
					}else{
						$r['response'] = 1;
						$r['content'] = 'exceededHours';
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
		$nHours = $this->input->get('nHours');
		$date = $this->input->get('date');
		$a = array(
			'idInstrument' => $idInstrument,
			'dateStart' => $date,
			'hours' => $nHours,
			'nDay' => $this->input->get('dayWeek'),
			'idSucursal' => 1,
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
				'tipoDescuento' => $this->input->get('medioPago'),
				'hoursRest' => $hoursRest,
				'nRecibo' => $this->input->get('nRecibo'),
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
		$idClass = $this->input->get('idClass');
		$idTeacher = $this->input->get('idTeacher');
		$checkClass = $this->db->where('id',$idClass)->get('clases');
		if($checkClass->num_rows()>0){
			$this->db->where('id',$idClass)->update('clases',array('idTeacher'=>$idTeacher));
			$r['response'] = 2;
			$r['content'] = 'saved';
		}else{
			$r['response'] = 1;
			$r['content'] = 'classNotFound';
		}
		echo json_encode($r);			
	}
	public function statusClass(){
		$idClass = $this->input->get('idClass');
		$val = $this->input->get('val');
		$class = $this->db->where('id',$idClass)->get('clases');
		if($class->num_rows()>0){
			$class = $class->result()[0];
			$currentStatus = $class->status;
			$this->db->where('id',$idClass)->update('clases',array('status'=>$val));
			$this->mainModel->addLog('changeStatusClass',$val,$idClass);
			$r['response'] = 2;
			$r['content'] = 'saved';
		}else{
			$r['response'] = 1;
			$r['content'] = 'classNotFound';

		}
		echo json_encode($r);
	}
	public function addUser(){
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
			//'address'=> $this->input->get('address'), 
			'nombreAcudiente' => $this->input->get('nombreAcudiente'), //
			// 'nClases'=> $this->input->get('nClases'), // para el numero de clases
			'numeroInscripcion'=> $this->input->get('numeroInscripcion')
			);
		
		$this->db->insert('users',$r); //inserto el usuaruo en la tabla
		$ultimoid = $this->db->insert_id();
		if ($ultimoid >0){
			$r['idUser'] = $ultimoid;
			$r['address'] = $this->input->get('address');
			$campos = array(
				'idUser' => $r['idUser'],
				'nombre' => $r['name'],
				'acudiente' => $r['nombreAcudiente'],
				'address' => $r['address'],
				'mainTel' => $r['tel'],
				'optionalTel' => $r['tel2'],
				'cumpleaños' => $r['birthday'],
				'correo' => $r['email']
			);     
			$this->db->insert('directorios',$campos);
				
		}
		$this->mainModel->addLog('userCreated','',$ultimoid);
		$sql = $this->db->where('id',$ultimoid)->get('users')->result();
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
	public function deleteInstrument(){
		$id = $this->input->get('id');
		$sql = $this->db->where('id',$id)->delete('instrumentos');
		$this->mainModel->addLog('insturmentDeleted','',$id);
		$r['response'] = 2;
		$r['content'] = 'deleted';
		echo json_encode($r);
	}
	public function deleteUser(){
		$id = $this->input->get('id');
		$sql = $this->db->where('idUser',$id)->delete('directorios');
		$sql = $this->db->where('id',$id)->delete('users');
		$r['response'] = 2;
		$r['content'] = 'deleted';
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
		$r['response'] = 2;
		$r['content'] = 'Actualizado';
	}
	public function formClassUser(){
		$idUser = $this->input->get('idUser');
		$this->data['idUser'] = $idUser;
		$this->load->view('admin/clasesStudent', $this->data,FALSE);
	}
	public function filterTableStudent(){
		$dato= $this->input->get('dato');
		$campo= $this->input->get('campo');
		$sql = $this->db->where($campo,$dato)->where('level',3)->order_by('name asc')->get('users');
		if($sql->num_rows()==0){
			$r['response'] = 1;
			$r['content'] = 'Usuario no encontrado';
			
		}else{
			$r['response'] = 2;
			$r['content'] = $sql->result();
		}
		echo json_encode($r);
	}
	public function filterTableDirectory(){
		$dato= $this->input->get('dato');
		$campo= $this->input->get('campo');
		$sql = $this->db->where($campo,$dato)->order_by('nombre asc')->get('directorios');
		if($sql->num_rows()==0){
			$r['response'] = 1;
			$r['content'] = 'Usuario no encontrado';
			
		}else{
			$r['response'] = 2;
			$r['content'] = $sql->result();
		}
		echo json_encode($r);
	}
	public function filterTableTeachers(){
		$dato= $this->input->get('dato');
		$campo= $this->input->get('campo');
		$sql = $this->db->where($campo,$dato)->where('level',2)->order_by('name asc')->get('users');
		if($sql->num_rows()==0){
			$r['response'] = 1;
			$r['content'] = 'Usuario no encontrado';
			
		}else{
			$r['response'] = 2;
			$r['content'] = $sql->result();
		}
		echo json_encode($r);
	}
	public function getClassAvailableStudent(){
		$sql = $this->db->select('clasesHead.*, R.idStudent')->where('idInstrument',$this->input->get('idInstrument'))->join('relStudentClassHead R','R.idClassHead=clasesHead.id', 'left outer')->where('(R.idStudent='.$this->input->get('idUser').' OR R.idStudent IS NULL)')->group_by('clasesHead.id')->get('clasesHead');
		$data = array();
		foreach ($sql->result() as $key => $c) {
			// echo '<pre>';
			// 	var_dump($c->id);
			// echo '</pre>';
			$nAlumns = $this->db->select('COUNT(id) AS n')->where('idClassHead',$c->id)->get('relStudentClassHead')->result()[0]->n;
			$data[] = array('dataClass'=>$c,'studentsInscribed'=>$nAlumns);
		}
		$r['response'] = 2;
		$r['content'] = $data;
		echo json_encode($r);
	}
	public function getIngresosEfectivo(){
		$sql = $this->db->where('medioPago',0)->get('clasesBuys'); 
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getIngresosBancos(){
		$sql = $this->db->where('medioPago',1)->get('clasesBuys'); 
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getEgresosEfectivo(){
		$sql = $this->db->where('medioPago',0)->get('egresos'); 
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getEgresosBancos(){
		$sql = $this->db->where('medioPago',1)->get('egresos'); 
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getDineroEfectivo(){
		$sql = $this->db->get('flujoDinero'); 
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getHeadClassInstrumentHour(){
		$time = $this->input->get('time');
		$nDay = $this->input->get('nDay');
		$sql = $this->db->where('time',$time)->where('nDay',$nDay)->get('clasesHead');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getInstruments(){
		if(isset($_GET['id'])){
			$this->db->where('id',$_GET['id']);
		}
		$sql = $this->db->get('instrumentos');
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
		$sql = $this->db->where('idStudent',$idUser)->where('idInstrument',$idInstrument)->get('clasesBuys');
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
	public function getHoursResidual(){
		$idUser = $this->input->get('idUser');
		$idInstrument = $this->input->get('idInstrument');
		$nHours = $this->mainModel->horasRestantesEstudiante($idUser, $idInstrument);
		$r['response'] = 2;
		$r['content'] = $nHours;
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
			$sqlRecurrent = $this->db->where('clasesHead.nDay',$b)->where('A.type',0)->join('relStudentClassHead A','A.idClassHead=clasesHead.id')->get('clasesHead');
			$sqlUnique = $this->db->where('A.dateStart >',$start)->where('A.dateStart <',$end)->where('A.type >',0)->join('relStudentClassHead A','A.idClassHead=clasesHead.id')->get('clasesHead');
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
	public function getSoonClassStudentInstrument(){
		$idUser = $this->input->get('idUser');
		$idInstrument = $this->input->get('idInstrument');
		$date = date('Y-m-d').' 00:00:00';
		$sql = $this->db->where('idStudent',$idUser)->where('idInstrument',$idInstrument)->where('dateStart >',$date)->get('clases');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getListStudentClass(){
		// echo '<pre>';
		// 	var_dump($_GET);
		// echo '</pre>';
		$idClassHead = $this->input->get('idClassHead');
		$sql = $this->db->select('U.name as nameStudent, U.id as idStudent, C.*, c.id as idClass')->join('relStudentClassHead c','c.idClassHead=C.id')->join('users U','U.id=c.idStudent')->where('C.id',$idClassHead)->get('clasesHead C');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		$r['data'] = $_GET;
		echo json_encode($r);
	}
	public function getUsers(){ //Para llenar la tabla de los usuarios
		$sql = $this->db->where('level',3)->order_by('name asc')->get('users'); //ordena pro orden alfabetico
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getTeachers(){ //Para llenar la tabla de los usuarios
		$sql = $this->db->where('level',2)->order_by('name asc')->get('users'); //ordena pro orden alfabetico
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUserById(){
		$id = $this->input->get('idseleccion');
		$sql = $this->db->where('id',$id)->get('users');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUserByIdDirectory(){
		$id = $this->input->get('idseleccion');
		$sql = $this->db->where('idUser',$id)->get('directorios');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUsersDirectory(){
		$sql = $this->db->get('directorios');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
	}
	public function getUserLevel(){
		$level = $this->input->get('level');
		if($level!=null){
			$this->db->where('level',$level);
		}
		$sql = $this->db->get('users');
		$r['response'] = 2;
		$r['content'] = $sql->result();
		echo json_encode($r);
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
	public function sendInstrument(){
		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$a = array('name'=>$name);
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
	public function sendTeacher(){
		$id = $this->input->get('id');
		$a = array(
			'name' => $this->input->get('name'),
			'type_document' => 1, //int -  0 Ti, 1: cedula, 
			'document' => $this->input->get('document'), // int 
			'birthday' => $this->input->get('birthday'), // string: yyyy-mm-dd
			'date' => date('Y-m-d H:i:s'), // string: yyyy-mm-dd
			'level' => 2, // 0: admin, 1: secretario, 2: profesor, 3:alumno,
			'email' => $this->input->get('email'), //
			'password' => do_hash($this->input->get('password'))
		);
		if($id > 0){
			$this->db->where('id',$id)->update('users',$a);
			$sql = $this->db->where('id',$id)->get('users');			
			$r['response'] = 2;
			$r['content'] = $sql->result();
		}else{
			$document = $this->input->get('document');
			$type_document = $this->input->get('type_document');
			$check = $this->db->where('document',$document)->where('type_document',$type_document)->get('users');
			if($check->num_rows()==0){
				$this->db->insert('users',$a);
				$id = $this->db->insert_id();
				$sql = $this->db->where('id',$id)->get('users');			
				$r['response'] = 2;
				$r['content'] = $sql->result();
			}else{
				$r['response'] = 1;
				$r['content'] = 'documentInvalid';
			}
		}
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
}
