<?php
namespace App\Constants;

class Priorities {
    public static function getPriorities(){
        return [
            0 => ['name' => 'Normal', 'label' => 'success'],
            1 => ['name'=>'Medium', 'label' => 'warning'],
            2 => ['name'=>'High', 'label' => 'danger'],
            3 => ['name'=>'Low', 'label' => 'info'],
        ];
    }
}