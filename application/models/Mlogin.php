<?php

class Mlogin extends CI_Model{

    /*
    public function ingresar($usu,$pass){
        ///////Esta es una consulta en sql adaptada a codeigniter para autenticar el usuario y que se pueda logear
        $this->db->select('id,name');
        $this->db->from('users');
        $this->db->where('name',$usu); // esto es cuando son iguales
        $this->db->where('password',$pass);
        /////////////////////////////////////

        $resultado = $this->db->get(); //aca se almacena la consulta que se acaba de hacer

        if($resultado->num_rows() ==1){
            $r = $resultado->row(); // toma el registro 

            $s_usuario = array(
                's_idusuario' => $r->id, //session_idusuario es el usuario de la sesion actual
                's_nombre' => $r->name  
            );
            $this->session->set_userdata($s_usuario); // metodo de codeignite para abrir la sesion cuando es mediante arreglo 
            return 1; // todo salio bien

        }else{
            return 0; //si no existe
        }

        return $resutlado->result();

    }
    */

    

}