<?php
	session_start();

	final class driver{
		var $client=array();

		function setClientId($clientid){
			if($clientid){
				$this->client['clientid']=$clientid;
				return true;
			}
			else
				return false;
		}

		function setClientSecret($clientsecret){
			if($clientsecret){
				$this -> client['clientsecret']=$clientsecret;
				return true;
			}
			else{
				return false;
			}
		}

		function setRedirectURL($redirecturl){
			if($redirecturl){
				$this -> client['redirecturl']=$redirecturl;
				return true;
			}
			else{
				return false;
			}
		}

		function setScope($scope){
			if($scope){
				$this -> client['scope']=$scope;
				return true;
			}
			else{
				return false;
			}
		}

		function createAuthURL(){
			if($this -> client['clientid'] && $this -> client['clientsecret'] && $this -> client['redirecturl'] && $this -> client['scope']){
				return "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=".$this -> client['clientid']."&redirect_uri=".$this -> client['redirecturl']."&scope=".$this -> client['scope']."";
			}
			else{
				return false;
			}
		}
	}

?>