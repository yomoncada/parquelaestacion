<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Implemento_model extends CI_Model {

	var $table = 'implementos';
	var $column_order = array('imp.codigo','imp.nombre','cat.categoria','imp.stock','imp.stock_min','imp.stock_max','imp.unidad',null);
	var $column_search = array('imp.codigo','imp.nombre','cat.categoria','imp.stock','imp.stock_min','imp.stock_max','imp.unidad');
	var $order = array('id_imp' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_activos()
	{
		$this->db->select('imp.id_imp, imp.codigo, imp.nombre, cat.categoria, imp.stock, imp.stock_min, imp.stock_max, imp.unidad, imp.estado');
    	$this->db->from('implementos imp');
	    $this->db->join('categorias cat','imp.categoria = cat.id_cat');
		$this->db->where('imp.estado','Activo');
		if($this->session->userdata('proceso') === "servicio" || $this->session->userdata('proceso') === "servicio_control")
		{
			$this->db->where('cat.categoria','Decoración');
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
		$this->db->select('imp.id_imp, imp.codigo, imp.nombre, cat.categoria, imp.stock, imp.stock_min, imp.stock_max, imp.unidad, imp.estado');
    	$this->db->from('implementos imp');
	    $this->db->join('categorias cat','imp.categoria = cat.id_cat');
		$this->db->where('imp.estado','Inactivo');
		if($this->session->userdata('proceso') === "servicio" || $this->session->userdata('proceso') === "servicio_control")
		{
			$this->db->where('cat.categoria','Decoración');
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

	public function get_by_id($id_imp)
	{
		$this->db->from('implementos');
		$this->db->where('id_imp',$id_imp);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function validate_by_codigo($codigo)
	{
		$this->db->from($this->table);
		$this->db->where('codigo',$codigo);
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

	public function activate_by_id($id_imp)
	{
		$this->db->set('estado','Activo');
	    $this->db->where('id_imp', $id_imp);
	    $this->db->update($this->table);
	}

	public function desactivate_by_id($id_imp)
	{
		$this->db->set('estado','Inactivo');
	    $this->db->where('id_imp', $id_imp);
	    $this->db->update($this->table);
	}
}
