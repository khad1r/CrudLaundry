<?php

class Transaksi_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getTransaksi($id = null)
    {
        if (isset($id)) return $this->db->query('SELECT * FROM v_penjualan where id = :id')->bind('id', $id)->resultSingle();
        else return $this->db->query('SELECT * FROM v_penjualan')->resultSet();
    }
    public function insert($data)
    {

        $error = [];

        foreach ($data as &$input) $input = htmlspecialchars($input);

        $jenis = $this->db->query("SELECT * FROM `jenis` WHERE `id` =:id")->bind('id', $data['jenis'])->resultSingle();

        if (empty($jenis)) $error['jenis'] = 'Ada Kesalahan Pada Input Jenis Cuci';

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }

        $this->db->query('INSERT INTO transaksi 
                            VALUE("",
                                :waktu_terima,
                                :kg,
                                :id_jenis,
                                :waktu_selesai,
                                :keterangan,
                                :status
                                )')
            ->bind('waktu_terima', $data['waktu_terima'])
            ->bind('kg', $data['kg'])
            ->bind('id_jenis', $jenis['id'])
            ->bind('waktu_selesai', $data['waktu_selesai'])
            ->bind('keterangan', $data['keterangan'])
            ->bind('status', $data['status'])
            ->execute();
        return $this->db->affectedRows();
    }
    public function update($data)
    {
        $error = [];
        foreach ($data as &$input) $input = htmlspecialchars($input);
        $jenis = $this->db->query("SELECT * FROM `jenis` WHERE `id` =:id")->bind('id', $data['jenis'])->resultSingle();
        if (empty($jenis)) $error['jenis'] = 'Ada Kesalahan Pada Input Jenis Cuci';
        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }
        $query = "UPDATE transaksi SET 
                    waktu_terima=:waktu_terima, 
                    kg=:kg,
                    id_jenis=:id_jenis,
                    waktu_selesai=:waktu_selesai,
                    keterangan=:keterangan,
                    status=:status
                WHERE id=:id";
        $this->db->query($query)
            ->bind('waktu_terima', $data['waktu_terima'])
            ->bind('kg', $data['kg'])
            ->bind('id_jenis', $jenis['id'])
            ->bind('waktu_selesai', $data['waktu_selesai'])
            ->bind('keterangan', $data['keterangan'])
            ->bind('status', $data['status'])
            ->bind('id', $data['id'])
            ->execute();
        return $this->db->affectedRows();
    }
    public function updateStatus($data)
    {
        foreach ($data as &$input) $input = htmlspecialchars($input);
        if ($data['update_status'] === "4") {
            $query = "UPDATE transaksi SET 
                waktu_selesai=:waktu_selesai, 
                status=:status
            WHERE id=:id";
            $this->db->query($query)
                ->bind('waktu_selesai', date('Y-m-d H:i:s'))
                ->bind('status', $data['update_status'])
                ->bind('id', $data['id'])
                ->execute();
        } else {
            $query = "UPDATE transaksi SET 
                status=:status
            WHERE id=:id";
            $this->db->query($query)
                ->bind('status', $data['update_status'])
                ->bind('id', $data['id'])
                ->execute();
        }
        return $this->db->affectedRows();
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM transaksi where id=:id')->bind('id', $id)->execute();
        return $this->db->affectedRows();
    }
}
