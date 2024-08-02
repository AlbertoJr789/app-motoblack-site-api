<?php

namespace App\Enum;

enum AgenteStatus: int {
    case Unavailable = 0;
    case Available = 1;
    case Driving = 2;
}

 