<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Hasil extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('hasil_model');
    }

    public function index()
    {
        $data['hasil'] = $this->hasil_model->get_all_hasil()->result_array();

        $total = 0;
        foreach ($data['hasil'] as $row) {
            if (!empty($row['produksi_aktual'])) {
                $prediksi = $row['produksi_prediksi'];
                $aktual = $row['produksi_aktual'];
                $total += pow($aktual - $prediksi, 2);
            }
        }
        $data['mse'] = $total / count($data['hasil']);

        $this->load->view('hasil/index', $data);
    }

    public function ubah($id_hasil = '')
    {
        $data['hasil'] = $this->hasil_model->get_hasil($id_hasil)->row_array();

        if (isset($data['hasil']['id_hasil'])) {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('produksi_aktual', 'Produksi (Aktual)', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'produksi_aktual' => $this->input->post('produksi_aktual', TRUE),
                );
                $this->hasil_model->update_hasil($id_hasil, $params);

                $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil diubah</div>');
                redirect('hasil/ubah/' . $id_hasil);
            } else {
                $this->load->view('hasil/ubah', $data);
            }
        } else {
            redirect('hasil');
        }
    }

    function hapus($id_hasil = '')
    {
        $hasil = $this->hasil_model->get_hasil($id_hasil);

        if ($hasil->num_rows() > 0) {
            $this->hasil_model->delete_hasil($id_hasil);
        }
        redirect('hasil');
    }

    public function pdf()
    {
        $data['hasil'] = $this->hasil_model->get_all_hasil()->result_array();
        $html = $this->load->view('hasil/pdf', $data, TRUE);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-hasil.pdf', array('Attachment' => FALSE));
    }
}


/* End of file Hasil.php */
/* Location: ./application/controllers/Hasil.php */