<?php
    class Cetak {
        static function pp($arr){
            $retStr = '<ul>';
            if (is_array($arr) || is_object($arr)){
                foreach ($arr as $key=>$val){
                    if (is_array($val) || is_object($val)){
                        $retStr .= '<li>' . $key . ' => ' . self::pp($val) . '</li>';
                    }else{
                        $retStr .= '<li>' . $key . ' => ' . $val . '</li>';
                    }
                }
            }
            $retStr .= '</ul>';
            return $retStr;
        }
    }
?>