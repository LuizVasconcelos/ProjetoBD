<?php

class Cashflow extends CI_Controller {

    private $cached_search_string = '';
    private $cached_order = 'id';
    private $cached_order_type = 'ASC';
    private $cached_initial_date;
    private $cached_final_date;

    public function __construct()
    {
        parent::__construct();

        $this->cached_initial_date = date('d/m/Y');
        $this->cached_final_date = date('d/m/Y');

        $this->load->model('CashflowModel');

        if (!$this->session->userdata('is_logged_in'))
            redirect('login');
    }

    public function index()
    {
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');
        $initial_date = $this->input->post('initial_date');
        $final_date = $this->input->post('final_date');

        if ($search_string)
            $this->cached_search_string = $search_string;
        else
            $search_string = $this->cached_search_string;

        if ($order)
            $this->cached_order = $order;
        else
            $order = $this->cached_order;

        if ($order_type)
            $this->cached_order_type = $order_type;
        else
            $order_type = $this->cached_order_type;

        if ($initial_date)
            $this->cached_initial_date = $initial_date;
        else
            $initial_date = $this->cached_initial_date;

        if ($final_date)
            $this->cached_final_date = $final_date;
        else
            $final_date = $this->cached_final_date;

        $data['search_string_selected'] = $search_string;
        $data['orderby'] = $order;
        $data['order_type_selected'] = $order_type;
        $data['initial_date'] = $initial_date;
        $data['final_date'] = $final_date;
        $data['profit'] = $this->CashflowModel->get_profit($initial_date, $final_date);

        $search_data = array('search_string' => $search_string, 'orderby' => $order, 'order_type' => $order_type);
        $data['cashflows'] = $this->CashflowModel->get_cashflows($search_data);

        // load the view
        $data['main_content'] = 'cashflow/list';
        $this->load->view('includes/template', $data);
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // form validation
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('price', 'price', 'required|numeric');
            $this->form_validation->set_rules('description', 'description', '');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'valor' => $this->input->post('price'),
                    'tipo' => $this->input->post('type'),
                    'descricao' => $this->input->post('description'),
                    'cpf' => $this->input->post('cpf'),
                    'data_movimentacao' => $this->input->post('date')
                );

                $data['flash_message'] = $this->CashflowModel->store($data_to_store);
            }
        }

        // load the view
        $data['main_content'] = 'cashflow/add';
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
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('price', 'price', 'required|numeric');
            $this->form_validation->set_rules('description', 'description', '');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            if ($this->form_validation->run())
            {
                $data_to_store = array(
                    'valor' => $this->input->post('price'),
                    'tipo' => $this->input->post('type'),
                    'descricao' => $this->input->post('description'),
                    'cpf' => $this->input->post('cpf'),
                    'data_movimentacao' => $this->input->post('date')
                );

                $data['flash_message'] = $this->CashflowModel->update($id, $data_to_store);
            }
        }

        // if we are updating, and the data did not pass trough the validation
        // the code below wel reload the current data

        $data['cashflow'] = $this->CashflowModel->cashflow($id);
        $data['products'] = $this->CashflowModel->products($id);
        $data['main_content'] = 'cashflow/edit';
        $this->load->view('includes/template', $data);
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $this->CashflowModel->delete($id);
        redirect(site_url() . $this->uri->segment(1));
    }
}
