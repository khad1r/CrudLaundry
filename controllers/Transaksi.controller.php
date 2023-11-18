<?php

class Transaksi extends Controller
{
    public function index()
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect('/Login');
            exit;
        }
        $data['title'] = "Transaksi";

        $model = $this->model('Transaksi_model');

        $jenis_model = $this->model('jenis_model');
        $data['jenis'] = $jenis_model->get();
        $data['transaksi'] = $model->getTransaksi();

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('transaksi/index', $data);
        $this->view('templates/footer');
    }
    public function add()
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect('/Login');
            exit;
        }
        if (isset($_POST['priceForm'])) {
            try {
                if ($this->model('Transaksi_model')->insert($_POST) > 0) {
                    $_SESSION['alert'] = array('success', 'Berhasil Submit');
                    App::Redirect('/Transaksi');
                    exit;
                } else {
                    $_SESSION['alert'] = array('danger', 'Gagal Submit');
                    App::Referer('/Transaksi/add');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['alert'] = ['danger', $e->getMessage()];
                App::Referer('/Transaksi');
                exit;
            }
        }
        $data['title'] = "Transaksi";
        $jenis_model = $this->model('jenis_model');
        $data['jenis'] = $jenis_model->get();
        $data['form_action'] = BASEURL . "/Transaksi/add";
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('transaksi/form', $data);
        $this->view('templates/footer');
    }
    public function edit($data)
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect('/Login');
            exit;
        }
        $post = [...$_POST, 'id' => $data['id']];
        if (isset($post['update_status'])) {
            try {
                if ($this->model('Transaksi_model')->updateStatus($post) > 0) {
                    $_SESSION['alert'] = array('success', 'Berhasil Submit');
                    App::Redirect('/Transaksi');
                    exit;
                } else {
                    $_SESSION['alert'] = array('danger', 'Gagal Submit');
                    App::Referer('/Transaksi');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['alert'] = ['danger', $e->getMessage()];
                App::Referer('/Transaksi');
                exit;
            }
        }
        if (isset($post['priceForm'])) {
            try {
                if ($this->model('Transaksi_model')->update($post) > 0) {
                    $_SESSION['alert'] = array('success', 'Berhasil Submit');
                    App::Redirect('/Transaksi');
                    exit;
                } else {
                    $_SESSION['alert'] = array('danger', 'Gagal Submit');
                    App::Referer('/Transaksi');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['alert'] = ['danger', $e->getMessage()];
                App::Referer('/Transaksi');
                exit;
            }
        }
        $data['title'] = "Edit Transaksi {$data['id']}";
        $jenis_model = $this->model('jenis_model');
        $data['jenis'] = $jenis_model->get();
        $Transaksi_model = $this->model('Transaksi_model');
        $data['data_edit'] = $Transaksi_model->getTransaksi($data['id']);

        $data['form_action'] = BASEURL . "/Transaksi/edit/id/{$data['id']}";
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('transaksi/form', $data);
        $this->view('templates/footer');
    }
    public function delete($data)
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Referer();
            exit;
        }
        try {
            if ($this->model('Transaksi_model')->delete($data['id']) > 0) {

                $_SESSION['alert'] = ['success', 'Operasi  berhasil'];
                App::Redirect('/Transaksi');
                exit;
            } else {
                $_SESSION['alert'] = ['danger', 'Operasi Gagal'];
                App::Referer("/Transaksi/edit/id/{$data['id']}");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = ['danger', $e->getMessage()];
            App::Referer("/Transaksi/edit/id/{$data['id']}");
            exit;
        }
        App::Referer();
    }
}
