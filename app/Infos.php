<?php
namespace App;

class Infos{
	private $cnx;

	public function __construct($cnx){
		$this->cnx = $cnx;
	}

	public function getPort($username){
		$req = $this->cnx->prepare("SELECT port FROM servers WHERE username = :username");
		$req->execute(array('username' => $username));
		$port = $req->fetch();
		return $port['port'];
		
	}

	public function getSlots($username){
		$req = $this->cnx->prepare("SELECT slots FROM servers WHERE username = :username");
		$req->execute(array('username' => $username));
		$port = $req->fetch();
		return $port['slots'];
	}
}