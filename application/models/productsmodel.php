<?php
class ProductsModel extends CI_Model {
 
    public function __construct()
    {
        $this->load->database();
    }

    public function get_product_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

    public function get_products($search_data)
    {
        $like = empty($search_data['search_string']) ? '' : $search_data['search_string'];
        $orderby = empty($search_data['orderby']) ? 'nome' : $search_data['orderby'];
        $order_type = empty($search_data['order_type']) ? 'ASC' : $search_data['order_type'];

        $query = $this->db->query('CALL gerar_relatorio_estoque("' . $like . '", "' . $orderby . '", "' . $order_type . '")');
		return $query->result_array(); 	
    }

    function store($data)
    {
		$insert = $this->db->insert('produto_estoque', $data);
	    return $insert;
	}

    function update($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('products', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('produto_estoque'); 
	}
}
?>	
