<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantenimiento_model extends CI_Model {

	var $table = 'mantenimientos';
	var $column_order = array('man.id_man', 'man.fecha_act', 'usu.usuario', 'man.fecha_asig', 'man.hora_asig', 'man.estado');
	var $column_search = array('man.id_man', 'man.fecha_act', 'usu.usuario', 'man.fecha_asig', 'man.hora_asig', 'man.estado');
	var $order = array('man.id_man' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select('man.id_man, man.fecha_act, usu.usuario, man.fecha_asig, man.hora_asig, man.estado');
    	$this->db->from('mantenimientos man');
	    $this->db->join('usuarios usu','man.usuario = usu.id_usu');

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

	public function get_numero()
	{
		return $this->db->count_all_results('mantenimientos');
	}

	public function get_all()
	{
      	$this->db->select('man.id_man, man.fecha_act, usu.usuario, man.fecha_asig, man.hora_asig, man.estado');
    	$this->db->from('mantenimientos man');
	    $this->db->join('usuarios usu','man.usuario = usu.id_usu');
      	$this->db->order_by('man.id_man','DESC');
      	$query = $this->db->get();
      	return $query->result_array();
    }

    public function get_mantenimiento($id_man)
	{
    	$this->db->select('man.id_man, man.fecha_act, usu.usuario, man.fecha_asig, man.hora_asig, man.estado');
	    $this->db->from('mantenimientos man');
	    $this->db->join('usuarios usu','man.usuario = usu.id_usu');
	    $this->db->where('man.id_man',$id_man);
	    $query = $this->db->get();
	    return $query->row_array();
	}

	public function get_empleados($id_man)
	{
		$this->db->select('empman.empleado, emp.cedula, emp.nombre');
	    $this->db->from('empleados_mantenimiento empman');
	    $this->db->join('empleados emp','empman.empleado = emp.id_emp');
	    $this->db->where('empman.mantenimiento',$id_man);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_areas($id_man)
	{
		$this->db->select('areman.id_are, are.codigo, are.area');
	    $this->db->from('areas_mantenimiento areman');
	    $this->db->join('areas are','areman.id_are = are.id_are');
	    $this->db->where('areman.mantenimiento',$id_man);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_edificios($id_man)
	{
		$this->db->select('ediman.edificio, edi.numero, edi.nombre');
	    $this->db->from('edificios_mantenimiento ediman');
	    $this->db->join('edificios edi','ediman.edificio = edi.id_edi');
	    $this->db->where('ediman.mantenimiento',$id_man);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_implementos($id_man)
	{
		$this->db->select('impman.implemento, imp.codigo, imp.nombre, impman.cantidad, impman.unidad');
	    $this->db->from('implementos_mantenimiento impman');
	    $this->db->join('implementos imp','impman.implemento = imp.id_imp');
	    $this->db->where('impman.mantenimiento',$id_man);
	    $query = $this->db->get();
	    return $query->result();
		/*$this->db->from('implementos_mantenimiento');
		$this->db->where('mantenimiento',$id_man);
		$query = $this->db->get();
		return $query->result();*/
	}

	public function get_actividades($id_man)
	{
		$this->db->select('actman.actividad, act.accion, actman.encargado');
	    $this->db->from('actividades_mantenimiento actman');
	    $this->db->join('actividades act','actman.actividad = act.id_act');
	    $this->db->where('actman.mantenimiento',$id_man);
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
    	$this->db->insert('empleados_mantenimiento', $data);
  	}

  	public function set_areas($data=array())
  	{
    	$this->db->insert('areas_mantenimiento', $data);
  	}

  	public function set_edificios($data=array())
  	{
    	$this->db->insert('edificios_mantenimiento', $data);
  	}

  	public function set_implementos($data=array())
  	{
    	$this->db->insert('implementos_mantenimiento', $data);
  	}

  	public function set_actividades($data=array())
  	{
    	$this->db->insert('actividades_mantenimiento', $data);
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

  	public function update($where, $mantenimiento)
	{
		$this->db->update($this->table, $mantenimiento, $where);
		return $this->db->affected_rows();
	}

  	public function delete_empleados($id_man)
  	{
    	$this->db->where('mantenimiento', $id_man);
	    $this->db->delete('empleados_mantenimiento');
  	}

  	public function delete_areas($id_man)
  	{
    	$this->db->where('mantenimiento', $id_man);
	    $this->db->delete('areas_mantenimiento');
  	}

  	public function delete_edificios($id_man)
  	{
    	$this->db->where('mantenimiento', $id_man);
	    $this->db->delete('edificios_mantenimiento');
  	}

  	public function delete_implementos($id_man)
  	{
	    $this->db->where('mantenimiento', $id_man);
	    $this->db->delete('implementos_mantenimiento');
  	}

  	public function delete_actividades($id_man)
  	{
    	$this->db->where('mantenimiento', $id_man);
	    $this->db->delete('actividades_mantenimiento');
  	}
}
