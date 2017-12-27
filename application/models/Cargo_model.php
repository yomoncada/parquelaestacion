<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo_model extends CI_Model {

	var $table = 'cargos';
	var $column_order = array('cargo','descripcion',null);
	var $column_search = array('cargo','descripcion');
	var $order = array('cargo' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_activos()
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

	private function _get_datatables_query_inactivos()
	{
		
		$this->db->from($this->table);
		$this->db->where('estado','Inactivo');

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

	function get_datatables_activos()
	{
		$this->_get_datatables_query_activos();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_inactivos()
	{
		$this->_get_datatables_query_inactivos();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_all()
	{
		$this->db->where('estado','Activo');
		$this->db->order_by('cargo','asc');
		$query = $this->db->get('cargos');
      	return $query->result_array();
	}

	function count_filtered_activos()
	{
		$this->_get_datatables_query_activos();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_inactivos()
	{
		$this->_get_datatables_query_inactivos();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id_car)
	{
		$this->db->from('cargos');
		$this->db->where('id_car',$id_car);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function validate_by_nombre($cargo)
	{
		$this->db->from($this->table);
		$this->db->where('cargo',$cargo);
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

	public function activate_by_id($id_car)
	{
		$this->db->set('estado','Activo');
	    $this->db->where('id_car', $id_car);
	    $this->db->update($this->table);
	}

	public function desactivate_by_id($id_car)
	{
		$this->db->set('estado','Inactivo');
	    $this->db->where('id_car', $id_car);
	    $this->db->update($this->table);
	}
}
