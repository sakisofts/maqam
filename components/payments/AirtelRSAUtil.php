<?php

namespace app\components\payments;

use yii\base\Component;

/**
 * AirtelRSAUtil Service
 *
 * Provides RSA encryption functionality using OpenSSL for Airtel API integration.
 * This is the PHP equivalent of the Java com.servicecops.collections.helpers.AirtelRSAUtil class.
 *
 * Usage:
 *  $encrypted = AirtelRSAUtil::encrypt($data, $publicKeyPath);
 */
class AirtelRSAUtil extends Component
{
    // RSA encryption constants
    protected const DEFAULT_ENCRYPTION_ALGORITHM = 'RSA';
    protected const DEFAULT_TRANSFORMATION = 'RSA/ECB/PKCS1Padding';

    /**
     * Load and retrieve a public key from a PEM file path
     *
     * @param string $publicKeyPath Path to the PEM public key file
     * @return resource|false The OpenSSL public key resource or false on failure
     * @throws \Exception If file not found
     */
    public static function getPublicKeyFromFile(string $publicKeyPath)
    {
        if (!file_exists($publicKeyPath)) {
            throw new \Exception("Public key file not found: $publicKeyPath");
        }

        $publicKeyContent = file_get_contents($publicKeyPath);
        if ($publicKeyContent === false) {
            throw new \Exception("Failed to read public key file: $publicKeyPath");
        }

        $publicKey = openssl_pkey_get_public($publicKeyContent);
        if ($publicKey === false) {
            throw new \Exception('Failed to load public key: ' . openssl_error_string());
        }

        return $publicKey;
    }

    /**
     * Load a public key from a Base64-encoded string (Java equivalent)
     *
     * This method mirrors the Java getPublicKey() method which accepts a Base64-encoded key string.
     *
     * @param string $base64PublicKey Base64-encoded public key string
     * @return resource|false The OpenSSL public key resource or false on failure
     * @throws \Exception If key decoding or parsing fails
     */
    public static function getPublicKey(string $base64PublicKey)
    {
        try {
            // Decode the Base64 string
            $decodedKey = base64_decode($base64PublicKey, true);

            if ($decodedKey === false) {
                throw new \Exception('Failed to decode Base64 public key');
            }

            // Convert the DER-encoded key to PEM format
            $publicKeyPem = "-----BEGIN PUBLIC KEY-----\n"
                . wordwrap($base64PublicKey, 64, "\n", true)
                . "\n-----END PUBLIC KEY-----";

            // Load the public key
            $publicKey = openssl_pkey_get_public($publicKeyPem);

            if ($publicKey === false) {
                throw new \Exception('Failed to load public key: ' . openssl_error_string());
            }

            return $publicKey;
        } catch (\Exception $e) {
            throw new \Exception('Error processing public key: ' . $e->getMessage());
        }
    }

    /**
     * Encrypt data using RSA with PKCS1Padding
     *
     * This method mirrors the Java encrypt() method.
     * Equivalent to: Cipher.getInstance("RSA/ECB/PKCS1Padding")
     *
     * @param string $data The plaintext data to encrypt
     * @param string $publicKey The path to PEM file or Base64-encoded public key
     * @return string Base64-encoded encrypted data
     * @throws \Exception If encryption fails
     */
    public static function encrypt(string $data, string $publicKey): string
    {
        try {
            // Determine if $publicKey is a file path or Base64-encoded string
            $keyResource = self::loadPublicKeyResource($publicKey);

            // Encrypt the data using PKCS1 padding (equivalent to Java's PKCS1Padding)
            if (!openssl_public_encrypt($data, $encrypted, $keyResource, OPENSSL_PKCS1_PADDING)) {
                throw new \Exception('Encryption failed: ' . openssl_error_string());
            }

            // Return Base64-encoded encrypted data (same as Java Base64.getEncoder().encodeToString())
            return base64_encode($encrypted);
        } catch (\Exception $e) {
            throw new \Exception('RSA Encryption error: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to load public key resource from either a file path or Base64 string
     *
     * @param string $publicKey File path or Base64-encoded key string
     * @return resource OpenSSL public key resource
     * @throws \Exception If key cannot be loaded
     */
    private static function loadPublicKeyResource(string $publicKey)
    {
        // Try to load as file path first
        if (file_exists($publicKey)) {
            return self::getPublicKeyFromFile($publicKey);
        }

        // Otherwise treat as Base64-encoded string
        return self::getPublicKey($publicKey);
    }

    /**
     * Verify if a public key is valid
     *
     * @param string $publicKey File path or Base64-encoded key string
     * @return bool True if valid, false otherwise
     */
    public static function isValidPublicKey(string $publicKey): bool
    {
        try {
            $keyResource = self::loadPublicKeyResource($publicKey);
            return $keyResource !== false;
        } catch (\Exception $e) {
            return false;
        }
    }
}

