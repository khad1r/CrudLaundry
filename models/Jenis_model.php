<?php

class Jenis_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function get()
    {
        $this->db->query('SELECT * FROM jenis');
        return $this->db->resultSet();
    }
    public function setPrice($data)
    {
        $total_score = $data[0];
        foreach ($total_score as $key => &$value) {
            $value = array_sum(array_column($data, $key)) / count($data);
            $this->db->query('UPDATE skor SET skor =:skor WHERE kode=:kode')
                ->bind('skor', $value)
                ->bind('kode', $key)
                ->execute()
                ->affectedRows();
        }
        return $total_score;
    }
    public function resetScore()
    {
        return $this->db->query('UPDATE skor SET skor = null')->execute()->affectedRows();
    }
}
