<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('includeFilesInFolder')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeFilesInFolder($folder)
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('includeRouteFiles')) {

    /**
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        includeFilesInFolder($folder);
    }
}

if (!function_exists('validateDocument')) {

    /**
     * @param $folder
     */
    function validateDocument($doc, $type)
    {
        try {
            switch ($type) {
                case 1: {
                        $doc = preg_replace('/[^0-9]/', '', $doc);

                        $v1 = 0;
                        $v2 = 0;
                        $aux = false;

                        for ($i = 1; $i < strlen($doc); $i++) {
                            if ($doc[$i - 1] != $doc[$i]) {
                                $aux = true;
                            }
                        }

                        if (!$aux) {
                            return false;
                        }

                        for ($i = 0, $p = 10; $i < (strlen($doc) - 2); $i++, $p--) {
                            $v1 += $doc[$i] * $p;
                        }

                        $v1 = (($v1 * 10) % 11);

                        if ($v1 == 10) {
                            $v1 = 0;
                        }

                        if ($v1 != $doc[9]) {
                            return false;
                        }

                        for ($i = 0, $p = 11; $i < (strlen($doc) - 1); $i++, $p--) {
                            $v2 += $doc[$i] * $p;
                        }

                        $v2 = (($v2 * 10) % 11);

                        if ($v2 == 10) {
                            $v2 = 0;
                        }

                        return $v2 == $doc[10];
                    }
                case 2: {
                        $doc = preg_replace('/[^0-9]/', '', $doc);

                        $v1 = 0;
                        $v2 = 0;
                        $aux = false;

                        for ($i = 1; $i < strlen($doc); $i++) {
                            if ($doc[$i - 1] != $doc[$i]) {
                                $aux = true;
                            }
                        }

                        if (!$aux) {
                            return false;
                        }

                        for ($i = 0, $p1 = 5, $p2 = 13; $i < (strlen($doc) - 2); $i++, $p1--, $p2--) {
                            if ($p1 >= 2) {
                                $v1 += $doc[$i] * $p1;
                            } else {
                                $v1 += $doc[$i] * $p2;
                            }
                        }

                        $v1 = ($v1 % 11);

                        if ($v1 < 2) {
                            $v1 = 0;
                        } else {
                            $v1 = (11 - $v1);
                        }

                        if ($v1 != $doc[12]) {
                            return false;
                        }

                        for ($i = 0, $p1 = 6, $p2 = 14; $i < (strlen($doc) - 1); $i++, $p1--, $p2--) {
                            if ($p1 >= 2) {
                                $v2 += $doc[$i] * $p1;
                            } else {
                                $v2 += $doc[$i] * $p2;
                            }
                        }

                        $v2 = ($v2 % 11);

                        if ($v2 < 2) {
                            $v2 = 0;
                        } else {
                            $v2 = (11 - $v2);
                        }

                        return $v2 == $doc[13];
                    }
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    if (!function_exists('haversine')) {      
        /** 
         * Calculates the aproximate distance between two coordinates considering earths geometric form
            a = sin²(φB - φA/2) + cos φA * cos φB * sin²(λB - λA/2)
            c = 2 * atan2( √a, √(1−a) )
            d = R ⋅ c 

            R = earth's median radius

            A = (-20.4607863, -45.4265978)
            B = (-20.4579654, -45.4252579)
            C = (-20.4604747, -45.4252128)

        */
        // function haversine($latX,$longX,$latY,$longY){
        //     $R = 6371; 
        //     $start =  microtime(true);

        //     [$phiX,$phiY] = [deg2rad($latX),deg2rad($latY)];
        //     [$lambdaX,$lambdaY] = [deg2rad($longX),deg2rad($longY)];
        //     [$deltaPhi,$deltaLambda] = [$phiY - $phiX,$lambdaY - $lambdaX];

        //     $a = pow(sin($deltaPhi/2),2) + cos($phiX) * cos($phiY) * pow(sin($deltaLambda/2),2);
        //     $c = 2 * atan2(sqrt($a),sqrt(1-$a));
        //     $d = $R * $c;
        //     echo microtime(true) - $start;

        //     return $d;
        // }

        /** 
         * '( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) *sin( radians(     latitude ))) 
         *   
         *  @return float - distance in KM
         *  $latX, $longX - Destiny
         *  $latY,$longY - Origin ( what would be inside of '?' in the formula above)
         *  
         * */
        function haversine($latX,$longX,$latY,$longY){
            [$phiX,$phiY] = [deg2rad($latX),deg2rad($latY)];
            [$lambdaX,$lambdaY] = [deg2rad($longX),deg2rad($longY)];

            $d = 6371 * acos( cos($phiY) * cos($phiX) * cos($lambdaX - $lambdaY) + sin($phiY) * sin($phiX));
            return $d;
        }


    }


    if(!function_exists('location')){    
        function location(){
            try {
                $ip = request()->getClientIp();
                $ip = $ip == '127.0.0.1' ? "" : $ip;
                return (object) Http::get("http://ip-api.com/json/".$ip)->json();
            } catch (\Throwable $th) {
                return null;
            }
        }
    }

}
