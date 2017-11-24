<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Implemento_model extends CI_Model {

	var $table = 'implementos';
	var $column_order = array('imp.codigo','imp.nombre','cat.categoria','imp.stock','imp.unidad',null);
	var $column_search = array('imp.codigo','imp.nombre','cat.categoria','imp.stock','imp.unidad');
	var $order = array('id_imp' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select('imp.id_imp, imp.codigo, imp.nombre, cat.categoria, imp.stock, imp.unidad, imp.estado');
    	$this->db->from('implementos imp');
	    $this->db->join('categorias cat','imp.categoria = cat.id_cat');
		$this->db->where('imp.estado','Activo');
		if($this->session->userdata('proceso') === "censo" || $this->session->userdata('proceso') === "censo_control" || $this->session->userdata('proceso') === "mantenimiento" || $this->session->userdata('proceso') === "mantenimiento_control" || $this->session->userdata('proceso') === "reforestacion" || $this->session->userdata('proceso') === "reforestacion_control")
		{
			$this->db->where('imp.stock >',0);
		}
		if($this->session->userdata('proceso') === "servicio" || $this->session->userdata('proceso') === "servicio_control")
		{
			$this->db->where('cat.categoria','Decoración');
			$this->db->where('imp.stock >',0);
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

	public function delete_by_id($id_imp)
	{
		$this->db->set('estado','Inactivo');
	    $this->db->where('id_imp', $id_imp);
	    $this->db->update($this->table);
	}
}
