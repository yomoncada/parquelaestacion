<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado_model extends CI_Model {

	var $table = 'empleados';
	var $column_order = array('cedula','nombre','cargo','turno',null);
	var $column_search = array('cedula','nombre','cargo','turno');
	var $order = array('id_emp' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_activos()
	{
		
		$this->db->select('emp.id_emp, emp.cedula, emp.nombre, car.cargo, emp.turno');
    	$this->db->from('empleados emp');
	    $this->db->join('cargos car','emp.cargo = car.id_car');
		$this->db->where('emp.estado','Activo');
		if($this->session->userdata('proceso') === "censo" || $this->session->userdata('proceso') === "censo_control" || $this->session->userdata('proceso') === "mantenimiento" || $this->session->userdata('proceso') === "mantenimiento_control" || $this->session->userdata('proceso') === "reforestacion" || $this->session->userdata('proceso') === "reforestacion_control" || $this->session->userdata('proceso') === "censo" || $this->session->userdata('proceso') === "servicio_control" || $this->session->userdata('proceso') === "servicio" || $this->session->userdata('proceso') === "servicio_control")
		{
			$this->db->where('disponibilidad','Desocupado');
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

	private function _get_datatables_query_inactivos()
	{
		
		$this->db->select('emp.id_emp, emp.cedula, emp.nombre, car.cargo, emp.turno');
    	$this->db->from('empleados emp');
	    $this->db->join('cargos car','emp.cargo = car.id_car');
		$this->db->where('emp.estado','Inactivo');

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

	public function get_by_id($id_emp)
	{
		$this->db->from('empleados');
		$this->db->where('id_emp',$id_emp);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function validate_by_cedula($cedula)
	{
		$this->db->from($this->table);
		$this->db->where('cedula',$cedula);
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

	public function activate_by_id($id_emp)
	{
		$this->db->set('estado','Activo');
	    $this->db->where('id_emp', $id_emp);
	    $this->db->update($this->table);
	}

	public function desactivate_by_id($id_emp)
	{
		$this->db->set('estado','Inactivo');
	    $this->db->where('id_emp', $id_emp);
	    $this->db->update($this->table);
	}
}
