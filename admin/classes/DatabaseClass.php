<?php 
/*
=========
PDO Class
author: Philip Brown (customized by @choquo)
url: http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/
==============================================================
*/

class Database{

    private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;
    private $dbh; //db handler
    private $error;
    private $stmt; //statement

    //__construct es codigo que se ejecuta apenas se inicia una nueva instancia de class Database, por lo que sirve para inicializar parametros que se utilizarán a lo largo de la ejecución
    //Este ejemplo es bastante bueno con respecto a programación Orientada a Objetos.
    public function __construct(){
        // Set DSN (Database Source Name) for MySQL databases
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname.';charset=utf8';
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_EMULATE_PREPARES, false //http://waynewhitty.ie/blog-post.php?id=20 |  http://php.net/manual/es/pdo.setattribute.php
        );
        /* UTF8 IMPORTANT NOTE:
		SOME SERVERS REQUIRE SET UTF8 THIS WAY
		$dbHandle = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass,
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")); READ MORE HERE: http://stackoverflow.com/questions/7822461/pdo-utf-8-character-issue*/

        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
            echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
        }
    }


	public function query($query){
		try {
			$this->stmt = $this->dbh->prepare($query);	
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function bind($param, $value, $type = null){
	    if (is_null($type)) {
	        switch (true) {
	            case is_int($value):
	                $type = PDO::PARAM_INT;
	                break;
	            case is_bool($value):
	                $type = PDO::PARAM_BOOL;
	                break;
	            case is_null($value):
	                $type = PDO::PARAM_NULL;
	                break;
	            default:
	                $type = PDO::PARAM_STR;
	        }
	    }
	    try {
	    	$this->stmt->bindValue($param, $value, $type);	
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function execute(){
		try {
			return $this->stmt->execute();
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	
	public function getAll(){ //originalmente: public function resultset(){
		try {
		    $this->execute();
		    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function getOne(){
		try {
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function rowCount(){
		try {
			return $this->stmt->rowCount();
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function lastInsertId(){
		try {
			return $this->dbh->lastInsertId();
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	/*TRANSACTIONS*/
	public function beginTransaction(){
		try {
			return $this->dbh->beginTransaction();	
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function endTransaction(){
		try {
			return $this->dbh->commit();	
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}


	public function cancelTransaction(){
		try {
			return $this->dbh->rollBack();
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}	


	public function debugDumpParams(){
		try {
			return $this->stmt->debugDumpParams();	
		} catch (Exception $e) {
			echo '<div style="background: #e72929; color: #fff; padding: 10px; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);">An error has ocurred: '.$e->getMessage().' <pre>'.$e->getTraceAsString().'</pre> </div>';
		}
	}
}
?>