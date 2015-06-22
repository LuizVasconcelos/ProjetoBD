<?php

class Products extends CI_Controller {

    var $cached_search_string = '';
    var $cached_order = 'nome';
    var $cached_order_type = 'ASC';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductsModel');

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
        $data['products'] = $this->ProductsModel->get_products($search_data);

        // load the view
        $data['main_content'] = 'products/list';
        $this->load->view('includes/template', $data);
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // form validation
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('amount', 'amount', 'required|numeric');
            $this->form_validation->set_rules('price', 'price', 'required|numeric');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'nome' => $this->input->post('name'),
                    'qtd' => $this->input->post('amount'),
                    'preco' => $this->input->post('price'),
                    'descricao' => $this->input->post('description')
                );

                $data['flash_message'] = $this->ProductsModel->store($data_to_store);
            }
        }

        // load the view
        $data['main_content'] = 'products/add';
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
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('amount', 'amount', 'required|numeric');
            $this->form_validation->set_rules('price', 'price', 'required|numeric');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'nome' => $this->input->post('name'),
                    'qtd' => $this->input->post('amount'),
                    'preco' => $this->input->post('price'),
                    'descricao' => $this->input->post('description')
                );

                $data['flash_message'] = $this->ProductsModel->update($id, $data_to_store);
            }
        }

        // if we are updating, and the data did not pass trough the validation
        // the code below wel reload the current data

        // product data
        $data['product'] = $this->ProductsModel->product($id);

        // load the view
        $data['main_content'] = 'products/edit';
        $this->load->view('includes/template', $data);
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $this->ProductsModel->delete($id);
        redirect(site_url() . $this->uri->segment(1));
    }
}
