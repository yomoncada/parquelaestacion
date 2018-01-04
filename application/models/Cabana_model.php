<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabana_model extends CI_Model {

	var $table = 'cabanas';
	var $column_order = array('cab.numero','are.area','cab.capacidad','cab.disponibilidad',null);
	var $column_search = array('cab.numero','are.area','cab.capacidad','cab.disponibilidad');
	var $order = array('numero' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_activas()
	{
		$this->db->select('cab.id_cab, cab.numero, are.area, cab.capacidad, cab.estado');
    	$this->db->from('cabanas cab');
	    $this->db->join('areas are','cab.area = are.id_are');
		$this->db->where('cab.estado','Activa');
		if($this->session->userdata('proceso') === "servicio" || $this->session->userdata('proceso') === "servicio_control")
		{
			$this->db->where('disponibilidad','Desocupada');
		}

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

	private function _get_datatables_query_inactivas()
	{
		$this->db->select('cab.id_cab, cab.numero, are.area, cab.capacidad, cab.estado');
    	$this->db->from('cabanas cab');
	    $this->db->join('areas are','cab.area = are.id_are');
		$this->db->where('cab.estado','Inactiva');

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

	function get_datatables_activas()
	{
		$this->_get_datatables_query_activas();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_inactivas()
	{
		$this->_get_datatables_query_inactivas();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_activas()
	{
		$this->_get_datatables_query_activas();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_inactivas()
	{
		$this->_get_datatables_query_inactivas();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id_cab)
	{
		$this->db->from('cabanas');
		$this->db->where('id_cab',$id_cab);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function validate_by_numero($numero)
	{
		$this->db->from($this->table);
		$this->db->where('numero',$numero);
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

	public function activate_by_id($id_cab)
	{
		$this->db->set('estado','Activa');
	    $this->db->where('id_cab', $id_cab);
	    $this->db->update($this->table);
	}

	public function desactivate_by_id($id_cab)
	{
		$this->db->set('estado','Inactiva');
	    $this->db->where('id_cab', $id_cab);
	    $this->db->update($this->table);
	}
}
