<?php

	class SQLConnection{


		private $serverName = "wcv.c0iweg5fv44n.us-east-1.rds.amazonaws.com:";
		private $userName = "wcvuser";
		private $password = "DukeDog7";
		private $dB =  "wcv";
		private $dbport = "3306";

		//constructor
        function __construct() {

        }

        public function getServerName()
        {
            return $this->serverName;
        }

        public function setServerName($serverName)
        {
            $this->serverName = $serverName;
        }

        public function getUserName()
        {
            return $this->userName;
        }

        public function setUserName($userName)
        {
            $this->userName = $userName;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getDB()
        {
            return $this->dB;
        }

        public function setDB($dB)
        {
            $this->dB = $dB;
        }
		
			public function getDBPort()
		{
			return $this->dbport;
		}
		
		public function setDBPort($dbport)
		{
			$this->dbport = $dbport;
		}
		


        public function checkConnection()
        {
            //Create connection
            //$conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dB, $this->dbport);
			
            //Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            } else {
                //echo "Connected Successfully </br>";
            }
        }

        public function sendQuery($query)
        {
            
			//$conn = new mysqli($this->getServerName(), $this->getUserName(), $this->getPassword(), $this->getDB(),$this->getDBPort());
            $conn = $this->makeConn();
			$conn->query($query);
        }

        public function getResult($query)
        {
            
			//$conn = new mysqli($this->getServerName(), $this->getUserName(), $this->getPassword(), $this->getDB(),$this->getDBPort());
            $conn = $this->makeConn();
			$result = $conn->query($query);
            return $result;
        }

        public function getSTMT($query)
        {
            //$conn = new mysqli($this->getServerName(), $this->getUserName(), $this->getPassword(), $this->getDB(),$this->getDBPort());
            $conn = $this->makeConn();
			$stmt = $conn->query($query);
            return $stmt;
        }
		
		public function makeConn()
		{
			static $conn;
			$conn = new mysqli("wcv.c0iweg5fv44n.us-east-1.rds.amazonaws.com", "wcvuser", "DukeDog7","wcv", "3306");
			return $conn;
		}
	}
?>
