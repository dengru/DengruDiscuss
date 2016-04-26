<?php
/**
 * @name User Model
 *
 * DengruDiscuss
 * --------------
 * @author dennis
 *
 */

class User extends DengruDiscuss {
	
	/**
	 * Constructor
	 */
	public function __construct() {
		//global $password;
				
		parent::__construct();
		
		define('PASSWORD_BCRYPT', 1);
		define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);

	}
	
	public function getUserName() {
		$sql = 'SELECT username FROM dd_users WHERE username = :username';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':username', $_SESSION['username']);
		$stmt->execute();
		
		$res = $stmt->fetchObject();
		if ($res) {
			return $res;
		}
	}
	
	public function getUserDetails() {
		$sql = 'SELECT * FROM dd_users WHERE username = :username';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':username', $_SESSION['username']);
		$stmt->execute();
		
		$res = $stmt->fetchObject();
		
		
		if ($res) {
			return $res;
		}
		//default return
		return false;
	}
	
	/**
	 * Update User Password
	 * @param unknown_type $password
	 */
	public function updateUserPassword() {
		
		$new_password = $_POST['password'];

		$this->password = $this->loadModel('Password');
		
		$phash = $this->password->encrypt($new_password, PASSWORD_BCRYPT, array('string','object','integer'));
		
		$sql = "UPDATE dd_users SET password = :phash WHERE username = :username";
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':phash', $phash);
		$stmt->bindValue(':username', $_SESSION['username']);
		$stmt->execute();
				
		// check if exactly one row was successfully changed
		$update_success = $stmt->execute();
		if ($update_success) {
			echo 'Password has been updated successfully.';
			return true;
		}
		else {
			echo 'Sorry, password change has failed.';
		}
	}
	
	/**
	 * Update User
	 */
	public function updateUser() {
	
		$email = $_POST['email'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$country = $_POST['country'];
	
		$sql = "UPDATE dd_users SET email = :email, firstname = :firstname, lastname = :lastname, country = :country WHERE username = :username";
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':username', $_SESSION['username']);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':firstname', $firstname);
		$stmt->bindValue(':lastname', $lastname);
		$stmt->bindValue(':country', $country);
		
		$update_success = $stmt->execute();
		if ($update_success) {
			echo 'Your account has been successfully updated';
			return true;
		}
		else {
			echo 'Sorry, account update has failed.';
		}
	}
	
	
	/**
	 * Create New User
	 * 
	 * @param array $newUserArray
	 */
	public function createNewUser() {

		$username = htmlentities($_POST['username'], ENT_QUOTES);
		$email = htmlentities($_POST['email'], ENT_QUOTES);
		$firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
		$lastname = htmlentities($_POST['lastname'], ENT_QUOTES);
		$country = htmlentities($_POST['country'], ENT_QUOTES);
		$password = $_POST['password'];
				
		// Check if the username or email address that was entered 
		// matches any username/email address that is already registered
		$sql = 'SELECT * FROM dd_users WHERE username = :username OR email = :email';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':username', $username);
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		
		$res = $stmt->fetchObject();
		if ($res) {
			echo 'Sorry, that username is already taken.';
		}
		else {
			// Validate the registration
			if ($this->validate_registration()) {
				
				// Load the password model
				$this->password = $this->loadModel('Password');

				// Encrypt the password
				$phash = $this->password->encrypt($password, PASSWORD_BCRYPT, array('string','object','integer'));
				
				try {
					$sql = 'INSERT INTO dd_users (username, email, firstname, lastname, country, role, password) VALUES(:username, :email, :firstname, :lastname, :country, :role, :password)';
					$stmt = parent::prepare($sql);
					$stmt->bindValue(':username', $username, PDO::PARAM_STR);
					$stmt->bindValue(':email', $email, PDO::PARAM_STR);
					$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
					$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
					$stmt->bindValue(':country', $country, PDO::PARAM_STR);
					$stmt->bindValue(':role', '2', PDO::PARAM_INT);
					$stmt->bindValue(':password', $phash, PDO::PARAM_STR);
					
					$registration_success = $stmt->execute();
					if ($registration_success) {
						echo 'Your account has been created successfully.';
						return true;
					}
					else {
						echo 'Sorry, the registration process has failed. Please try again.';
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
			return false;
			
		}
		//default return
		return false;
	}
	
	/**
	 * Validate Registration
	 */
	public function validate_registration() {
	
		if (!empty($_POST['username'])
				//check username field
				&& strlen($_POST['username']) <= 64
				&& strlen($_POST['username']) >= 2
				&& preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
				//check firstname field
				&& strlen($_POST['firstname']) <= 64
				&& strlen($_POST['firstname']) >= 2
				&& preg_match('/^[a-z\d]{2,64}$/i', $_POST['firstname'])
				//check lastname field
				&& strlen($_POST['lastname']) <= 64
				&& strlen($_POST['lastname']) >= 2
				&& preg_match('/^[a-z\d]{2,64}$/i', $_POST['lastname'])
				//check country field
				&& strlen($_POST['country']) <= 64
				&& strlen($_POST['country']) >= 2
				&& preg_match('/^[a-z\d]{2,64}$/i', $_POST['country'])
				//check email field
				&& !empty($_POST['email'])
				&& strlen($_POST['email']) <= 64
				&& filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
				//check password field
				&& !empty($_POST['password'])
				&& !empty($_POST['password2'])
				&& ($_POST['password'] == $_POST['password2'])
		) {
			return true;
	
		// Empty field validation
		} elseif (empty($_POST['username'])) {
			echo 'Empty username';
			
		} elseif (empty($_POST['password']) || empty($_POST['password2'])) {
			echo 'Empty Password';
			
		} elseif (empty($_POST['firstname'])) {
			echo 'Empty firstname';
			
		} elseif (empty($_POST['lastname'])) {
			echo 'Empty lastname';
			
		} elseif (empty($_POST['email'])) {
			echo 'Email cannot be empty';
			
		} elseif (empty($_POST['country'])) {
			echo 'Empty country';
		
		// Password match validation
		} elseif ($_POST['password'] !== $_POST['password2']) {
			echo 'Password repeats does not match!';
		
		// Length and scheme validation
		} elseif (strlen($_POST['password']) < 6) {
			echo 'Password has a minimum length of 6 characters';
			
		} elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 5) {
			echo 'Username cannot be shorter than 5 or longer than 64 characters';
			
		} elseif (strlen($_POST['firstname']) > 64 || strlen($_POST['firstname']) < 5) {
			echo 'Firstname cannot be shorter than 5 or longer than 64 characters';
			
		} elseif (!preg_match('/^[a-z\d]{5,64}$/i', $_POST['username'])) {
			echo 'Username does not fit the name scheme: only a-Z and numbers are allowed, 5 to 64 characters';
		
		} elseif (!preg_match('/^[a-z\d]{5,64}$/i', $_POST['firstname'])) {
			echo 'Firstname does not fit the name scheme: only a-Z and numbers are allowed, 5 to 64 characters';
				
		} elseif (!preg_match('/^[a-z\d]{5,64}$/i', $_POST['lastname'])) {
			echo 'Lastname does not fit the name scheme: only a-Z and numbers are allowed, 5 to 64 characters';
					
		} elseif (!preg_match('/^[a-z\d]{5,64}$/i', $_POST['country'])) {
			echo 'Country does not fit the name scheme: only a-Z and numbers are allowed, 5 to 64 characters';
					
		} elseif (strlen($_POST['email']) > 64) {
			echo 'Email cannot be longer than 64 characters';
			
		} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			echo 'Your email address is not in a valid email format';

		} elseif (strlen($_POST['firstname']) > 64 || strlen($_POST['firstname']) < 5) {
			echo 'Firstname cannot be shorter than 5 or longer than 64 characters';
			
		} elseif (strlen($_POST['lastname']) > 64 || strlen($_POST['lastname']) < 5) {
			echo 'Lastname cannot be longer than 64 characters';
		
		} elseif (strlen($_POST['country']) > 64 || strlen($_POST['country']) < 5) {
			echo 'Country cannot be longer than 64 characters';
				
		} else {
			echo 'An unknown error occurred.';
		}
	
		return false;
	}
	
	
}
?>