<?php
class CashflowModel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function cashflow($id)
    {
		$this->db->select('*');
		$this->db->from('movimentacao');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array()[0];
    }

    public function get_cashflows($search_data)
    {
        $like = empty($search_data['search_string']) ? '' : $search_data['search_string'];
        $orderby = empty($search_data['orderby']) ? 'id' : $search_data['orderby'];
        $order_type = empty($search_data['order_type']) ? 'ASC' : $search_data['order_type'];
        $old = empty($search_data['start_date']) ? date('Y-m-d', mktime(0, 0, 0, 1, 1, 1)) : $search_data['start_date'];
        $now = empty($search_data['end_date']) ? date('Y-m-d') : $search_data['start_date'];

        $query = $this->db->query('CALL gerar_relatorio_movimentacao("' . $like . '", "' . $orderby . '", "' . $order_type . '", "' . $old . '", "' . $now . '")');
		return $query->result_array();
    }

    function get_profit($initial_date, $final_date)
    {
        $initial = DateTime::createFromFormat('d/m/Y', $initial_date)->format('Y-m-d');
        $final = DateTime::createFromFormat('d/m/Y', $final_date)->format('Y-m-d');
        $query = $this->db->query('select lucro("' . $initial . '", "' . $final . '")');

        // que hack feio da mulesta dos cachorro
        return $query->result_array()[0]['lucro("'.$initial.'", "'.$final.'")'];
    }

    function products($id)
    {
		$this->db->select('em.qtd as quantidade, pe.nome, pe.preco');
		$this->db->from('estoque_movimentacao em');
        $this->db->join('produto_estoque pe', 'pe.id = em.id_produto');
		$this->db->where('id_movimentacao', $id);
		$query = $this->db->get();
		return $query->result_array();
    }

    function store($data)
    {
		return $this->db->insert('movimentacao', $data);
	}

    function update($id, $data)
    {
		$this->db->where('id', $id);
        return $this->db->update('movimentacao', $data);
	}

	function delete($id)
    {
		$this->db->where('id', $id);
		$this->db->delete('movimentacao');
	}
}
?>
