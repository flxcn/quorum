<?php
require_once "DatabaseConnection.php";

class Delegate {
    protected $pdo = null;
    private $delegate_id;
    private $first_name;
    private $last_name;
    private $caucus;    
    private $username;
    
    private $is_present;
    private $created_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    // getters and setters

    public function setDelegateId($delegate_id) {
        $this->delegate_id = $delegate_id;
    }

    public function getDelegateId() {
        return $this->delegate_id;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }
    public function getFirstName() {
        return $this->first_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }
    public function getLastName() {
        return $this->last_name;
    }
   
    public function setSchool($school) {
        $this->school = $school;
    }
    public function getSchool() {
        return $this->school;
    }

    public function setCaucus($caucus) {
        $this->caucus = $caucus;
    }
    public function getCaucus() {
        return $this->caucus;
    }


    public function setUsername(string $username): string
    {
        $stmt = $this->pdo->prepare('SELECT count(*) FROM delegates WHERE username = :username');
        $stmt->execute(['username' => strtolower($username)]);
        $same_usernames = $stmt->fetchColumn();
        if($same_usernames > 0)
        {
            return "This username is already taken.";
        }
        if(!filter_var($username, FILTER_VALIDATE_EMAIL))
        {
            return "This email address is not valid";
        } 
        else 
        {
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
   
   
    public function setIsPresent(bool $is_present) {
        $this->is_present = $is_present;
    }

    public function getIsPresent() {
        return $this->is_present;
    }
    
    public function setCreatedOn($created_on) {
        $this->created_on = $created_on;
    }
    
    public function getCreatedOn() {
        return $this->created_on;
    }

    // SIGN-IN METHODS

    // Set username
    public function setUsernameForSignIn(string $username): string {
        if(empty($username)) {
            return "Please enter your email address.";
        }
		if($this->checkUsernameExists(strtolower($username))) {
            $this->username = strtolower($username);
            return "";
		}
        else
        {
            return "No account found with that email.";
        }
    }

    // Check username exists
    private function checkUsernameExists($username): bool {
        $stmt = $this->pdo->prepare("SELECT 1 FROM delegates WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return (bool)$stmt->fetch();
    }

    // Sign in with username
    public function signIn(): bool
    {
        $sql = "SELECT first_name, last_name, delegate_id, caucus, username, is_present FROM delegates WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $this->username]);
        $delegate = $stmt->fetch();

        if ($delegate)
        {
            $this->delegate_id = $delegate["delegate_id"];
            $this->caucus = $delegate["caucus"];
            $this->first_name = $delegate["first_name"];
            $this->last_name = $delegate["last_name"];
            $this->is_present = $delegate["is_present"];

            return true;
        } 
        else 
        {
            return false;
        }
    }

    // Get Delegate by their email address (username)
    public function getDelegateByUsername() {
		$sql = "SELECT * FROM delegates WHERE username = :username";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['username' => $this->username]);
		$delegate = $stmt->fetch();

		if($status) {
  			return $delegate;
		}
		else {
			return null;
		}

    }

    public function updateDelegate() {
        $sql = 
            "UPDATE delegates 
            SET name = :name,
                email = :email,
            WHERE delegate_id = :delegate_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(
            [
                'name' => $this->name,
                'email' => $this->email,
                'delegate_id' => $this->delegate_id
            ]);

        return $status;
    }

    public function markPresent() {
        $sql = 
            "UPDATE delegates 
            SET is_present = 1
            WHERE delegate_id = :delegate_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(['delegate_id' => $this->delegate_id]);
        return $status;
    }

}
?>