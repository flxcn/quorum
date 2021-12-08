<?php
require_once "DatabaseConnection.php";

class Delegate {
    protected $pdo = null;
    private $delegate_id;
    private $first_name;
    private $last_name;
    private $caucus_id;
    private $caucus_title;    
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

    public function setCaucusId($caucus_id) {
        $this->caucus_id = $caucus_id;
    }
    public function getCaucusId() {
        return $this->caucus_id;
    }

    public function setCaucusTitle($caucus_title) {
        $this->caucus_title = $caucus_title;
    }
    public function getCaucusTitle() {
        return $this->caucus_title;
    }

    // Check to see if a proposed username for Delegate registration is invalid or already taken
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

    // Set username for sign-in
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
        $sql = "SELECT first_name, last_name, delegate_id, delegates.caucus_id, username, is_present, title FROM delegates INNER JOIN caucuses ON delegates.caucus_id = caucuses.caucus_id WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $this->username]);
        $delegate = $stmt->fetch();

        if ($delegate)
        {
            $this->delegate_id = $delegate["delegate_id"];
            $this->caucus_id = $delegate["caucus_id"];
            $this->caucus_title = $delegate["title"];
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

    // Update an existing Delegate
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

    // Mark a specific Delegate as present for purposes of a quorum
    public function markPresent() {
        $sql = 
            "UPDATE delegates 
            SET is_present = 1
            WHERE delegate_id = :delegate_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(['delegate_id' => $this->delegate_id]);
        return $status;
    }

    // Return an array of current caucuses for use when registering a new Delegate 
    public function getCaucusesForDelegateRegistration(): ?string
	{
		$sql = "SELECT caucus_id, title FROM caucuses";

		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute();
		if(!$status) {
			return null;
		}
		else {
            // Format data for use in a select HTML element
			$caucuses = array();
			$caucuses[] = array("title" => 'Choose...', "caucus_id" => '');
			foreach ($stmt as $row)
			{
				$caucuses[] = array("title" => $row['title'], "caucus_id" => $row['caucus_id']);
			}
			$jsonCaucuses = json_encode($caucuses);
			return $jsonCaucuses;
		}
	}
}
?>