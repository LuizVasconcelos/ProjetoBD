<?php

class Suppliers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SuppliersModel');

        if (!$this->session->userdata('is_logged_in'))
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
        $data['suppliers'] = $this->SuppliersModel->get_suppliers($search_data);

        // load the view
        $data['main_content'] = 'suppliers/list';
        $this->load->view('includes/template', $data);
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // form validation
            $this->form_validation->set_rules('cnpj', 'cnpj', 'required|numeric');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'cnpj' => $this->input->post('cnpj'),
                    'nome' => $this->input->post('name')
                );

                $data['flash_message'] = $this->SuppliersModel->store($data_to_store);
            }
        }

        //load the view
        $data['main_content'] = 'suppliers/add';
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
            $this->form_validation->set_rules('cnpj', 'cnpj', 'required|numeric');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'cnpj' => $this->input->post('cnpj'),
                    'nome' => $this->input->post('name')
                );

                $data['flash_message'] = $this->SuppliersModel->update($id, $data_to_store);
            }
        }

        // if we are updating, and the data did not pass trough the validation
        // the code below wel reload the current data

        // supplier data
        $data['supplier'] = $this->SuppliersModel->supplier($id);

        // load the view
        $data['main_content'] = 'suppliers/edit';
        $this->load->view('includes/template', $data);
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        try {
            $this->SuppliersModel->delete($id);
            redirect($this->uri->segment(1));
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            redirect($this->uri->segment(1));
        }
    }
}
