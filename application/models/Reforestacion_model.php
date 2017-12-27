<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reforestacion_model extends CI_Model {

	var $table = 'reforestaciones';
	var $column_order = array('ref.id_ref', 'ref.fecha_act', 'usu.usuario', 'ref.fecha_asig', 'ref.hora_asig', 'ref.estado');
	var $column_search = array('ref.id_ref', 'ref.fecha_act', 'usu.usuario', 'ref.fecha_asig', 'ref.hora_asig', 'ref.estado');
	var $order = array('ref.id_ref' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_pendientes()
	{
		$this->db->select('ref.id_ref, ref.fecha_act, usu.usuario, ref.fecha_asig, ref.hora_asig, ref.estado');
    	$this->db->from('reforestaciones ref');
	    $this->db->join('usuarios usu','ref.usuario = usu.id_usu');
	    $this->db->where('ref.estado','Pendiente');

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

	private function _get_datatables_query_en_progresos()
	{
		$this->db->select('ref.id_ref, ref.fecha_act, usu.usuario, ref.fecha_asig, ref.hora_asig, ref.estado');
    	$this->db->from('reforestaciones ref');
	    $this->db->join('usuarios usu','ref.usuario = usu.id_usu');
	    $this->db->where('ref.estado','En Progreso');

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

	private function _get_datatables_query_finalizados()
	{
		$this->db->select('ref.id_ref, ref.fecha_act, usu.usuario, ref.fecha_asig, ref.hora_asig, ref.estado');
    	$this->db->from('reforestaciones ref');
	    $this->db->join('usuarios usu','ref.usuario = usu.id_usu');
	    $this->db->where('ref.estado','Finalizado');

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

	function get_datatables_pendientes()
	{
		$this->_get_datatables_query_pendientes();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_en_progresos()
	{
		$this->_get_datatables_query_en_progresos();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_finalizados()
	{
		$this->_get_datatables_query_finalizados();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_pendientes()
	{
		$this->_get_datatables_query_pendientes();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_en_progresos()
	{
		$this->_get_datatables_query_en_progresos();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_finalizados()
	{
		$this->_get_datatables_query_finalizados();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_numero()
	{
		return $this->db->count_all_results('reforestaciones');
	}

	public function get_all()
	{
      	$this->db->select('ref.id_ref, ref.fecha_act, usu.usuario, ref.fecha_asig, ref.hora_asig, ref.estado');
    	$this->db->from('reforestaciones ref');
	    $this->db->join('usuarios usu','ref.usuario = usu.id_usu');
      	$this->db->order_by('ref.id_ref','DESC');
      	$query = $this->db->get();
      	return $query->result_array();
    }

    public function get_reforestacion($id_ref)
	{
    	$this->db->select('ref.id_ref, ref.fecha_act, usu.usuario, ref.fecha_asig, ref.hora_asig, ref.estado');
	    $this->db->from('reforestaciones ref');
	    $this->db->join('usuarios usu','ref.usuario = usu.id_usu');
	    $this->db->where('ref.id_ref',$id_ref);
	    $query = $this->db->get();
	    return $query->row_array();
	}

	public function get_empleados($id_ref)
	{
		$this->db->select('empref.empleado, emp.cedula, emp.nombre');
	    $this->db->from('empleados_reforestacion empref');
	    $this->db->join('empleados emp','empref.empleado = emp.id_emp');
	    $this->db->where('empref.reforestacion',$id_ref);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_areas($id_ref)
	{
		$this->db->select('areref.id_are, are.codigo, are.area');
	    $this->db->from('areas_reforestacion areref');
	    $this->db->join('areas are','areref.id_are = are.id_are');
	    $this->db->where('areref.reforestacion',$id_ref);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_especies($id_ref)
	{
		$this->db->select('espref.especie, espref.poblacion, esp.codigo, esp.nom_cmn');
	    $this->db->from('especies_reforestacion espref');
	    $this->db->join('especies esp','espref.especie = esp.id_esp');
	    $this->db->where('espref.reforestacion',$id_ref);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_implementos($id_ref)
	{
		$this->db->select('impref.implemento, imp.codigo, imp.nombre, impref.cantidad, impref.unidad');
	    $this->db->from('implementos_reforestacion impref');
	    $this->db->join('implementos imp','impref.implemento = imp.id_imp');
	    $this->db->where('impref.reforestacion',$id_ref);
	    $query = $this->db->get();
	    return $query->result();
		/*$this->db->from('implementos_reforestacion');
		$this->db->where('reforestacion',$id_ref);
		$query = $this->db->get();
		return $query->result();*/
	}

	public function get_actividades($id_ref)
	{
		$this->db->select('actref.actividad, act.accion, actref.encargado');
	    $this->db->from('actividades_reforestacion actref');
	    $this->db->join('actividades act','actref.actividad = act.id_act');
	    $this->db->where('actref.reforestacion',$id_ref);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function set_empleados($data=array())
  	{
    	$this->db->insert('empleados_reforestacion', $data);
  	}

  	public function set_areas($data=array())
  	{
    	$this->db->insert('areas_reforestacion', $data);
  	}

  	public function set_especies($data=array())
  	{
    	$this->db->insert('especies_reforestacion', $data);
  	}

  	public function set_implementos($data=array())
  	{
    	$this->db->insert('implementos_reforestacion', $data);
  	}

  	public function set_actividades($data=array())
  	{
    	$this->db->insert('actividades_reforestacion', $data);
  	}

  	public function get_implemento_by_id($id_imp)
  	{
    	$this->db->from('implementos');
    	$this->db->where('id_imp',$id_imp);
    	$query = $this->db->get();

    	return $query->row();
  	}

  	public function discount_empleados($id_emp)
  	{
   		$this->db->set('disponibilidad', 'Ocupado');
    	$this->db->where('id_emp', $id_emp);
    	$this->db->update('empleados');
  	}

  	public function discount_implementos($id_imp, $stock)
  	{
   		$this->db->set('stock', $stock);
    	$this->db->where('id_imp', $id_imp);
    	$this->db->update('implementos');
  	}

  	public function increment_empleados($id_emp)
  	{
   		$this->db->set('disponibilidad', 'Desocupado');
    	$this->db->where('id_emp', $id_emp);
    	$this->db->update('empleados');
  	}

  	public function increment_especies_censadas($id_esp, $cantidad)
  	{
   		$this->db->set('poblacion', $cantidad);
    	$this->db->where('id_esp', $id_esp);
    	$this->db->update('especies');
  	}

  	public function increment_implementos($id_imp, $stock)
  	{
   		$this->db->set('stock', $stock);
    	$this->db->where('id_imp', $id_imp);
    	$this->db->update('implementos');
  	}

  	public function update($where, $reforestacion)
	{
		$this->db->update($this->table, $reforestacion, $where);
		return $this->db->affected_rows();
	}

  	public function delete_empleados($id_ref)
  	{
    	$this->db->where('reforestacion', $id_ref);
	    $this->db->delete('empleados_reforestacion');
  	}

  	public function delete_areas($id_ref)
  	{
    	$this->db->where('reforestacion', $id_ref);
	    $this->db->delete('areas_reforestacion');
  	}

  	public function delete_especies($id_ref)
  	{
    	$this->db->where('reforestacion', $id_ref);
	    $this->db->delete('especies_reforestacion');
  	}

  	public function delete_implementos($id_ref)
  	{
	    $this->db->where('reforestacion', $id_ref);
	    $this->db->delete('implementos_reforestacion');
  	}

  	public function delete_actividades($id_ref)
  	{
    	$this->db->where('reforestacion', $id_ref);
	    $this->db->delete('actividades_reforestacion');
  	}
}
