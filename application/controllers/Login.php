<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index()	{
		$this->load->view('prelogin');
	}
	public function login()	{
		$this->load->view('index');
	}
	public function makeLogin(){
		$user = $this->input->get('user');
		$pass = do_hash($this->input->get('pass'));

		//$sql = $this->db->where('(email="'.$user.'" OR document="'.$user.'" OR name="'.$user.'") AND password="'.$pass.'"')->get('users');
		$sql = $this->db->where('(name="'.$user.'") AND password="'.$pass.'"')->get('users'); // Solo inicia con el nombre
		// echo '<pre>';
		// var_dump($this->db->last_query());
		// 	var_dump($_GET);
		// 	var_dump($sql->result());
		// echo '</pre>';
		if($sql->num_rows()==1){
			$user = $sql->result()[0];
			$_SESSION['data_user'] = $user;
			$_SESSION['name'] = $user->name;
			$_SESSION['sucursal'] = $user->idSucursal;
			$r['username'] = $user;
			$response = 2;
		}else{	
			$r['Estado'] = "El usuario o la contraseña es invalida";
			$response = 1;
		}
		/*echo '<pre>';
			var_dump($_SESSION);
		echo '</pre>';*/
		$r['response'] = $response;
		echo json_encode($r);
	}
	public function verDatos(){
		echo '<pre>';
			var_dump($_GET);
		echo '</pre>';
	}
	public function logout(){
		session_destroy();
		redirect('login/index','refresh');
	}	
}
