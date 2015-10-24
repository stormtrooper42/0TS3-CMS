<?php
namespace App;

class Keys{

	private $ts3_VirtualServer;

	public function __construct($ts3_VirtualServer){
		$this->ts3_VirtualServer = $ts3_VirtualServer;

	}


	public function generate($key_type){
		if($key_type != "admin"){
			$_SESSION['flash']['danger'] = "You cannot perform this operation";
			header('Location: index.php');
			exit();
		}elseif($key_type == "admin"){
			$arr_ServerGroup = $this->ts3_VirtualServer->serverGroupGetByName("Server Admin");
			$ts3_PrivilegeKey = $arr_ServerGroup->privilegeKeyCreate();
			unset($_SESSION['keys']['admin']);
			$_SESSION['keys']['admin'] = "$ts3_PrivilegeKey";
			$_SESSION['flash']['success'] = "Privilege key created !";
			header("Location: index.php");
			exit();


		}

	}
}