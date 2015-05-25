<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (function_exists('date_default_timezone_set'))
   date_default_timezone_set('America/Recife');

class Home extends CI_Controller {

	public function index()
	{
        $data['main_content'] = 'home';
		$this->load->view('includes/template', $data);
	}
}
