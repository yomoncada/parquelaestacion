<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donacion_model extends CI_Model {

	var $table = 'donaciones';
	var $column_order = array('dnc.id_dnc', 'dnc.fecha_act', 'usu.usuario', 'dnc.estado');
	var $column_search = array('dnc.id_dnc', 'dnc.fecha_act', 'usu.usuario', 'dnc.estado');
	var $order = array('dnc.id_dnc' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select('dnc.id_dnc, dnc.fecha_act, usu.usuario, dnc.observacion, dnc.estado');
    	$this->db->from('donaciones dnc');
	    $this->db->join('usuarios usu','dnc.usuario = usu.id_usu');

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
		return $this->db->count_all_results('donaciones');
	}

	public function get_all()
	{
      	$this->db->select('dnc.id_dnc, dnc.fecha_act, usu.usuario, dnc.observacion, dnc.estado');
    	$this->db->from('donaciones dnc');
	    $this->db->join('usuarios usu','dnc.usuario = usu.id_usu');
      	$this->db->order_by('dnc.id_dnc','DESC');
      	$query = $this->db->get();
      	return $query->result_array();
    }

    public function get_donacion($id_dnc)
	{
    	$this->db->select('dnc.id_dnc, dnc.fecha_act, usu.usuario, dnc.observacion, dnc.estado');
	    $this->db->from('donaciones dnc');
	    $this->db->join('usuarios usu','dnc.usuario = usu.id_usu');
	    $this->db->where('dnc.id_dnc',$id_dnc);
	    $query = $this->db->get();
	    return $query->row_array();
	}

	public function get_donantes($id_dnc)
	{
		$this->db->select('dondnc.donante, don.rif, don.razon_social');
	    $this->db->from('donantes_donacion dondnc');
	    $this->db->join('donantes don','dondnc.donante = don.id_don');
	    $this->db->where('dondnc.donacion',$id_dnc);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_implementos($id_dnc)
	{
		$this->db->select('impdnc.implemento, imp.codigo, imp.nombre, impdnc.cantidad, impdnc.unidad');
	    $this->db->from('implementos_donacion impdnc');
	    $this->db->join('implementos imp','impdnc.implemento = imp.id_imp');
	    $this->db->where('impdnc.donacion',$id_dnc);
	    $query = $this->db->get();
	    return $query->result();
		/*$this->db->from('implementos_donacion');
		$this->db->where('donacion',$id_dnc);
		$query = $this->db->get();
		return $query->result();*/
	}

	public function get_fondos($id_dnc)
	{
		$this->db->select('cantidad, divisa');
	    $this->db->from('fondos_donacion');
	    $this->db->where('donacion',$id_dnc);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function set_donantes($data=array())
  	{
    	$this->db->insert('donantes_donacion', $data);
  	}

  	public function set_implementos($data=array())
  	{
    	$this->db->insert('implementos_donacion', $data);
  	}

  	public function set_fondos($data=array())
  	{
    	$this->db->insert('fondos_donacion', $data);
  	}

  	public function get_implemento_by_id($id_imp)
  	{
    	$this->db->from('implementos');
    	$this->db->where('id_imp',$id_imp);
    	$query = $this->db->get();

    	return $query->row();
  	}

  	public function increment_implementos($id_imp, $stock)
  	{
   		$this->db->set('stock', $stock);
    	$this->db->where('id_imp', $id_imp);
    	$this->db->update('implementos');
  	}

  	public function update($where, $donacion)
	{
		$this->db->update($this->table, $donacion, $where);
		return $this->db->affected_rows();
	}

  	public function delete_donantes($id_dnc)
  	{
    	$this->db->where('donacion', $id_dnc);
	    $this->db->delete('donantes_donacion');
  	}

  	public function delete_implementos($id_dnc)
  	{
	    $this->db->where('donacion', $id_dnc);
	    $this->db->delete('implementos_donacion');
  	}

  	public function delete_fondos($id_dnc)
  	{
    	$this->db->where('donacion', $id_dnc);
	    $this->db->delete('fondos_donacion');
  	}
}
