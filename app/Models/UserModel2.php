<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel2 extends Model
{
    function logged_id()
    {
        if (session()->get('username') == null) {
            return false;
        } else {
            return session()->get('username');
        };
    }

    protected $table      = 'tb_pengguna';
    protected $allowedFields = ['idpengguna', 'nmpengguna', 'sttpengguna', 'email', 'ktkunci', 'kd_prodi', 'tglbuat', 'tglubah'];
    protected $primaryKey = 'idpengguna';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}