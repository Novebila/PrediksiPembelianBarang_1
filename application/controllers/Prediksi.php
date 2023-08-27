<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Prediksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('training_model');
        $this->load->model('produk_model');
        $this->load->model('hasil_model');
    }

    public function index()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_produk', 'Produk', 'required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        $this->form_validation->set_rules('orders', 'Order', 'required');
        $this->form_validation->set_rules('shipment', 'Shipment', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');

        if ($this->form_validation->run()) {
            $id_produk = $this->input->post('id_produk');
            $produk = $this->produk_model->get_produk($id_produk)->row();

            $data['nama_produk'] = $produk->nama_produk;
            $data['bulan'] = $this->input->post('bulan');
            $data['tahun'] = $this->input->post('tahun');
            $data['order'] = $this->input->post('orders');
            $data['shipment'] = $this->input->post('shipment');
            $data['stok'] = $this->input->post('stok');

            $uji = array(
                'order' => $data['order'],
                'shipment' => $data['shipment'],
                'stok' => $data['stok'],
            );

            // panggil fungsi fuzzy tsukamoto
            $data['prediksi'] = $this->fuzzy_tsukamoto($id_produk, $uji);
            $data['perhitungan'] = $this->perhitungan($id_produk, $uji);

            // masukkan ke tabel hasil
            $params = [
                'id_produk' => $id_produk,
                'bulan' => $data['bulan'],
                'tahun' => $data['tahun'],
                'orders' => $data['order'],
                'shipment' => $data['shipment'],
                'stok' => $data['stok'],
                'produksi_prediksi' => $data['prediksi'],
            ];
            $this->hasil_model->add_hasil($params);

            $this->load->view('prediksi/hasil', $data);
        } else {
            $this->load->model('produk_model');
            $data['produk'] = $this->produk_model->get_all_produk()->result();
            $this->load->view('prediksi/index', $data);
        }
    }

    // metode fuzzy tsukamoto
    public function fuzzy_tsukamoto($id_produk, $uji)
    {
        $data =$this->get_min_max($id_produk);

        // fuzzifikasi
        $mu_rendah_order = $this->derajat_keanggotaan_rendah($uji['order'], $data['order']['min'], $data['order']['max']);
        $mu_tinggi_order = $this->derajat_keanggotaan_tinggi($uji['order'], $data['order']['min'], $data['order']['max']);

        $mu_rendah_shipment = $this->derajat_keanggotaan_rendah($uji['shipment'], $data['shipment']['min'], $data['shipment']['max']);
        $mu_tinggi_shipment = $this->derajat_keanggotaan_tinggi($uji['shipment'], $data['shipment']['min'], $data['shipment']['max']);

        $mu_rendah_stok = $this->derajat_keanggotaan_rendah($uji['stok'], $data['stok']['min'], $data['stok']['max']);
        $mu_tinggi_stok = $this->derajat_keanggotaan_tinggi($uji['stok'], $data['stok']['min'], $data['stok']['max']);

        // mesin inferensi
        // R-1
        $alpha_predikat1 = min($mu_rendah_order, $mu_rendah_shipment, $mu_rendah_stok);
        $z1 = $this->z_sedikit($alpha_predikat1, $data['produksi']['min'], $data['produksi']['max']);
        // R-2
        $alpha_predikat2 = min($mu_rendah_order, $mu_rendah_shipment, $mu_tinggi_stok);
        $z2 = $this->z_sedikit($alpha_predikat2, $data['produksi']['min'], $data['produksi']['max']);
        // R-3
        $alpha_predikat3 = min($mu_rendah_order, $mu_tinggi_shipment, $mu_rendah_stok);
        $z3 = $this->z_banyak($alpha_predikat3, $data['produksi']['min'], $data['produksi']['max']);
        // R-4
        $alpha_predikat4 = min($mu_rendah_order, $mu_tinggi_shipment, $mu_tinggi_stok);
        $z4 = $this->z_sedikit($alpha_predikat4, $data['produksi']['min'], $data['produksi']['max']);
        // R-5
        $alpha_predikat5 = min($mu_tinggi_order, $mu_rendah_shipment, $mu_rendah_stok);
        $z5 = $this->z_banyak($alpha_predikat5, $data['produksi']['min'], $data['produksi']['max']);
        // R-6
        $alpha_predikat6 = min($mu_tinggi_order, $mu_rendah_shipment, $mu_tinggi_stok);
        $z6 = $this->z_sedikit($alpha_predikat6, $data['produksi']['min'], $data['produksi']['max']);
        // R-7
        $alpha_predikat7 = min($mu_tinggi_order, $mu_tinggi_shipment, $mu_rendah_stok);
        $z7 = $this->z_banyak($alpha_predikat7, $data['produksi']['min'], $data['produksi']['max']);
        // R-8
        $alpha_predikat8 = min($mu_tinggi_order, $mu_tinggi_shipment, $mu_tinggi_stok);
        $z8 = $this->z_banyak($alpha_predikat8, $data['produksi']['min'], $data['produksi']['max']);

        // defuzzifikasi
        $z = round((($alpha_predikat1 * $z1) + ($alpha_predikat2 * $z2) + ($alpha_predikat3 * $z3) + ($alpha_predikat4 * $z4) + ($alpha_predikat5 * $z5) + ($alpha_predikat6 * $z6) + ($alpha_predikat7 * $z7) + ($alpha_predikat8 * $z8)) / ($alpha_predikat1 + $alpha_predikat2 + $alpha_predikat3 + $alpha_predikat4 + $alpha_predikat5 + $alpha_predikat6 + $alpha_predikat7 + $alpha_predikat8), 0);

        return $z;
    }

    public function derajat_keanggotaan_rendah($x, $batas_kiri, $batas_kanan)
    {
        if ($x <= $batas_kiri) {
            return 1;
        } elseif ($x >= $batas_kanan) {
            return 0;
        } else {
            return ($batas_kanan - $x) / ($batas_kanan - $batas_kiri);
        }
    }

    public function derajat_keanggotaan_tinggi($x, $batas_kiri, $batas_kanan)
    {
        if ($x <= $batas_kiri) {
            return 0;
        } elseif ($x >= $batas_kanan) {
            return 1;
        } else {
            return ($x - $batas_kiri) / ($batas_kanan - $batas_kiri);
        }
    }

    public function get_min_max($id_produk)
    {
        $training = $this->training_model->get_all_training_produk($id_produk)->result_array();

        $result = array(
            'order' => array(
                'min' => min(array_column($training, 'orders')),
                'max' => max(array_column($training, 'orders')),
            ),
            'shipment' => array(
                'min' => min(array_column($training, 'shipment')),
                'max' => max(array_column($training, 'shipment')),
            ),
            'stok' => array(
                'min' => min(array_column($training, 'stok')),
                'max' => max(array_column($training, 'stok')),
            ),
            'produksi' => array(
                'min' => min(array_column($training, 'produksi')),
                'max' => max(array_column($training, 'produksi')),
            ),
        );

        return $result;
    }

    public function z_sedikit($x, $batas_kiri, $batas_kanan)
    {
        return $batas_kanan - ($x * ($batas_kanan - $batas_kiri));
    }

    public function z_banyak($x, $batas_kiri, $batas_kanan)
    {
        return $batas_kiri + ($x * ($batas_kanan - $batas_kiri));
    }

    // rumus perhitungan
    public function perhitungan($id_produk, $uji)
    {
        $produk = $this->produk_model->get_produk($id_produk)->row();
        $res = $this->get_min_max($id_produk);

        $tbl = '';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <th>Produk</th>
                        <th>Order</th>
                        <th>Penjualan</th>
                        <th>Stok</th>
                        <th>Pembelian</th>
                    </tr>
                    <tr>
                        <td>' . $produk->nama_produk . '</td>
                        <td>' . $uji['order'] . '</td>
                        <td>' . $uji['shipment'] . '</td>
                        <td>' . $uji['stok'] . '</td>
                        <td>???</td>
                    </tr>
                </table>';

        $tbl .= '<h4>Rentang Nilai</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>' . $produk->nama_produk . '</th>
                        <th>Order</th>
                        <th>Penjualan</th>
                        <th>Stok</th>
                        <th>Pembelian</th>
                    </tr>
                    <tr>
                        <td>Min</td>
                        <td>' . $res['order']['min'] . '</td>
                        <td>' . $res['shipment']['min'] . '</td>
                        <td>' . $res['stok']['min'] . '</td>
                        <td>' . $res['produksi']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>Max</td>
                        <td>' . $res['order']['max'] . '</td>
                        <td>' . $res['shipment']['max'] . '</td>
                        <td>' . $res['stok']['max'] . '</td>
                        <td>' . $res['produksi']['max'] . '</td>
                    </tr>
                </table>';

        $tbl .= '<h4>Fuzzifikasi</h4>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <th>Himpunan</th>
                        <th colspan="2">Fungsi Keanggotaan</th>
                    </tr>
                    <tr>
                        <td rowspan="3">Order Rendah</td>
                        <td>1</td>
                        <td>x <= ' . $res['order']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(' . $res['order']['max'] . ' - x) / (' . $res['order']['max'] . ' - ' . $res['order']['min'] . ')</td>
                        <td>' . $res['order']['min'] . ' < x < ' . $res['order']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>x >= ' . $res['order']['max'] . '</td>
                    </tr>
                    <tr>
                        <td rowspan="3">Order Tinggi</td>
                        <td>0</td>
                        <td>x <= ' . $res['order']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(x - ' . $res['order']['min'] . ') / (' . $res['order']['max'] . ' - ' . $res['order']['min'] . ')</td>
                        <td>' . $res['order']['min'] . ' < x < ' . $res['order']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>x >= ' . $res['order']['max'] . '</td>
                    </tr>
                </table>';

        $dk_rendah = $this->tampil_derajat_keanggotaan_rendah($uji['order'], $res['order']['min'], $res['order']['max']);
        $dk_tinggi = $this->tampil_derajat_keanggotaan_tinggi($uji['order'], $res['order']['min'], $res['order']['max']);
        $hsl_rendah = $this->derajat_keanggotaan_rendah($uji['order'], $res['order']['min'], $res['order']['max']);
        $hsl_tinggi = $this->derajat_keanggotaan_tinggi($uji['order'], $res['order']['min'], $res['order']['max']);

        $tbl .= '<table class="table table-bordered">
                <tr>
                    <th>Derajat Keanggotaan</th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <td>&mu; Order Rendah [' . $uji['order'] . ']</td>
                    <td>' . $dk_rendah[1] . '</td>
                    <td>= ' . $hsl_rendah . '</td>
                </tr>
                <tr>
                    <td>&mu; Order Tinggi [' . $uji['order'] . ']</td>
                    <td>' . $dk_tinggi[1] . '</td>
                    <td>= ' . $hsl_tinggi . '</td>
                </tr>
            </table>';

        $tbl .= '
                <hr>
                <table class="table table-bordered">
                    <tr>
                        <th>Himpunan</th>
                        <th colspan="2">Fungsi Keanggotaan</th>
                    </tr>
                    <tr>
                        <td rowspan="3">Penjualan Rendah</td>
                        <td>1</td>
                        <td>x <= ' . $res['shipment']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(' . $res['shipment']['max'] . ' - x) / (' . $res['shipment']['max'] . ' - ' . $res['shipment']['min'] . ')</td>
                        <td>' . $res['shipment']['min'] . ' < x < ' . $res['shipment']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>x >= ' . $res['shipment']['max'] . '</td>
                    </tr>
                    <tr>
                        <td rowspan="3">Penjualan Tinggi</td>
                        <td>0</td>
                        <td>x <= ' . $res['shipment']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(x - ' . $res['shipment']['min'] . ') / (' . $res['shipment']['max'] . ' - ' . $res['shipment']['min'] . ')</td>
                        <td>' . $res['shipment']['min'] . ' < x < ' . $res['shipment']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>x >= ' . $res['shipment']['max'] . '</td>
                    </tr>
                </table>';

        $dk_rendah = $this->tampil_derajat_keanggotaan_rendah($uji['shipment'], $res['shipment']['min'], $res['shipment']['max']);
        $dk_tinggi = $this->tampil_derajat_keanggotaan_tinggi($uji['shipment'], $res['shipment']['min'], $res['shipment']['max']);
        $hsl_rendah = $this->derajat_keanggotaan_rendah($uji['shipment'], $res['shipment']['min'], $res['shipment']['max']);
        $hsl_tinggi = $this->derajat_keanggotaan_tinggi($uji['shipment'], $res['shipment']['min'], $res['shipment']['max']);

        $tbl .= '<table class="table table-bordered">
                <tr>
                    <th>Derajat Keanggotaan</th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <td>&mu; Penjualan Rendah [' . $uji['shipment'] . ']</td>
                    <td>' . $dk_rendah[1] . '</td>
                    <td>= ' . $hsl_rendah . '</td>
                </tr>
                <tr>
                    <td>&mu; Penjualan Tinggi [' . $uji['shipment'] . ']</td>
                    <td>' . $dk_tinggi[1] . '</td>
                    <td>= ' . $hsl_tinggi . '</td>
                </tr>
            </table>';

        $tbl .= '
                <hr>
                <table class="table table-bordered">
                    <tr>
                        <th>Himpunan</th>
                        <th colspan="2">Fungsi Keanggotaan</th>
                    </tr>
                    <tr>
                        <td rowspan="3">Stok Rendah</td>
                        <td>1</td>
                        <td>x <= ' . $res['stok']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(' . $res['stok']['max'] . ' - x) / (' . $res['stok']['max'] . ' - ' . $res['stok']['min'] . ')</td>
                        <td>' . $res['stok']['min'] . ' < x < ' . $res['stok']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>x >= ' . $res['stok']['max'] . '</td>
                    </tr>
                    <tr>
                        <td rowspan="3">Stok Tinggi</td>
                        <td>0</td>
                        <td>x <= ' . $res['stok']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(x - ' . $res['stok']['min'] . ') / (' . $res['stok']['max'] . ' - ' . $res['stok']['min'] . ')</td>
                        <td>' . $res['stok']['min'] . ' < x < ' . $res['stok']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>x >= ' . $res['stok']['max'] . '</td>
                    </tr>
                </table>';

        $dk_rendah = $this->tampil_derajat_keanggotaan_rendah($uji['stok'], $res['stok']['min'], $res['stok']['max']);
        $dk_tinggi = $this->tampil_derajat_keanggotaan_tinggi($uji['stok'], $res['stok']['min'], $res['stok']['max']);
        $hsl_rendah = $this->derajat_keanggotaan_rendah($uji['stok'], $res['stok']['min'], $res['stok']['max']);
        $hsl_tinggi = $this->derajat_keanggotaan_tinggi($uji['stok'], $res['stok']['min'], $res['stok']['max']);

        $tbl .= '<table class="table table-bordered">
                <tr>
                    <th>Derajat Keanggotaan</th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <td>&mu; Stok Rendah [' . $uji['stok'] . ']</td>
                    <td>' . $dk_rendah[1] . '</td>
                    <td>= ' . $hsl_rendah . '</td>
                </tr>
                <tr>
                    <td>&mu; Stok Tinggi [' . $uji['stok'] . ']</td>
                    <td>' . $dk_tinggi[1] . '</td>
                    <td>= ' . $hsl_tinggi . '</td>
                </tr>
            </table>';

        $tbl .= '
                <hr>
                <table class="table table-bordered">
                    <tr>
                        <th>Himpunan</th>
                        <th colspan="2">Fungsi Keanggotaan</th>
                    </tr>
                    <tr>
                        <td rowspan="3">Produksi Sedikit</td>
                        <td>1</td>
                        <td>z <= ' . $res['produksi']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                        <td>' . $res['produksi']['min'] . ' < z < ' . $res['produksi']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>z >= ' . $res['produksi']['max'] . '</td>
                    </tr>
                    <tr>
                        <td rowspan="3">Produksi Banyak</td>
                        <td>0</td>
                        <td>z <= ' . $res['produksi']['min'] . '</td>
                    </tr>
                    <tr>
                        <td>(z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                        <td>' . $res['produksi']['min'] . ' < z < ' . $res['produksi']['max'] . '</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>z >= ' . $res['produksi']['max'] . '</td>
                    </tr>
                </table>';

        $tbl .= '<h4>Pembentukan Basis Pengetahuan Fuzzy</h4>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <th>Kode</th>
                        <th>Rule</th>
                    </tr>
                    <tr>
                        <td>[R1]</td>
                        <td>IF Order Rendah AND Penjualan Rendah AND Stok Rendah THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>[R2]</td>
                        <td>IF Order Rendah AND Penjualan Rendah AND Stok Tinggi THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>[R3]</td>
                        <td>IF Order Rendah AND Penjualan Tinggi AND Stok Rendah THEN Pembelian Banyak</td>
                    </tr>
                    <tr>
                        <td>[R4]</td>
                        <td>IF Order Rendah AND Penjualan Tinggi AND Stok Tinggi THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>[R5]</td>
                        <td>IF Order Tinggi AND Penjualan Rendah AND Stok Rendah THEN Pembelian Banyak</td>
                    </tr>
                    <tr>
                        <td>[R6]</td>
                        <td>IF Order Tinggi AND Penjualan Rendah AND Stok Tinggi THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>[R7]</td>
                        <td>IF Order Tinggi AND Penjualan Tinggi AND Stok Rendah THEN Pembelian Banyak</td>
                    </tr>
                    <tr>
                        <td>[R8]</td>
                        <td>IF Order Tinggi AND Penjualan Tinggi AND Stok Tinggi THEN Pembelian Banyak</td>
                    </tr>
                </table>';

        $mu_rendah_order = $this->derajat_keanggotaan_rendah($uji['order'], $res['order']['min'], $res['order']['max']);
        $mu_tinggi_order = $this->derajat_keanggotaan_tinggi($uji['order'], $res['order']['min'], $res['order']['max']);
        $mu_rendah_shipment = $this->derajat_keanggotaan_rendah($uji['shipment'], $res['shipment']['min'], $res['shipment']['max']);
        $mu_tinggi_shipment = $this->derajat_keanggotaan_tinggi($uji['shipment'], $res['shipment']['min'], $res['shipment']['max']);
        $mu_rendah_stok = $this->derajat_keanggotaan_rendah($uji['stok'], $res['stok']['min'], $res['stok']['max']);
        $mu_tinggi_stok = $this->derajat_keanggotaan_tinggi($uji['stok'], $res['stok']['min'], $res['stok']['max']);

        $alpha_predikat1 = min($mu_rendah_order, $mu_rendah_shipment, $mu_rendah_stok);
        $z1 = $this->z_sedikit($alpha_predikat1, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat2 = min($mu_rendah_order, $mu_rendah_shipment, $mu_tinggi_stok);
        $z2 = $this->z_sedikit($alpha_predikat2, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat3 = min($mu_rendah_order, $mu_tinggi_shipment, $mu_rendah_stok);
        $z3 = $this->z_banyak($alpha_predikat3, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat4 = min($mu_rendah_order, $mu_tinggi_shipment, $mu_tinggi_stok);
        $z4 = $this->z_sedikit($alpha_predikat4, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat5 = min($mu_tinggi_order, $mu_rendah_shipment, $mu_rendah_stok);
        $z5 = $this->z_banyak($alpha_predikat5, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat6 = min($mu_tinggi_order, $mu_rendah_shipment, $mu_tinggi_stok);
        $z6 = $this->z_sedikit($alpha_predikat6, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat7 = min($mu_tinggi_order, $mu_tinggi_shipment, $mu_rendah_stok);
        $z7 = $this->z_banyak($alpha_predikat7, $res['produksi']['min'], $res['produksi']['max']);
        $alpha_predikat8 = min($mu_tinggi_order, $mu_tinggi_shipment, $mu_tinggi_stok);
        $z8 = $this->z_banyak($alpha_predikat8, $res['produksi']['min'], $res['produksi']['max']);

        $tbl .= '<h4>Mesin Inferensi</h4>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <td>[R-1]</td>
                        <td>IF Order Rendah</td>
                        <td>AND Penjualan Rendah</td>
                        <td>AND Stok Rendah</td>
                        <td>THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>min</td>
                        <td>' . $mu_rendah_order . '</td>
                        <td>' . $mu_rendah_shipment . '</td>
                        <td>' . $mu_rendah_stok . '</td>
                        <td>(' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>&alpha;1</td>
                        <td colspan="3">' . min($mu_rendah_order, $mu_rendah_shipment, $mu_rendah_stok) . '</td>
                        <td>= (' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>Z1</td>
                        <td colspan="4">' . $z1 . '</td>
                    </tr>
                </table>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <td>[R-2]</td>
                        <td>IF Order Rendah</td>
                        <td>AND Penjualan Rendah</td>
                        <td>AND Stok Tinggi</td>
                        <td>THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>min</td>
                        <td>' . $mu_rendah_order . '</td>
                        <td>' . $mu_rendah_shipment . '</td>
                        <td>' . $mu_tinggi_stok . '</td>
                        <td>(' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>&alpha;2</td>
                        <td colspan="3">' . min($mu_rendah_order, $mu_rendah_shipment, $mu_tinggi_stok) . '</td>
                        <td>= (' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>Z2</td>
                        <td colspan="4">' . $z2 . '</td>
                    </tr>
                </table>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <td>[R-3]</td>
                        <td>IF Order Rendah</td>
                        <td>AND Penjualan Tinggi</td>
                        <td>AND Stok Rendah</td>
                        <td>THEN Pembelian Banyak</td>
                    </tr>
                    <tr>
                        <td>min</td>
                        <td>' . $mu_rendah_order . '</td>
                        <td>' . $mu_tinggi_shipment . '</td>
                        <td>' . $mu_rendah_stok . '</td>
                        <td>(z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>&alpha;3</td>
                        <td colspan="3">' . min($mu_rendah_order, $mu_tinggi_shipment, $mu_rendah_stok) . '</td>
                        <td>= (z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>Z3</td>
                        <td colspan="4">' . $z3 . '</td>
                    </tr>
                </table>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <td>[R-4]</td>
                        <td>IF Order Rendah</td>
                        <td>AND Penjualan Tinggi</td>
                        <td>AND Stok Tinggi</td>
                        <td>THEN Pembelian Sedikit</td>
                    </tr>
                    <tr>
                        <td>min</td>
                        <td>' . $mu_rendah_order . '</td>
                        <td>' . $mu_tinggi_shipment . '</td>
                        <td>' . $mu_tinggi_stok . '</td>
                        <td>(' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>&alpha;4</td>
                        <td colspan="3">' . min($mu_rendah_order, $mu_tinggi_shipment, $mu_tinggi_stok) . '</td>
                        <td>= (' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                    </tr>
                    <tr>
                        <td>Z4</td>
                        <td colspan="4">' . $z4 . '</td>
                    </tr>
                </table>';
        $tbl .= '<table class="table table-bordered">
                <tr>
                    <td>[R-5]</td>
                    <td>IF Order Tinggi</td>
                    <td>AND Penjualan Rendah</td>
                    <td>AND Stok Rendah</td>
                    <td>THEN Pembelian Banyak</td>
                </tr>
                <tr>
                    <td>min</td>
                    <td>' . $mu_tinggi_order . '</td>
                    <td>' . $mu_rendah_shipment . '</td>
                    <td>' . $mu_rendah_stok . '</td>
                    <td>(z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                </tr>
                <tr>
                    <td>&alpha;5</td>
                    <td colspan="3">' . min($mu_tinggi_order, $mu_rendah_shipment, $mu_rendah_stok) . '</td>
                    <td>= (z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
                </tr>
                <tr>
                    <td>Z5</td>
                    <td colspan="4">' . $z5 . '</td>
                </tr>
            </table>';
        $tbl .= '<table class="table table-bordered">
            <tr>
                <td>[R-6]</td>
                <td>IF Order Tinggi</td>
                <td>AND Penjualan Rendah</td>
                <td>AND Stok Tinggi</td>
                <td>THEN Pembelian Sedikit</td>
            </tr>
            <tr>
                <td>min</td>
                <td>' . $mu_tinggi_order . '</td>
                <td>' . $mu_rendah_shipment . '</td>
                <td>' . $mu_tinggi_stok . '</td>
                <td>(' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
            </tr>
            <tr>
                <td>&alpha;6</td>
                <td colspan="3">' . min($mu_rendah_order, $mu_tinggi_shipment, $mu_tinggi_stok) . '</td>
                <td>= (' . $res['produksi']['max'] . ' - z) / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
            </tr>
            <tr>
                <td>Z6</td>
                <td colspan="4">' . $z6 . '</td>
            </tr>
        </table>';
        $tbl .= '<table class="table table-bordered">
            <tr>
                <td>[R-7]</td>
                <td>IF Order Tinggi</td>
                <td>AND Penjualan Tinggi</td>
                <td>AND Stok Rendah</td>
                <td>THEN Pembelian Banyak</td>
            </tr>
            <tr>
                <td>min</td>
                <td>' . $mu_tinggi_order . '</td>
                <td>' . $mu_tinggi_shipment . '</td>
                <td>' . $mu_rendah_stok . '</td>
                <td>(z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
            </tr>
            <tr>
                <td>&alpha;7</td>
                <td colspan="3">' . min($mu_tinggi_order, $mu_tinggi_shipment, $mu_rendah_stok) . '</td>
                <td>= (z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
            </tr>
            <tr>
                <td>Z7</td>
                <td colspan="4">' . $z7 . '</td>
            </tr>
        </table>';
        $tbl .= '<table class="table table-bordered">
            <tr>
                <td>[R-8]</td>
                <td>IF Order Tinggi</td>
                <td>AND Penjualan Tinggi</td>
                <td>AND Stok Tinggi</td>
                <td>THEN Pembelian Banyak</td>
            </tr>
            <tr>
                <td>min</td>
                <td>' . $mu_tinggi_order . '</td>
                <td>' . $mu_tinggi_shipment . '</td>
                <td>' . $mu_tinggi_stok . '</td>
                <td>(z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
            </tr>
            <tr>
                <td>&alpha;8</td>
                <td colspan="3">' . min($mu_tinggi_order, $mu_tinggi_shipment, $mu_tinggi_stok) . '</td>
                <td>= (z - ' . $res['produksi']['min'] . ') / (' . $res['produksi']['max'] . ' - ' . $res['produksi']['min'] . ')</td>
            </tr>
            <tr>
                <td>Z8</td>
                <td colspan="4">' . $z8 . '</td>
            </tr>
        </table>';

        $z = (($alpha_predikat1 * $z1) + ($alpha_predikat2 * $z2) + ($alpha_predikat3 * $z3) + ($alpha_predikat4 * $z4) + ($alpha_predikat5 * $z5) + ($alpha_predikat6 * $z6) + ($alpha_predikat7 * $z7) + ($alpha_predikat8 * $z8)) / ($alpha_predikat1 + $alpha_predikat2 + $alpha_predikat3 + $alpha_predikat4 + $alpha_predikat5 + $alpha_predikat6 + $alpha_predikat7 + $alpha_predikat8);

        $tbl .= '<h4>Defuzzifikasi</h4>';
        $tbl .= '<table class="table table-bordered">
                    <tr>
                        <td>Z</td>
                        <td>= (&alpha;1 x Z1 + &alpha;2 x Z2 + &alpha;3 x Z3 + &alpha;4 x Z4 + &alpha;5 x Z5 + &alpha;6 x Z6 + &alpha;7 x Z7 + &alpha;8 x Z8) / (&alpha;1 + &alpha;2 + &alpha;3 + &alpha;4 + &alpha;5 + &alpha;6 + &alpha;7 + &alpha;8)</td>
                    </tr>
                    <tr>
                        <td>Z</td>
                        <td>= (' . $alpha_predikat1 . ' x ' . $z1 . ' + ' . $alpha_predikat2 . ' x ' . $z2 . ' + ' . $alpha_predikat3 . ' x ' . $z3 . ' + ' . $alpha_predikat4 . ' x ' . $z4 . ' + ' . $alpha_predikat5 . ' x ' . $z5 . ' + ' . $alpha_predikat6 . ' x ' . $z6 . ' + ' . $alpha_predikat7 . ' x ' . $z7 . ' + ' . $alpha_predikat8 . ' x ' . $z8 . ') / (' . $alpha_predikat1 . ' + ' . $alpha_predikat2 . ' + ' . $alpha_predikat3 . ' + ' . $alpha_predikat4 . ' + ' . $alpha_predikat5 . ' + ' . $alpha_predikat6 . ' + ' . $alpha_predikat7 . ' + ' . $alpha_predikat8 . ')</td>
                    </tr>
                    <tr>
                        <td>Z</td>
                        <td>= ' . $z . '</td>
                    </tr>
                    <tr>
                        <td>Z</td>
                        <td>dibulatkan menjadi ' . round($z, 0) . '</td>
                    </tr>
                </table>';

        return $tbl;
    }

    public function tampil_derajat_keanggotaan_rendah($x, $batas_kiri, $batas_kanan)
    {
        $result = array();
        if ($x <= $batas_kiri) {
            $result[0] = 'x <= ' . $batas_kiri;
            $result[1] = 1;
        } elseif ($x >= $batas_kanan) {
            $result[0] = 'x >= ' . $batas_kanan;
            $result[1] = 0;
        } else {
            $result[0] = '(' . $batas_kanan . ' - x) / (' . $batas_kanan . ' - ' . $batas_kiri . ')';
            $result[1] = '(' . $batas_kanan . ' - ' . $x . ') / (' . $batas_kanan . ' - ' . $batas_kiri . ')';
        }
        return $result;
    }

    public function tampil_derajat_keanggotaan_tinggi($x, $batas_kiri, $batas_kanan)
    {
        $result = array();
        if ($x <= $batas_kiri) {
            $result[0] = 'x <= ' . $batas_kiri;
            $result[1] = 0;
        } elseif ($x >= $batas_kanan) {
            $result[0] = 'x >= ' . $batas_kanan;
            $result[1] = 1;
        } else {
            $result[0] = '(x - ' . $batas_kiri . ') / (' . $batas_kanan . ' - ' . $batas_kiri . ')';
            $result[1] = '(' . $x . ' - ' . $batas_kiri . ') / (' . $batas_kanan . ' - ' . $batas_kiri . ')';
        }
        return $result;
    }
}


/* End of file Prediksi.php */
/* Location: ./application/controllers/Prediksi.php */