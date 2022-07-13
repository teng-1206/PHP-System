<?php

    class Cryptography {

        protected $encrypt_method;
        protected $secret_key;
        protected $secret_iv;
        protected $key;
        protected $iv;

        public function __construct() {
            $this->set( 'encrypt_method', 'AES-256-CBC' );
            $this->set( 'secret_key', 'system' );
            $this->set( 'secret_iv', 'system' );
            $this->set( 'key', hash( 'sha256', $this->get( 'secret_key' ) ) );
            $this->set( 'iv', substr( hash( 'sha256', $this->get( 'secret_iv' ) ), 0, 16 ) );
        }

        public function hash( $string ) {
            $encrypt_string = $this->encrypt( $string );
            $hash_string = md5( $encrypt_string );
            return $hash_string;
        }

        public function encrypt( $string ) {
            return base64_encode( 
                openssl_encrypt(
                    $string,
                    $this->get( 'encrypt_method' ),
                    $this->get( 'key' ),
                    0,
                    $this->get( 'iv' )
                )
            );
        }

        public function decrypt( $string ) {
            return openssl_decrypt(
                base64_decode( $string ),
                $this->get( 'encrypt_method' ),
                $this->get( 'key' ),
                0,
                $this->get( 'iv' )
            );
        }

        public function get( String $attribute ) {
            switch ( $attribute ) {
                case 'encrypt_method':
                    return $this->encrypt_method;
                    break;
                case 'secret_key':
                    return $this->secret_key;
                    break;
                case 'secret_iv':
                    return $this->secret_iv;
                    break;
                case 'key':
                    return $this->key;
                    break;
                case 'iv':
                    return $this->iv;
                    break;
                default:
                    break;
            }
        }

        public function set( String $attribute, $value ) {
            switch ( $attribute ) {
                case 'encrypt_method':
                    $this->encrypt_method = $value;
                    break;
                case 'secret_key':
                    $this->secret_key = $value;
                    break;
                case 'secret_iv':
                    $this->secret_iv = $value;
                    break;
                case 'key':
                    $this->key = $value;
                    break;
                case 'iv':
                    $this->iv = $value;
                    break;
                default:
                    break;
            }
        }
    }

?>