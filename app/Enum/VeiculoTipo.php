<?php

namespace App\Enum;

enum VeiculoTipo: int {
    case Motorcycle = 1;
    case Car = 2;
    public function description(){
        return match($this){
            self::Motorcycle => __('Motorcycle'),
            self::Car => __('Car'),
        };
    }
}