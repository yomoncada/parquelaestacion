<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {
	
	var $table = 'usuarios';
	var $column_order = array('usuario','nivel',null);
	var $column_search = array('usuario','nivel');
	var $order = array('id_usu' => 'desc');


	public function __construct() {
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$this->db->where('estado','Activo');

		$i = 0;

		foreach ($this->column_search as $item)
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
				}
				$i++;
			}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get($usuario,$contrasena)
	{
		$this->db->where('usuario',$usuario);
		$this->db->where('contrasena',$contrasena);
		$query = $this->db->get('usuarios');
		return $query->row();
	}

	public function get_by_id($id_usu)
	{
		$this->db->from('usuarios');
		$this->db->where('id_usu',$id_usu);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_by_usuario($usuario)
	{
		$this->db->from('usuarios');
		$this->db->where('usuario',$usuario);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function validate($usuario,$contrasena)
	{
		$this->db->where('usuario',$usuario);
		$this->db->where('contrasena',$contrasena);
		$query = $this->db->get('usuarios');
		return $query->num_rows();
	}

	public function validate_by_usuario($usuario)
	{
		$this->db->from($this->table);
		$this->db->where('usuario',$usuario);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function validate_by_contrasena($contrasena)
	{
		$this->db->from($this->table);
		$this->db->where('contrasena',$contrasena);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function recover_password($usuario, $pregunta, $respuesta)
	{
		$this->db->from($this->table);
		$this->db->where('usuario',$usuario);
		$this->db->where('pregunta',$pregunta);
		$this->db->where('respuesta',$respuesta);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function set_temporal_password($usuario,$contrasena)
	{
		$this->db->set('contrasena',$contrasena);
		$this->db->where('usuario',$usuario);
		$this->db->update($this->table);
	}

	public function set_avatar($id_usu, $avatar)
	{
		$this->db->set('avatar', $avatar);
	    $this->db->where('id_usu', $id_usu);
	    $this->db->update($this->table);
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id_usu)
	{
		$this->db->set('estado','Inactivo');
	    $this->db->where('id_usu', $id_usu);
	    $this->db->update($this->table);
	}
}