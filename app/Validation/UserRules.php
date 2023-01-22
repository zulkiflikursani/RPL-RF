<?php

namespace App\Validation;
use App\Models\UserModel;

class UserRules{
    public function validateUser(string $str, string $fields, array $data){
        $model = new UserModel();
        $user = $model->where('email', $data['username'])->first();
        
        if(!$user)
            return false;
          
        return password_verify($data['userpassword'], $user['password']);
        // return strcmp($data['userpassword'], $user['password']);
    }

    public function validateEmail(string $str, string $fields, array $data){
        $model = new UserModel();
        $user = $model->where('email', $data['useremail'])->first();
        
        if(!$user){
            return false;
        } else{
            return true;
        }
    }
}