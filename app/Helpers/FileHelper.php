<?php

namespace App\Helpers;

class FileHelper
{
    private const SECRET_KEY = 'your-secret-key-123456'; // Change this to a secure key

    public static function encodeFilename(string $filename): string
    {
        return base64_encode(
            openssl_encrypt(
                $filename,
                'AES-256-CBC',
                self::SECRET_KEY,
                OPENSSL_RAW_DATA,
                substr(self::SECRET_KEY, 0, 16)
            )
        );
    }

    public static function decodeFilename(string $encoded): string
    {
        try {
            return openssl_decrypt(
                base64_decode($encoded),
                'AES-256-CBC',
                self::SECRET_KEY,
                OPENSSL_RAW_DATA,
                substr(self::SECRET_KEY, 0, 16)
            );
        } catch (\Exception $e) {
            return 'Unknown File';
        }
    }
}
