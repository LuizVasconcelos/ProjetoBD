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
            $this->form_validation->set_rules('cpf', 'cpf', 'required|numeric');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('function', 'function', 'required');
            $this->form_validation->set_rules('salary', 'salary', 'required|numeric');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            // if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'cpf' => $this->input->post('cpf'),
                    'nome' => $this->input->post('name'),
                    'funcao' => $this->input->post('function'),
                    'salario' => $this->input->post('salary'),
                    'senha' => $this->input->post('password')
                );

                // if the insert has returned true then we show the flash message
                $data['flash_message'] = $this->EmployeesModel->store($data_to_store);
            }
        }

        $data['functions'] = $this->EmployeesModel->get_functions();
        $data['main_content'] = 'employees/add';
        $this->load->view('includes/template', $data);  
    }       

    public function update()
    {
        $id = $this->uri->segment(3);
  
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('stock', 'stock', 'required|numeric');
            $this->form_validation->set_rules('cost_price', 'cost_price', 'required|numeric');
            $this->form_validation->set_rules('sell_price', 'sell_price', 'required|numeric');
            $this->form_validation->set_rules('manufacture_id', 'manufacture_id', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'description' => $this->input->post('description'),
                    'stock' => $this->input->post('stock'),
                    'cost_price' => $this->input->post('cost_price'),
                    'sell_price' => $this->input->post('sell_price'),          
                    'manufacture_id' => $this->input->post('manufacture_id')
                );

                if($this->products_model->update_product($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('products/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['product'] = $this->products_model->get_product_by_id($id);
        //fetch manufactures data to populate the select field
        $data['manufactures'] = $this->manufacturers_model->get_manufacturers();
        //load the view
        $data['main_content'] = 'products/edit';
        $this->load->view('includes/template', $data);            
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $this->EmployeesModel->delete($id);
        redirect(site_url() . $this->uri->segment(1));
    }
}
