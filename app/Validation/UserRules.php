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
        }

        return password_verify($data['userpassword'], $user['ktkunci']);
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