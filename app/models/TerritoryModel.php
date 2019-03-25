<?php

namespace app\models;

use app\library\Model;

class TerritoryModel extends Model
{
    public function getRegions()
    {
        return $this->db->row("SELECT DISTINCT SUBSTRING_INDEX(ter_address, ',', -1) AS region FROM `t_koatuu_tree` WHERE ter_pid IS NOT NULL;");
    }

    public function getAreas($region)
    {
        $params = [
            'region' => "%, $region",
        ];

        return $this->db->row("SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(ter_address, ',', 2), ',', -1) AS area FROM `t_koatuu_tree` WHERE ter_pid IS NOT NULL AND ter_address LIKE :region", $params);
    }

    public function getCities($area)
    {
        $params = [
            'area' => "%, $area,%",
        ];

        return $this->db->row("SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(ter_address, ',', 1), ',', -1) AS city FROM `t_koatuu_tree` WHERE ter_pid IS NOT NULL AND ter_address LIKE :area", $params);
    }
}

