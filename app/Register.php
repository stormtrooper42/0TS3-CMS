<?php 
namespace App;

class Register{

	private $cnx;

	public function __construct($cnx){
		$this->cnx = $cnx;
	}

	public function check_pseudo($pseudo){
		 if (preg_match('/^[a-zA-Z0-9_]+$/', $pseudo) && strlen($pseudo) > 4 && strlen($pseudo) < 25) {
		 	$req = $this->cnx->prepare('SELECT id FROM users WHERE pseudo = :pseudo');
	        $req->execute(array("pseudo" => $pseudo));
	        $user = $req->fetch();
	        if($user){
	            $_SESSION['flash']['danger'] = "This username is already taken";
	        }else{
		    return $pseudo;
			}
		 } else {
		    $_SESSION['flash']['danger'] = "Your username must be between 4 and 25 alphanumeric characters";
		 }

	}

	public function check_email($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    $req = $this->cnx->prepare('SELECT id FROM users WHERE email = :email');
	        $req->execute(array("email" => $email));
	        $user = $req->fetch();
	        if($user){
	            $_SESSION['flash']['danger'] = "This email is already taken";
	        }else{
		    return $email;
			}
		}else{
			$_SESSION['flash']['danger'] = "Please enter a valid email";
		}
	}

	public function check_password($pass1, $pass2){
		if(empty($pass1) || $pass1 != $pass2){
			$_SESSION['flash']['danger'] = "Passwords do not match";
		}else{
			if(strlen($pass1) < 255){
				$password = password_hash($pass1, PASSWORD_BCRYPT);
				return $password;
			}else{
				$_SESSION['flash']['danger'] = "Your password must be less than 255 characters";
			}
		}
	}

	public function create_account($pseudo, $email, $password){
			$q = array('pseudo' => $pseudo, 'email' => $email, 'password' => $password);
			$req = $this->cnx->prepare("INSERT INTO users(pseudo, email, password) 
										VALUES (:pseudo, :email, :password)");
			$req->execute($q);
			$_SESSION['flash']['success'] = "Your account has been created !";
	}


}