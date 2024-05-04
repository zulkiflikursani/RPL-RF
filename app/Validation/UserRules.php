<?php

namespace App\Validation;

use App\Models\ModelPengguna;
use App\Models\ModelRegistrasi;
use App\Models\UserModel;


class UserRules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new ModelRegistrasi();
        $user = $model->where('email', $data['username'])->first();

        if (!$user) {
            $model = new ModelPengguna();
            $user = $model->where('email', $data['username'])->first();
            if (!$user) {
                return false;
            }
        } else {
            if (password_verify($data['userpassword'], $user['ktkunci'])) {
                return $user;
            } else {
                $password = md5($data['userpassword']);
                $user = $model->where("email", $data['username'])->where('ktkunci', $password)->first();
                if ($user != null) {
                    return $user;
                } else {
                    return false;
                }
            }
        }

        // return strcmp($data['userpassword'], $user['ktkunci']);
    }

    public function validateEmail(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('email', $data['useremail'])->first();

        if (!$user) {
            return false;
        } else {
            return true;
        }
    }
}
