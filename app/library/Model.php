<?php

namespace app\library;

class Model
{
    public $db;

    public function __construct() {
        $this->db = new Db();
    }
}