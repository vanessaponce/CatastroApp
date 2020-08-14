<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hogares extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hogaresModel');
    }

    public function index()
    {
        $this->load->view('hogares/hogares_v');
    }

    public function showHogar()
    {
        $data = $this->hogaresModel->showHogar();
        echo json_encode($data);
    }
    public function showProvincia()
    {
        $data = $this->hogaresModel->showProvincia();
        echo json_encode($data);
    }
    public function showCanton()
    {
        $data = $this->hogaresModel->showCanton();
        echo json_encode($data);
    }
    public function showParroquia()
    {
        $data = $this->hogaresModel->showParroquia();
        echo json_encode($data);
    }
    public function showCanton1()
    {
        $data = $this->hogaresModel->showCanton1();
        echo json_encode($data);
    }
    public function showParroquia1()
    {
        $data = $this->hogaresModel->showParroquia1();
        echo json_encode($data);
    }
    public function registrarHogar()
    {
        $data = $this->hogaresModel->registrarHogar();
        echo json_encode($data);
    }
    
}
