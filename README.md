# RSA
一个PHP生成RSA加密和解密的包

###示例（example）

	namespace example;
	use FreshLi\Rsa\RSAGenerate;
	use FreshLi\Rsa\Provider;
	
	class Example{
	
		public function login()
		{
			  $serverProvider = new Provider(['private_key' =>$_SESSION['private_key']]);
			  $password = $serverProvider->decodePublicEncode($password);
			  var_dump($password);
			  //todo: do login
		}
	
		public function getPublicKey()
		{
			$rsaGenerate = new RSAGenerate();
			$publicKey = $rsaGenerate->getPublicKey();
			$_SESSION['private_key'] = $rsaGenerate->getPrivateKey();
			echo json_encode(['publicKey'=>$publicKey]);
		}
	
		public function test()
		{
			$rsa = new RSAGenerate();
			$publicKey = $rsa->getPublicKey();
			$privateKey = $rsa->getPrivateKey();
			$serverProvider = new Provider(['public_key'=>$publicKey,'private_key'=>$privateKey]);
			$pass =  $serverProvider->publicKeyEncode('12345');
			$pass = $serverProvider->decodePublicEncode($pass);
			echo $pass;
		}
	}
	
	
####author
email:13352019331@163.com


