<?php

namespace core;

use core\Singleton;

class Crypto {

    use Singleton;

    private $method = 'AES-128-CBC';
    private $hash = 'sha256';
    private $hacheLength = 36;

    public function encrypt($str) {

        $ivlen = openssl_cipher_iv_length($this->method);

        $iv = openssl_random_pseudo_bytes($ivlen);

        $cipherText = openssl_encrypt($str, $this->method, CRYPT_KEY,
            OPENSSL_RAW_DATA, $iv);

        $hmac = hash_hmac($this->hash, $cipherText, CRYPT_KEY, true);

        return $this->cryptCombine($cipherText, $iv, $hmac);

    }

    public function decrypt($str) {

        $ivlen = openssl_cipher_iv_length($this->method);

        $crypt_data = $this->cryptUnCombine($str, $ivlen);

        $originalText = openssl_decrypt($crypt_data['str'], $this->method, CRYPT_KEY,
            OPENSSL_RAW_DATA, $crypt_data['iv']);

        $calcmac = hash_hmac($this->hash, $crypt_data['str'], CRYPT_KEY, true);

        if (hash_equals($crypt_data['hmac'], $calcmac)) return $originalText;

        return false;

    }

    private function cryptCombine($str, $iv, $hmac) {

        $new_str = '';

        $len = strlen($str);

        $counter = (int) ceil(strlen(CRYPT_KEY) / ($len + $this->hacheLength));

        $progress = 1;

        if ($counter >= $len) $counter = 1;

        for ($i = 0; $i < $len; $i++) {
            if ($counter < $len) {
                if ($i === $counter) {
                    $new_str .= substr($iv, $progress - 1, 1);
                    $progress++;
                    $counter += $progress;
                }
            } else {
                break;
            }

            $new_str .= substr($str, $i, 1);
        }

        $new_str .= substr($str, $i);

        $new_str .= substr($iv, $progress - 1);

        $new_str_half = (int) ceil(strlen($new_str) / 2);

        $new_str = substr($new_str, 0, $new_str_half) . $hmac . substr($new_str, $new_str_half);

        return base64_encode($new_str);

    }

    private function cryptUnCombine($str, $ivlen) {

        $crypt_data = [];

        $str = base64_decode($str);

        $hash_position = (int) ceil(strlen($str) / 2 - $this->hacheLength / 2);

        $crypt_data['hmac'] = substr($str, $hash_position, $this->hacheLength);

        $str = str_replace($crypt_data['hmac'], '', $str);

        $counter = (int) ceil(strlen(CRYPT_KEY) / (strlen($str) - $ivlen + $this->hacheLength));

        $progress = 2;

        $crypt_data['str'] = '';
        $crypt_data['iv'] = '';

        for ($i = 0; $i < strlen($str); $i++) {
            if ($ivlen + strlen($crypt_data['str']) < strlen($str)) {
                if ($counter === $i) {
                    $crypt_data['iv'] .= substr($str, $counter, 1);
                    $progress++;
                    $counter += $progress;
                } else {
                    $crypt_data['str'] .= substr($str, $i, 1);
                }
            } else {
                $len = strlen($crypt_data['str']);
                $crypt_data['str'] .= substr($str, $i, strlen($str) - $ivlen - $len);
                $crypt_data['iv'] = substr($str, $i + (strlen($str) - $ivlen - $len));
                break;
            }
        }

        return $crypt_data;

    }

}