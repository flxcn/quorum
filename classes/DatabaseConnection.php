<?php
// Error settings
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
ini_set('log_errors',1);
error_reporting(E_ALL);

// Define properties for database
define('DB_HOST','localhost');
define('DB_NAME','quorum');
define('DB_CHARSET','utf8mb4');
define('DB_USERNAME','root');
define('DB_PASSWORD','root');

// Define constants for voting purposes
define("MAX_YEA_DELEGATE_BALLOTS",7);
define("MAX_YEA_CAUCUS_BALLOTS",6);

// Set timezone
date_default_timezone_set('America/New_York');

class DatabaseConnection
{
    protected static $instance;
    protected $pdo;

    public function __construct() {
			$options = [
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES   => false,
			];
      $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
      $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
    }

    public static function instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->pdo, $method), $args);
    }

    public function getPDO()
	{
		return $this->pdo;
	}
}
?>
