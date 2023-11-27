<?php
namespace App\Constants;

class TaskTypes {
    public static function getTaskTypes(){
        return [
            1 => 'Adhoc',
            2 => 'Admin',
            3 => 'Coaching',
            4 => 'Meeting',
            5 => 'Operational support',
            6 => 'Project Management',
            7 => 'R & D',
        ];
    }
}