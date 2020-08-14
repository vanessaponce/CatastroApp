<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('loginModel');
    }

    public function index()
    {

        $this->form_validation->set_rules('userLogin', 'Usuario', 'trim|required');
        $this->form_validation->set_rules('passLogin', 'Contraseña', 'trim|required|callback_validar');

        if ($this->form_validation->run($this) == false) {
            $this->load->view('login/login_v');
        } else {
            redirect('personas');
        }
    }

    public function validar($passLogin)
    {

        $this->form_validation->set_error_delimiters('', '');

        $user = $this->input->post("userLogin");

        $result = $this->loginModel->login($user, $passLogin);

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                if ($row->ESTADO == 0) {
                    $this->form_validation->set_message('validar', 'Usuario deshabilitado, por favor comuníquese con nosotros.');
                    return false;
                } else {
                    $sess_array = $arrayName = array('ID_USUARIO' => $row->ID_USUARIO);
                    $this->session->set_userdata('logged_in', $sess_array);
                    return true;
                }
            }

        } else {
            $this->form_validation->set_message('validar', 'Usuario o contraseña incorrecto!');
            return false;
        }
    }

    public function salir()
    {

        $this->session->unset_userdata('logged_in');
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        $this->session->sess_destroy();

        redirect('login');
    }
    
}
