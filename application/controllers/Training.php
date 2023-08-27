<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Training extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('training_model');
    }

    public function index()
    {
        $data['training'] = $this->training_model->get_all_training()->result_array();
        $this->load->view('training/index', $data);
    }

    public function tambah()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_produk', 'Produk', 'required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        $this->form_validation->set_rules('orders', 'Order', 'required');
        $this->form_validation->set_rules('shipment', 'Shipment', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('produksi', 'Produksi', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'id_produk' => $this->input->post('id_produk', TRUE),
                'orders' => $this->input->post('orders', TRUE),
                'produksi' => $this->input->post('produksi', TRUE),
                'shipment' => $this->input->post('shipment', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'bulan' => $this->input->post('bulan', TRUE),
                'tahun' => $this->input->post('tahun', TRUE),
            );
            $this->training_model->add_training($params);

            $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil disimpan</div>');
            redirect('training/tambah');
        } else {
            $this->load->model('produk_model');
            $data['produk'] = $this->produk_model->get_all_produk()->result();
            $this->load->view('training/tambah', $data);
        }
    }

    public function ubah($id_training = '')
    {
        $data['training'] = $this->training_model->get_training($id_training)->row_array();

        if (isset($data['training']['id_training'])) {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('id_produk', 'Produk', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required');
            $this->form_validation->set_rules('orders', 'Order', 'required');
            $this->form_validation->set_rules('shipment', 'Shipment', 'required');
            $this->form_validation->set_rules('stok', 'Stok', 'required');
            $this->form_validation->set_rules('produksi', 'Produksi', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'id_produk' => $this->input->post('id_produk', TRUE),
                    'orders' => $this->input->post('orders', TRUE),
                    'produksi' => $this->input->post('produksi', TRUE),
                    'shipment' => $this->input->post('shipment', TRUE),
                    'stok' => $this->input->post('stok', TRUE),
                    'bulan' => $this->input->post('bulan', TRUE),
                    'tahun' => $this->input->post('tahun', TRUE),
                );
                $this->training_model->update_training($id_training, $params);

                $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil disimpan</div>');
                redirect('training/ubah/' . $id_training);
            } else {
                $this->load->model('produk_model');
                $data['produk'] = $this->produk_model->get_all_produk()->result();
                $this->load->view('training/ubah', $data);
            }
        } else {
            redirect('training');
        }
    }

    function hapus($id_training = '')
    {
        $training = $this->training_model->get_training($id_training);

        if ($training->num_rows() > 0) {
            $this->training_model->delete_training($id_training);
        }
        redirect('training');
    }
}


/* End of file Training.php */
/* Location: ./application/controllers/Training.php */