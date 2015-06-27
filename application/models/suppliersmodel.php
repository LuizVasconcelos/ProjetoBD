<?php

class SuppliersModel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function supplier($id)
    {
		$this->db->select('*');
		$this->db->from('fornecedor');
		$this->db->where('cnpj', $id);
		$query = $this->db->get();
	    return $query->result_array()[0];
    }

    public function phones($id)
    {
		$this->db->select('*');
		$this->db->from('telefone_fornecedor');
		$this->db->where('cnpj', $id);
		$query = $this->db->get();
        return $query->result_array();
    }

    public function get_suppliers($search_data = array())
    {
        $like = empty($search_data['search_string']) ? '' : $search_data['search_string'];
        $orderby = empty($search_data['orderby']) ? 'nome' : $search_data['orderby'];
        $order_type = empty($search_data['order_type']) ? 'ASC' : $search_data['order_type'];

        $query = $this->db->query('CALL gerar_relatorio_fornecedor("' . $like . '", "' . $orderby . '", "' . $order_type . '")');
		return $query->result_array();
    }

	public function get_phonecodes()
    {
        $this->db->select('*');
        $this->db->from('codigos_telefone');
        return $this->db->get()->result_array();
    }
	
    function store($data)
    {
		$supplier_data = array(
				'cnpj' => $data['cnpj'],
				'nome' => $data['nome']
		);
	
		$ret = $this->db->insert('fornecedor', $supplier_data);
        if (!$ret)
            return false;
		
        $phone_data = array();
        foreach ($data['telefones'] as $phone)
            $phone_data[] = array(
				'cnpj' => $data['cnpj'],
				'codigo' => intval($phone[0]),
				'numero' => intval($phone[1])
            );
		
	    return $this->db->insert_batch('telefone_fornecedor', $phone_data);
	}

    function update($id, $data)
    {
		$supplier_data = array(
				'cnpj' => $id,
				'nome' => $data['nome']
		);
	
		$this->db->where('cnpj', $id);
        $ret = $this->db->update('fornecedor', $supplier_data);
        if (!$ret)
            return false;
	    
        $this->db->where('cnpj', $id);
        $this->db->delete('telefone_fornecedor');

        $phone_data = array();
        foreach ($data['telefones'] as $phone)
            $phone_data[] = array(
				'cnpj' => $data['cnpj'],
				'codigo' => intval($phone[0]),
				'numero' => intval($phone[1])
            );
		
	    return $this->db->insert_batch('telefone_fornecedor', $phone_data);
	}

    function delete($id)
    {
        $this->db->select('*');
        $this->db->from('fornecedor_produto');
        $this->db->where('cnpj', $id);
        $query = $this->db->get();

        if (sizeof($query->result_array()) > 0)
        {
            throw new Exception("Não é possível deletar o fornecedor porque ele possui produtos cadastrados.");
            return false;
        }
        else
        {
            $this->db->where('cnpj', $id);
            $this->db->delete('telefone_fornecedor');

            $this->db->where('cnpj', $id);
            $this->db->delete('fornecedor');
        }
	}
}
?>
