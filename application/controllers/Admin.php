<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	private $data;
	public function __construct(){
		parent::__construct();
		$this->data = array('view'=>'addUser');
		$this->sucursal = $_SESSION['sucursal'];
		if(!isset($_SESSION['data_user'])){ //Proteccion de acceso por la url
			redirect('login','refresh');//envia a controlador login y refrezcs
		}
		$this->data['level'] = $_SESSION['data_user']->level;

	}
	public function index()	{ // siempre debe ir aqui 
		$this->load->view('admin/index',$this->data);//el segundo paramento $this->data es que le paso paramentro a esa vista $this->data = array('view'=>'home');
	}
	public function nav(){
		$uri = $this->uri->segment(3);// El segmento 3 de la url /1/2/3
		if($uri!=null){
			$this->data['view'] = $uri; // =si no hay nada en el segmento 3 entonces redirije a 
		}
		$method = '_'.$uri;
		if(method_exists($this, $method)){
			$this->$method();
		}
		$this->load->view('admin/index',$this->data);//admin es la carpeta donde esta la vista index
	}

	public function verDatos(){
		echo '<pre>';
			var_dump($_GET);
		echo '</pre>';
	}

	public function _clasesStudent(){
		$idUser = $this->uri->segment(4);
		$this->data['idUser'] = $idUser;
	}
}
