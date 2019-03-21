<?php

namespace app\models;

use app\library\Model;

class UserModel extends Model
{
    public function create($data)
    {
        $this->db->query('INSERT INTO users VALUES (NULL, :name, :email, :territory);', $data);
    }

    public function getUserByEmail($email)
    {
        $params = [
            'email' => $email
        ];

        return $this->db->line('SELECT * FROM users WHERE email = :email;', $params);
    }
}

