<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('produk_model');
    }

    public function index()
    {
        $data['produk'] = $this->produk_model->get_all_produk()->result_array();
        $this->load->view('produk/index', $data);
    }

    public function tambah()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'nama_produk' => $this->input->post('nama_produk', TRUE),
            );
            $this->produk_model->add_produk($params);

            $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil disimpan</div>');
            redirect('produk/tambah');
        } else {
            $this->load->view('produk/tambah');
        }
    }

    public function ubah($id_produk = '')
    {
        $data['produk'] = $this->produk_model->get_produk($id_produk)->row_array();

        if (isset($data['produk']['id_produk'])) {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'nama_produk' => $this->input->post('nama_produk', TRUE),
                );
                $this->produk_model->update_produk($id_produk, $params);

                $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil disimpan</div>');
                redirect('produk/ubah/' . $id_produk);
            } else {
                $this->load->view('produk/ubah', $data);
            }
        } else {
            redirect('produk');
        }
    }

    function hapus($id_produk = '')
    {
        $produk = $this->produk_model->get_produk($id_produk);

        if ($produk->num_rows() > 0) {
            $this->produk_model->delete_produk($id_produk);
        }
        redirect('produk');
    }
}


/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
