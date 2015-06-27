<?php

class Employees extends CI_Controller {

    // for listing
    var $cached_search_string = '';
    var $cached_order = 'nome';
    var $cached_order_type = 'ASC';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('EmployeesModel');

        if (!$this->session->userdata('is_logged_in'))
            redirect('login');

        if (!$this->session->userdata('is_manager'))
            redirect('login');
    }

    public function index()
    {
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        if ($search_string)
            $cached_search_string = $search_string;
        else
            $search_string = $cached_search_string;

        if ($order)
            $cached_order = $order;
        else
            $order = $cached_order;

        if ($order_type)
            $cached_order_type = $order_type;
        else
            $order_type = $cached_order_type;

        $data['search_string_selected'] = $cached_search_string;
        $data['order_selected'] = $cached_order;
        $data['order_type_selected'] = $cached_order_type;

        $search_data = array('search_string' => $search_string, 'orderby' => $order, 'order_type' => $order_type);
        $data['employees'] = $this->EmployeesModel->get_employees($search_data);

        // load the view
        $data['main_content'] = 'employees/list';
        $this->load->view('includes/template', $data);
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // form validation
            $this->form_validation->set_rules('cpf', 'CPF', 'required|numeric');
            $this->form_validation->set_rules('name', 'Nome', 'required');
            $this->form_validation->set_rules('function', 'Função', 'required');
            $this->form_validation->set_rules('salary', 'Salário', 'required|numeric');
            $this->form_validation->set_rules('password', 'Senha', 'required');
			$this->form_validation->set_rules('code[]', 'DDD', 'required');
			$this->form_validation->set_rules('phone[]', 'Número', 'required|numeric');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            $codes = $this->input->post('code');
            $phones = $this->input->post('phone');
            $numbers = array();
            for ($i = 0; $i < count($codes); $i++)
                if (!empty($codes[$i]) && !empty($phones[$i]))
                    $numbers[] = array($codes[$i], $phones[$i]);

            // if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'cpf' => $this->input->post('cpf'),
                    'nome' => $this->input->post('name'),
                    'funcao' => $this->input->post('function'),
                    'salario' => $this->input->post('salary'),
                    'senha' => $this->input->post('password'),
					'telefones' => $numbers
                );

                // if the insert has returned true then we show the flash message
                $data['flash_message'] = $this->EmployeesModel->store($data_to_store);
            }
        }

        $data['functions'] = $this->EmployeesModel->get_functions();
		$data['phonecodes'] = $this->EmployeesModel->get_phonecodes();
        $data['main_content'] = 'employees/add';
        $this->load->view('includes/template', $data);
    }

    public function update()
    {
        $id = $this->uri->segment(3);

        if (empty($id))
            redirect(site_url() . $this->uri->segment(1));

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // form validation
            $this->form_validation->set_rules('cpf', 'CPF', 'required|numeric');
            $this->form_validation->set_rules('name', 'Nome', 'required');
            $this->form_validation->set_rules('function', 'Função', 'required');
            $this->form_validation->set_rules('salary', 'Salário', 'required|numeric');
            $this->form_validation->set_rules('password', 'Senha', 'required');
			$this->form_validation->set_rules('code[]', 'DDD', 'required');
			$this->form_validation->set_rules('phone[]', 'Número', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            $codes = $this->input->post('code');
            $phones = $this->input->post('phone');
            $numbers = array();
            for ($i = 0; $i < count($codes); $i++)
                if (!empty($codes[$i]) && !empty($phones[$i]))
                    $numbers[] = array($codes[$i], $phones[$i]);

            // if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'cpf' => $this->input->post('cpf'),
                    'nome' => $this->input->post('name'),
                    'funcao' => $this->input->post('function'),
                    'salario' => $this->input->post('salary'),
                    'senha' => $this->input->post('password'),
					'telefones' => $numbers
                );

                // if the insert has returned true then we show the flash message
                $data['flash_message'] = $this->EmployeesModel->update($id, $data_to_store);
            }
        }

        // if we are updating, and the data did not pass trough the validation
        // the code below wel reload the current data

        // employee data
        $data['employee'] = $this->EmployeesModel->employee($id);
		$data['phones'] = $this->EmployeesModel->phones($id);
        $data['functions'] = $this->EmployeesModel->get_functions();
		$data['phonecodes'] = $this->EmployeesModel->get_phonecodes();
		
        // load the view
        $data['main_content'] = 'employees/edit';
        $this->load->view('includes/template', $data);
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        try {
            $this->EmployeesModel->delete($id);
            redirect(site_url() . $this->uri->segment(1));
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect($this->uri->segment(1));
        }
    }
}
