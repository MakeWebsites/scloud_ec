<?php

class dbconnect {
    //Create the connection witrh the external database
        private $Host;
	private $DBName;
	private $DBUser;
	private $DBPassword;
	private $pdo;
        private $connectionStatus = false;
        private $message;
    
    public function __construct($Host, $DBName, $DBUser, $DBPassword)
	{
        $this->Host       = $Host;
	$this->DBName     = $DBName;
	$this->DBUser     = $DBUser;
	$this->DBPassword = $DBPassword;
	$this->Connect();
	}
        
    private function Connect()
	{
		try {
			$dsn = 'mysql:';
			$dsn .= 'host=' . $this->Host . ';';
                        $dsn .= 'dbname=' . $this->DBname . ';';
			$dsn .= 'charset=utf8;';
		$this->pdo = new PDO($dsn,
				$this->DBUser, 
				$this->DBPassword);
                        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connectionStatus = true; 
                        $this->message = 'Connected!!';
		}
                
                catch (PDOException $e){ $this->message = $e->getMessage();}
        }
        
    public function CStatus() {
        return $this->connectionStatus;
    }
    
    public function Cmessage() {
        return $this->message;
    }
}
