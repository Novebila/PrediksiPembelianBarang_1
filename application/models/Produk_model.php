<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    public function get_all_produk($sort = 'asc')
    {
        $this->db->order_by('id_produk', $sort);
        return $this->db->get('produk');
    }

    public function get_produk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        return $this->db->get('produk');
    }

    public function add_produk($params)
    {
        return $this->db->insert('produk', $params);
    }

    public function update_produk($id_produk, $params)
    {
        $this->db->where('id_produk', $id_produk);
        return $this->db->update('produk', $params);
    }

    public function delete_produk($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        return $this->db->delete('produk');
    }
}

/* End of file Produk_model.php */
/* Location: ./application/models/Produk_model.php */
