<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Hasil_model extends CI_Model
{

    public function get_all_hasil($sort = 'asc')
    {
        $this->db->order_by('id_hasil', $sort);
        $this->db->join('produk', 'produk.id_produk=hasil.id_produk', 'left');
        return $this->db->get('hasil');
    }

    public function get_hasil($id_hasil)
    {
        $this->db->where('id_hasil', $id_hasil);
        $this->db->join('produk', 'produk.id_produk=hasil.id_produk', 'left');
        return $this->db->get('hasil');
    }

    public function add_hasil($params)
    {
        return $this->db->insert('hasil', $params);
    }

    public function update_hasil($id_hasil, $params)
    {
        $this->db->where('id_hasil', $id_hasil);
        return $this->db->update('hasil', $params);
    }

    public function delete_hasil($id_hasil)
    {
        $this->db->where('id_hasil', $id_hasil);
        return $this->db->delete('hasil');
    }
}

/* End of file Hasil_model.php */
/* Location: ./application/models/Hasil_model.php */