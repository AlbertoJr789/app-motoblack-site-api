<?php

namespace App\Enum;

enum AgenteTipo: int {
    case Pilot = 1;
    case Driver = 2;
    public function description(){
        return match($this){
            self::Pilot => __('Pilot'),
            self::Driver => __('Driver'),
        };
    }
}