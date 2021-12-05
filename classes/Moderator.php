<?php
require_once "DatabaseConnection.php";

class Moderator {
    protected $pdo = null;
    private $moderator_id;
    private $first_name;
    private $last_name;
    private $conference_id;
    private $committee_id;
    
    private $username;
    private $password;
    
    private $is_enabled;
    private $created_on;
    //private $verification_code;
    private $last_active_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
        $this->conference_id = 1;
        $this->is_enabled = true;
	}

    // getters and setters

    public function setModeratorId($moderator_id) {
        $this->moderator_id = $moderator_id;
    }

    public function getModeratorId() {
        return $this->moderator_id;
    }

    public function setUsername(string $username): string
    {
        $stmt = $this->pdo->prepare('SELECT count(*) FROM moderators WHERE username = :username');
        $stmt->execute(['username' => strtolower($username)]);
        $same_usernames = $stmt->fetchColumn();
        if($same_usernames > 0){
            return "This username is already taken.";
        }
        if(!filter_var($username, FILTER_VALIDATE_EMAIL))
        {
            return "This email address is not valid";
        } else {
            $this->username = strtolower($username);
            return "";
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword(string $password): string {
        if(empty($password)) {
            return "Please enter a password.";
        }
        else {
            $this->password = $password;
            return "";
        }
    }

    public function getPassword() {
        return $this->password;
    }

    public function setConfirmPassword(string $confirm_password): string
    {
        if(empty($confirm_password)) {
            return "Please confirm password.";
        }

        if(strcmp($this->password,$confirm_password) != 0){
            return "Password did not match.";
        }

        $this->confirm_password = $confirm_password;
        return "";
    }
    
    public function setCreatedOn($created_on) {
        $this->created_on = $created_on;
    }
    
    public function getCreatedOn() {
        return $this->created_on;
    }
   
    // Create a new delegate, used in delegate/register.php
    public function addModerator() {
        $sql = "INSERT INTO moderators (username, password)
			VALUES (:username, :password)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'username' => $this->username,
				'password' => password_hash($this->password, PASSWORD_DEFAULT),
			]);

		return $status;
    }

    // SIGN-IN METHODS

    // Set username
    public function setUsernameForSignIn(string $username): string {
        if(empty($username)) {
            return "Please enter your username.";
        }
		if($this->checkUsernameExists(strtolower($username))) {
            $this->username = strtolower($username);
            return "";
		}
        else
        {
            return "No account found with that username.";
        }
    }

    // Check username exists
    private function checkUsernameExists($username): bool {
        $stmt = $this->pdo->prepare("SELECT 1 FROM moderators WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return (bool)$stmt->fetch();
    }

    // sign-in with username and password
    public function signIn(): bool
    {
        $sql = "SELECT moderator_id, username, password FROM moderators WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $this->username]);
        $moderator = $stmt->fetch();

        if ($moderator && password_verify($this->password, $moderator['password']))
        {
            $this->moderator_id = $moderator["moderator_id"];
            return true;
        } else {
        return false;
        }
    }

}
?>