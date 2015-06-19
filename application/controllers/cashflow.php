<?php

class Cashflow extends CI_Controller {

    var $cached_search_string = '';
    var $cached_order = 'id';
    var $cached_order_type = 'ASC';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CashflowModel');

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
        $data['orderby'] = $cached_order;
        $data['order_type_selected'] = $cached_order_type;

        $search_data = array('search_string' => $search_string, 'orderby' => $order, 'order_type' => $order_type);
        $data['products'] = $this->CashflowModel->get_cashflow($search_data);

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
            $this->form_validation->set_rules('description', 'description', 'required');
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
        //product id 
        $id = $this->uri->segment(4);
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('stock', 'stock', 'required|numeric');
            $this->form_validation->set_rules('cost_price', 'cost_price', 'required|numeric');
            $this->form_validation->set_rules('sell_price', 'sell_price', 'required|numeric');
            $this->form_validation->set_rules('manufacture_id', 'manufacture_id', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'description' => $this->input->post('description'),
                    'stock' => $this->input->post('stock'),
                    'cost_price' => $this->input->post('cost_price'),
                    'sell_price' => $this->input->post('sell_price'),          
                    'manufacture_id' => $this->input->post('manufacture_id')
                );
                //if the insert has returned true then we show the flash message
                if($this->products_model->update_product($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/products/update/'.$id.'');

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
        $this->CashflowModel->delete($id);
        redirect(site_url() . $this->uri->segment(1));
    }
}
