<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora_model extends CI_Model {

  var $table = 'bitacoras';
  var $column_order = array('bit.id_bit, bit.tipo, bit.movimiento, usu.usuario, bit.tiempo');
  var $column_search = array('bit.id_bit, bit.tipo, bit.movimiento, usu.usuario, bit.tiempo');
  var $order = array('tiempo' => 'desc');

  private function _get_datatables_query()
  {
    $this->db->select('bit.id_bit, bit.tipo, bit.movimiento, usu.usuario, bit.tiempo');
    $this->db->from('bitacoras bit');
    $this->db->join('usuarios usu','bit.usuario = usu.id_usu');

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

  public function set($bitacora=array())
  {
    $this->db->insert('bitacoras', $bitacora);
    return true;
  }

  public function truncate_bitacoras()
  {
    $this->db->from($this->table);
    $this->db->truncate();
  }
}
