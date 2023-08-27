<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('admin_model');
    }

    public function index()
    {
        $data['admin'] = $this->admin_model->get_all_admin()->result();
        $this->load->view('admin/index', $data);
    }

    public function tambah()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[admin.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'username' => $this->input->post('username', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
            );
            $this->admin_model->add_admin($params);

            $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil disimpan</div>');
            redirect('admin/tambah');
        } else {
            $this->load->view('admin/tambah');
        }
    }

    public function ubah($id_admin = '')
    {
        $data['admin'] = $this->admin_model->get_admin($id_admin)->row_array();

        if (isset($data['admin']['id_admin'])) {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required|callback_cek_unik_username');

            if ($this->form_validation->run()) {
                $params = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                    'username' => $this->input->post('username', TRUE),
                );
                $this->admin_model->update_admin($id_admin, $params);

                $this->session->set_flashdata('success', '<div class="alert bg-success" role="alert">Data berhasil disimpan</div>');
                redirect('admin/ubah/' . $id_admin);
            } else {
                $this->load->view('admin/ubah', $data);
            }
        } else {
            redirect('admin');
        }
    }

    public function cek_unik_username($username)
    {
        $query = $this->admin_model->cek_unik_username($username, $this->input->post('username_tmp'));
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('cek_unik_username', '{field} sudah digunakan');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function hapus($id_admin = '')
    {
        $admin = $this->admin_model->get_admin($id_admin);

        if ($admin->num_rows() > 0) {
            $this->admin_model->delete_admin($id_admin);
        }
        redirect('admin');
    }
}


/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
