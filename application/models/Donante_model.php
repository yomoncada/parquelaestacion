<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donante_model extends CI_Model {

	var $table = 'donantes';
	var $column_order = array('rif','razon_social', 'telefono', 'direccion',null);
	var $column_search = array('rif','razon_social', 'telefono', 'direccion');
	var $order = array('id_don' => 'asc');

	public function __construct()
	{
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

	public function get_by_id($id_don)
	{
		$this->db->from('donantes');
		$this->db->where('id_don',$id_don);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function validate_by_rif($rif)
	{
		$this->db->from($this->table);
		$this->db->where('rif',$rif);
		$query = $this->db->get();
		return $query->num_rows();
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

	public function delete_by_id($id_don)
	{
		$this->db->set('estado','Inactivo');
	    $this->db->where('id_don', $id_don);
	    $this->db->update($this->table);
	}
}
