<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Training_model extends CI_Model
{

    public function get_all_training($sort = 'asc')
    {
        $this->db->order_by('id_training', $sort);
        $this->db->join('produk', 'produk.id_produk=training.id_produk', 'left');
        return $this->db->get('training');
    }

    public function get_all_training_produk($id_produk = '')
    {
        $this->db->where('training.id_produk', $id_produk);
        $this->db->order_by('id_training', 'asc');
        $this->db->join('produk', 'produk.id_produk=training.id_produk', 'left');
        return $this->db->get('training');
    }

    public function get_training($id_training)
    {
        $this->db->where('id_training', $id_training);
        $this->db->join('produk', 'produk.id_produk=training.id_produk', 'left');
        return $this->db->get('training');
    }

    public function add_training($params)
    {
        return $this->db->insert('training', $params);
    }

    public function update_training($id_training, $params)
    {
        $this->db->where('id_training', $id_training);
        return $this->db->update('training', $params);
    }

    public function delete_training($id_training)
    {
        $this->db->where('id_training', $id_training);
        return $this->db->delete('training');
    }
}

/* End of file Training_model.php */
/* Location: ./application/models/Training_model.php */