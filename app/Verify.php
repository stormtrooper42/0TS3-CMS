<?php 

namespace App;

class Verify{
	private $cnx;

	public function __construct($cnx){
		$this->cnx = $cnx;
	}


	public function checkTS($username){
		$req = $this->cnx->prepare("SELECT * FROM servers WHERE username = :username");
		$req->execute(array('username' => $username));
		$check = $req->fetch();
		if(!empty($check['port'])){
			$_SESSION['flash']['danger'] = "You already have 1 Free Teamspeak 3 server";
			header('Location: index.php');
			exit();
		}
	}

	public function checkIndex($username){
		$req = $this->cnx->prepare("SELECT * FROM servers WHERE username = :username");
		$req->execute(array('username' => $username));
		$check = $req->fetch();
		if(empty($check['port'])){
			$_SESSION['flash']['warning'] = "You need to create one free TS3 to view the manager";
			header('Location: create.php');
			exit();
		}
	}


}