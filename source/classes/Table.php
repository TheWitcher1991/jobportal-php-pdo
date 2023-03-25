<?php

namespace core;

use core\Singleton;

class Table {

    use Singleton;

    public function draw($type, array $columns) {

        $html = "";

        if (!$type || !$columns) {
            return false;
        }

        if ($type == 'company') {



        }

        return $html;

    }

}

?>