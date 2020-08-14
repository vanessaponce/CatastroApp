<?php defined('BASEPATH') or exit('No direct script access allowed');

class Error404 extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->output->set_status_header('404'); 
        $data['content'] = 'error_404'; // View name 
        $this->load->view('error404_v',$data);//loading in my template 
    }
}