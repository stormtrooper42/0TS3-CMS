<?php 
namespace App;

class Login{

	private $cnx;

	public function __construct($cnx){
		$this->cnx = $cnx;
	}

	public function check_login($username, $password){
	$req = $this->cnx->prepare('SELECT * FROM users WHERE (pseudo = :pseudo OR email = :pseudo)');
    $req->execute(array('pseudo' => $username));
    $user = $req->fetch();
		if(!empty($user)){
			if(password_verify($password, $user['password'])){
		        $_SESSION['auth'] = $user;
				$_SESSION['flash']['success'] = 'You\'re now connected !';
				return true;
			}else{
				$_SESSION['flash']['danger'] = 'Wrong username or password';
				return false;
			}
		}else{
			$_SESSION['flash']['danger'] = 'Wrong username or password';
			return false;
		}
	}




}








