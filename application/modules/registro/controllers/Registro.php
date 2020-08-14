<?php defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('registroModel');
    }

    public function index()
    {
        $this->load->view('registro/registrarse_v');
    }

    public function validarUsuario()
    {
        $data = $this->registroModel->validarUsuario();
        echo json_encode($data);
    }
    
    public function registrarUsuario()
    {
        $data = $this->registroModel->registrarUsuario();
        echo json_encode($data);
    }

}
