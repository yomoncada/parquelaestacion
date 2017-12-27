<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio_model extends CI_Model {

	var $table = 'servicios';
	var $column_order = array('ser.id_ser', 'ser.fecha_act', 'usu.usuario', 'ser.fecha_asig', 'ser.hora_asig', 'ser.estado');
	var $column_search = array('ser.id_ser', 'ser.fecha_act', 'usu.usuario', 'ser.fecha_asig', 'ser.hora_asig', 'ser.estado');
	var $order = array('ser.id_ser' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_pendientes()
	{
		$this->db->select('ser.id_ser, ser.fecha_act, usu.usuario, ser.fecha_asig, ser.hora_asig, ser.estado');
    	$this->db->from('servicios ser');
	    $this->db->join('usuarios usu','ser.usuario = usu.id_usu');
	    $this->db->where('ser.estado','Pendiente');

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
		$this->db->select('ser.id_ser, ser.fecha_act, usu.usuario, ser.fecha_asig, ser.hora_asig, ser.estado');
    	$this->db->from('servicios ser');
	    $this->db->join('usuarios usu','ser.usuario = usu.id_usu');
	    $this->db->where('ser.estado','En Progreso');

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
		$this->db->select('ser.id_ser, ser.fecha_act, usu.usuario, ser.fecha_asig, ser.hora_asig, ser.estado');
    	$this->db->from('servicios ser');
	    $this->db->join('usuarios usu','ser.usuario = usu.id_usu');
	    $this->db->where('ser.estado','Finalizado');

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
		return $this->db->count_all_results('servicios');
	}

	public function get_all()
	{
      	$this->db->select('ser.id_ser, ser.fecha_act, usu.usuario, ser.fecha_asig, ser.hora_asig, ser.estado');
    	$this->db->from('servicios ser');
	    $this->db->join('usuarios usu','ser.usuario = usu.id_usu');
      	$this->db->order_by('ser.id_ser','DESC');
      	$query = $this->db->get();
      	return $query->result_array();
    }

    public function get_servicio($id_ser)
	{
    	$this->db->select('ser.id_ser, ser.fecha_act, usu.usuario, ser.fecha_asig, ser.hora_asig, ser.estado');
	    $this->db->from('servicios ser');
	    $this->db->join('usuarios usu','ser.usuario = usu.id_usu');
	    $this->db->where('ser.id_ser',$id_ser);
	    $query = $this->db->get();
	    return $query->row_array();
	}

	public function get_beneficiarios($id_ser)
	{
		$this->db->select('benser.beneficiario, ben.cedula, ben.nombre');
	    $this->db->from('beneficiarios_servicio benser');
	    $this->db->join('beneficiarios ben','benser.beneficiario = ben.id_ben');
	    $this->db->where('benser.servicio',$id_ser);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_cabanas($id_ser)
	{
		$this->db->select('cabser.cabana, cab.numero, cab.capacidad');
	    $this->db->from('cabanas_servicio cabser');
	    $this->db->join('cabanas cab','cabser.cabana = cab.id_cab');
	    $this->db->where('cabser.servicio',$id_ser);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_canchas($id_ser)
	{
		$this->db->select('canser.cancha, can.numero, can.capacidad');
	    $this->db->from('canchas_servicio canser');
	    $this->db->join('canchas can','canser.cancha = can.id_can');
	    $this->db->where('canser.servicio',$id_ser);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_empleados($id_ser)
	{
		$this->db->select('empser.empleado, emp.cedula, emp.nombre');
	    $this->db->from('empleados_servicio empser');
	    $this->db->join('empleados emp','empser.empleado = emp.id_emp');
	    $this->db->where('empser.servicio',$id_ser);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_implementos($id_ser)
	{
		$this->db->select('impser.implemento, imp.codigo, imp.nombre, impser.cantidad, impser.unidad');
	    $this->db->from('implementos_servicio impser');
	    $this->db->join('implementos imp','impser.implemento = imp.id_imp');
	    $this->db->where('impser.servicio',$id_ser);
	    $query = $this->db->get();
	    return $query->result();
		/*$this->db->from('implementos_servicio');
		$this->db->where('servicio',$id_ser);
		$query = $this->db->get();
		return $query->result();*/
	}

	public function get_invitados($id_ser)
	{
		$this->db->select('invser.empleado, inv.cedula, inv.nombre');
	    $this->db->from('empleados_servicio invser');
	    $this->db->join('empleados inv','invser.empleado = inv.id_emp');
	    $this->db->where('invser.servicio',$id_ser);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function set_beneficiarios($data=array())
  	{
    	$this->db->insert('beneficiarios_servicio', $data);
  	}

  	public function set_cabanas($data=array())
  	{
    	$this->db->insert('cabanas_servicio', $data);
  	}

  	public function set_canchas($data=array())
  	{
    	$this->db->insert('canchas_servicio', $data);
  	}

  	public function set_empleados($data=array())
  	{
    	$this->db->insert('empleados_servicio', $data);
  	}

  	public function set_implementos($data=array())
  	{
    	$this->db->insert('implementos_servicio', $data);
  	}

  	public function set_invitados($data=array())
  	{
    	$this->db->insert('invitados_servicio', $data);
  	}

  	public function get_implemento_by_id($id_imp)
  	{
    	$this->db->from('implementos');
    	$this->db->where('id_imp',$id_imp);
    	$query = $this->db->get();

    	return $query->row();
  	}
  	
  	public function discount_cabanas($id_cab)
  	{
   		$this->db->set('disponibilidad', 'Ocupada');
    	$this->db->where('id_cab', $id_cab);
    	$this->db->update('cabanas');
  	}

  	public function discount_canchas($id_can)
  	{
   		$this->db->set('disponibilidad', 'Ocupada');
    	$this->db->where('id_can', $id_can);
    	$this->db->update('canchas');
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

  	public function increment_cabanas($id_cab)
  	{
   		$this->db->set('disponibilidad', 'Desocupada');
    	$this->db->where('id_cab', $id_cab);
    	$this->db->update('cabanas');
  	}

  	public function increment_canchas($id_can)
  	{
   		$this->db->set('disponibilidad', 'Desocupada');
    	$this->db->where('id_can', $id_can);
    	$this->db->update('canchas');
  	}

  	public function increment_empleados($id_emp)
  	{
   		$this->db->set('disponibilidad', 'Desocupado');
    	$this->db->where('id_emp', $id_emp);
    	$this->db->update('empleados');
  	}

  	public function increment_implementos($id_imp, $stock)
  	{
   		$this->db->set('stock', $stock);
    	$this->db->where('id_imp', $id_imp);
    	$this->db->update('implementos');
  	}

  	public function update($where, $servicio)
	{
		$this->db->update($this->table, $servicio, $where);
		return $this->db->affected_rows();
	}

  	public function delete_beneficiarios($id_ser)
  	{
    	$this->db->where('servicio', $id_ser);
	    $this->db->delete('beneficiarios_servicio');
  	}

  	public function delete_cabanas($id_ser)
  	{
    	$this->db->where('servicio', $id_ser);
	    $this->db->delete('cabanas_servicio');
  	}

  	public function delete_canchas($id_ser)
  	{
    	$this->db->where('servicio', $id_ser);
	    $this->db->delete('canchas_servicio');
  	}

	public function delete_empleados($id_ser)
  	{
    	$this->db->where('servicio', $id_ser);
	    $this->db->delete('empleados_servicio');
  	}

  	public function delete_implementos($id_ser)
  	{
	    $this->db->where('servicio', $id_ser);
	    $this->db->delete('implementos_servicio');
  	}

  	public function delete_invitados($id_ser)
  	{
	    $this->db->where('servicio', $id_ser);
	    $this->db->delete('invitados_servicio');
  	}
}
