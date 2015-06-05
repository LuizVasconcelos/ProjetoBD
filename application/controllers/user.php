<?php

class User extends CI_Controller {

	function index()
	{
        if ($this->session->userdata('is_logged_in'))
        {
            if ($this->session->userdata('is_manager'))
                redirect('employees');
            else
                redirect('products');
        }
        else
        	$this->load->view('login');	
	}

    function __encrip_password($password) {
        return md5($password);
    }	

	function validate_credentials()
	{	

		$this->load->model('UsersModel');

		$user_name = $this->input->post('user_name');
		$password = $this->input->post('password');
		//$password = $this->__encrip_password($this->input->post('password'));

		$is_valid = $this->UsersModel->validate($user_name, $password);
		
		if ($is_valid)
		{
            $var = $this->UsersModel->check_manager($user_name);
			$data = array(
				'user_name' => $user_name,
                'is_logged_in' => true,
                'is_manager' => $var
			);
			$this->session->set_userdata($data);

            if ($var)
                redirect('employees');
            else
                redirect('products');
		}
		else // incorrect username or password
		{
			$data['message_error'] = TRUE;
			$this->load->view('login', $data);	
		}
	}	

	function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	}

}
