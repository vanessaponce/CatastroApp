<?php defined('BASEPATH') or exit('No direct script access allowed');

class Personas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('personasModel');
    }

    //MENU
    public function index()
    {
        $this->load->view('personas/menu_v');
    }
    public function persona()
    {
        $this->load->view('personas/personas_v');
    }
    public function hogar()
    {
        $this->load->view('hogares/hogar_v');
    }
    public function reportes()
    {
        $this->load->view('reportes/reportes_v');
    }
    public function cuenta()
    {
        $this->load->view('personas/cuenta_v');
    }
    public function pass()
    {
        $this->load->view('personas/pass_v');
    }
    public function salir()
    {
        $this->load->view('login/login_v');
    }

    //PERSONAS
    public function showCuenta()
    {
        $data = $this->personasModel->showCuenta();
        echo json_encode($data);
    }
    
    public function updatePass()
    {
        $data = $this->personasModel->updatePass();
        echo json_encode($data);
    }

    public function showPersonas()
    {
        $data = $this->personasModel->showPersonas();
        echo json_encode($data);
    }
    
    public function buscarPersona()
    {
        $data = $this->personasModel->buscarPersona();
        echo json_encode($data);
    }

    public function tipoPersona()
    {
        $data = $this->personasModel->tipoPersona();
        echo json_encode($data);
    }
    
    public function registrarPariente()
    {
        $data = $this->personasModel->registrarPariente();
        echo json_encode($data);
    }

    public function bajaPersona()
    {
        $data = $this->personasModel->bajaPersona();
        echo json_encode($data);
    }

    public function cambiarPass()
    {
        $data = $this->personasModel->cambiarPass();
        echo json_encode($data);
    }

    public function deshabilitarCuenta()
    {
        $data = $this->personasModel->deshabilitarCuenta();
        echo json_encode($data);
    }

}
