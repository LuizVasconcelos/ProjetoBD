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

    public function phones($id)
    {
		$this->db->select('*');
        $this->db->from('telefone_funcionario');
        $this->db->where('cpf', $id);
		$query = $this->db->get();
		return $query->result_array();
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

	public function get_phonecodes()
    {
        $this->db->select('*');
        $this->db->from('codigos_telefone');
        return $this->db->get()->result_array();
    }
	
    function store($data)
    {	
		$employee_data = array (
				'cpf' => $data['cpf'],
				'nome' => $data['nome'],
				'funcao' => $data['funcao'],
				'salario' => $data['salario'],
				'senha' => $data['senha']
		);
		
	    $ret = $this->db->insert('funcionario', $employee_data);
        if (!$ret)
            return false;

        $phone_data = array();
        foreach ($data['telefones'] as $phone)
            $phone_data[] = array(
				'cpf' => $data['cpf'],
				'codigo' => intval($phone[0]),
				'numero' => intval($phone[1])
            );
		
	    return $this->db->insert_batch('telefone_funcionario', $phone_data);
	}

    function update($id, $data)
    {
		$employee_data = array (
				'cpf' => $id,
				'nome' => $data['nome'],
				'funcao' => $data['funcao'],
				'salario' => $data['salario'],
				'senha' => $data['senha']
		);
		
		$this->db->where('cpf', $id);
		$this->db->update('funcionario', $employee_data);

        $this->db->where('cpf', $id);
        $this->db->delete('telefone_funcionario');
		
        $phone_data = array();
        foreach ($data['telefones'] as $phone)
            $phone_data[] = array(
				'cpf' => $data['cpf'],
				'codigo' => intval($phone[0]),
				'numero' => intval($phone[1])
            );
		
	    return $this->db->insert_batch('telefone_funcionario', $phone_data);
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
