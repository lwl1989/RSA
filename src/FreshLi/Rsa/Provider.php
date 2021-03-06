<?php
declare(strict_types = 1);
namespace FreshLi\Rsa;

class Provider
{
	private $_config;
	public function __construct(array $config)
	{
		$this->_config = $config;
	}
	/**
	 * 私钥加密
	 * @param string $data 要加密的数据
	 * @return string 加密后的字符串
	 */
	public function privateKeyEncode(string $data) : string
	{
		$this->_needKey('private_key');
		$private_key = openssl_pkey_get_private($this->_config['private_key']);
		$data = base64_encode($data);
		openssl_private_encrypt($data, $encrypted, $private_key);
		return !empty($encrypted)?base64_encode($encrypted):'';
	}
	/**
	 * 公钥加密
	 * @param string $data 要加密的数据
	 * @return string 加密后的字符串
	 */
	public function publicKeyEncode(string $data) : string
	{
		$this->_needKey('public_key');
		$public_key = openssl_pkey_get_public($this->_config['public_key']);
		$data = base64_encode($data);
		openssl_public_encrypt($data, $encrypted, $public_key);
		return !empty($encrypted)?base64_encode($encrypted):'';
	}
	/**
	 * 用公钥解密私钥加密内容
	 * @param string $data 要解密的数据
	 * @return string 解密后的字符串
	 */
	public function decodePrivateEncode(string $data) : string
	{
		$this->_needKey('public_key');
		$public_key = openssl_pkey_get_public($this->_config['public_key']);
		openssl_public_decrypt(base64_decode($data), $decrypted, $public_key);
		return !empty($decrypted)?base64_decode($decrypted):''; //把拼接的数据base64_decode 解密还原
	}
	/**
	 * 用私钥解密公钥加密内容
	 * @param string $data  要解密的数据
	 * @return string 解密后的字符串
	 */
	public function decodePublicEncode(string $data) : string
	{
		$this->_hasKey('private_key');
		$private_key = openssl_pkey_get_private($this->_config['private_key']);
		$data = base64_decode($data);
		openssl_private_decrypt($data, $decrypted, $private_key); //私钥解密
		return !empty($decrypted)?base64_decode($decrypted):'';
	}
	/**
	 * 检查是否 含有所需配置文件
	 * @param string $key public_key 公钥 private_key 私钥
	 * @return bool
	 * @throws \Exception
	 */
	private function _hasKey(string $key = 'public_key') : bool
	{
	        if(!isset($this->_config[$key])) {
                        throw new \Exception('请配置密匙');
                }
		return true;
	}
}
