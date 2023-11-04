<?php

namespace App\Traits;

trait EncryptionPassphrase
{
    private string $aes_method = 'aes-256-cbc';

    public function encrypt($message, $password): string
    {
        if (OPENSSL_VERSION_NUMBER <= 268443727) {
            throw new RuntimeException('OpenSSL Version too old, vulnerability to Heartbleed');
        }

        $iv_size        = openssl_cipher_iv_length($this->aes_method);
        $iv             = openssl_random_pseudo_bytes($iv_size);
        $ciphertext     = openssl_encrypt($message, $this->aes_method, $password, OPENSSL_RAW_DATA, $iv);
        $ciphertext_hex = bin2hex($ciphertext);
        $iv_hex         = bin2hex($iv);
        return "$iv_hex:$ciphertext_hex";
    }

    public function decrypt($ciphered, $password): string
    {
        $data       = explode(":", $ciphered);
        $iv         = hex2bin($data[0]);
        $ciphertext = hex2bin($data[1]);
        return openssl_decrypt($ciphertext, $this->aes_method, $password, OPENSSL_RAW_DATA, $iv);
    }
}
