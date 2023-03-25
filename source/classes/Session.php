<?php

namespace Core;

use core\Singleton;

class Session {

    use Singleton;

    public function start() {
        session_start();
    }

    public function set(array $data) {
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $_SESSION[$key] = $val;
            }
        }
    }

    public function setData(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public function setCookie($key, $value, $time) {
        setcookie($key, $value, $time);
    }

    public function generateId() {
        session_regenerate_id();
    }

    public function getData(string $key) {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function save() {
        session_write_close();
    }

    public function flush(string $key) {
        $value = $this->getData($key);
        $this->unset($key);

        return $value;
    }

    private function unset(string $key) {
        unset($_SESSION[$key]);
    }
}