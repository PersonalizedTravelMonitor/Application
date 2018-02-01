<?php

namespace App;

class Utils {

    public static function renameKey($array, $oldkey, $newkey) {
        if (!isset($array[$oldkey])) {
            return $array;
        }

        $array[$newkey] = $array[$oldkey];
        unset($array[$oldkey]);

        return $array;
    }

}
