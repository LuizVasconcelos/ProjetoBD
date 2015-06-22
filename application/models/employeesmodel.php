<?php
class EmployeesModel extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    public function employee($id)
    {
        $this->db->select('*');
        $this->db->from('funcionario');
        $this->db->where('cpf', $id);
        $query = $this->db->get();
        return $query->result_array()[0];
    }

    public function get_employees($search_data = array())
    {
        $like = empty($search_data['search_string']) ? '' : $search_data['search_string'];
        $orderby = empty($search_data['orderby']) ? 'nome' : $search_data['orderby'];
        $order_type = empty($search_data['order_type']) ? 'ASC' : $search_data['order_type'];

        $query = $this->db->query('CALL gerar_relatorio_funcionario("' . $like . '", "' . $orderby . '", "' . $order_type . '")');
        return $query->result_array();
    }

    public function get_functions()
    {
        $this->db->select('*');
        $this->db->from('funcao');
        return $this->db->get()->result_array();
    }

    function store($data)
    {
	    return $this->db->insert('funcionario', $data);
	}

    function update($id, $data)
    {
		$this->db->where('cpf', $id);
		return $this->db->update('funcionario', $data);
	}

	function delete($id)
    {
        $this->db->select('*');
        $this->db->from('movimentacao');
        $this->db->where('cpf', $id);
        $query = $this->db->get();

        if (sizeof($query->result_array()) > 0)
        {
            throw new Exception("Não é possível deletar funcionário porque ele possui movimentações associadas.");
            return false;
        }
        else
        {
            $this->db->where('cpf', $id);
            $this->db->delete('telefone_funcionario');

            $this->db->where('cpf', $id);
            $this->db->delete('funcionario');
        }
	}
}
?>
