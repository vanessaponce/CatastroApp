<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reportes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reportesModel');
    }

    public function index()
    {
        $this->load->view('reportes/reportes_v');
    }

    public function reporteHogar()
    {
        $data = $this->reportesModel->reporteHogar();
        echo json_encode($data);
    }
    
    public function reportePersonaActiva()
    {
        $data = $this->reportesModel->reportePersonaActiva();
        echo json_encode($data);
    }

    public function reportePersonaInactiva()
    {
        $data = $this->reportesModel->reportePersonaInactiva();
        echo json_encode($data);
    }
}
