<?php
/**
 * @name Session Model
 *
 * DengruDiscuss
 * --------------
 * @author dennis
 *
 */

class Session extends DengruDiscuss {
		
	public $user_is_logged_in = false;
	public $user_is_admin = false;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		//$this->password = $this->loadModel('Password');
		
		$this->doStartSession();
		$this->performUserLoginAction();
		
	}
	
	
	private function performUserLoginAction() {
		if (!empty($_SESSION['username']) && ($_SESSION['user_is_logged_in'])) {
			$this->doLoginWithSessionData();
		}
		else if (isset($_POST['login'])) {
			$this->doLoginWithPostData();
		}
	}
	
	private function doStartSession() {
		session_start();
	}
	
	protected function doLoginWithSessionData() {
		$this->user_is_logged_in = true;
	}
	
	public function doLoginWithPostData() {
		if ($this->validate_login()) {
			$this->validate_user();
		}
	}
	
	public function doLogout() {
		$_SESSION = array();
		session_destroy();
		$this->user_is_logged_in = false;
		$this->user_is_admin = false;
	}
	
	public function isLoggedIn() {
		return $this->user_is_logged_in;
	}
	
	public function isAdmin() {
		if (isset($_SESSION['user_is_admin'])) {
			return true;
		}
	}
	
	
	/**
	 * Validate User
	 */
	public function validate_user() {		
		$sql = 'SELECT username, password, role FROM dd_users WHERE username = :username LIMIT 1';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':username', $_POST['username']);
		$stmt->execute();
		
		$this->password = $this->loadModel('Password');
		$res = $stmt->fetchObject();
		if ($res) {
			if ($this->password->verify($_POST['password'], $res->password)) {
				$_SESSION['username'] = $res->username;
				$_SESSION['user_is_logged_in'] = true;
	
				$this->user_is_logged_in = true;
	
				// check if user is admin
				if ($res->role == '1') {
					$_SESSION['user_is_admin'] = true;
					$this->user_is_admin = true;
				}

				return true;
			}
		}
	
		return false;
	}
	
	
	
	/**
	 * Check Login Form Data
	 */
	public function validate_login() {
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			return true;
		}
		else if (empty($_POST['username'])) {
			echo 'Username field empty';
		}
		else if (empty($_POST['password'])) {
			echo 'Password field empty';
		}
	
		return false;
	}
}

?>