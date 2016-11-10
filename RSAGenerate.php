<?php
namespace FreshLi\rsa;


class RSAGenerate {

        private $_publicKey = '';
        private $_privateKey = '';

        protected $_config = [];
        function __construct(array $config = [],bool $autoGenerate = true)
        {
                $this->_config = empty($config) ? array(
                        "private_key_bits" => 1024,
                        "private_key_type" => OPENSSL_KEYTYPE_RSA,
                ) : $config;
                if($autoGenerate) {
                        $this->generate();
                }
        }

        /**
         * @return RSAGenerate
         */
        public function generate() : RSAGenerate
        {
                $r = openssl_pkey_new($this->_config);
                openssl_pkey_export($r, $this->_privateKey);
                $rp = openssl_pkey_get_details($r);
                $pubKey = $rp['key'];
                $this->_publicKey = $pubKey;
                return $this;
        }

        /**
         * @return resource|string
         */
        public function getPublicKey()
        {
                return $this->_publicKey;
        }

        /**
         * @return string
         */
        public function getPrivateKey(): string
        {
                return $this->_privateKey;
        }

}
