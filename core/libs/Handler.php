<?php
/**
 * @name Handler
 * 
 * DengruDiscuss
 * --------------
 * @author dennis
 *
 */

class Handler extends DengruDiscuss {
		
	public $pagetitle;
	public $sitename;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		
		$this->sitename = SITE_NAME;
		
		// Load models
		$this->session = $this->loadModel('Session');
		$this->user = $this->loadModel('User');	
		$this->forum = $this->loadModel('Forum');
		
		// Only load the admin model if the user is authorized as an administrator
		if ($this->session->isAdmin()) {
			$this->admin = $this->loadModel('Admin');
		}
	}
	
	/**
	 * Forum Index
	 */
	public function forumIndex() {
		$this->pagetitle = 'Home';
		//$this->categoryname = $this->forum->getCategoryNameById();

		$this->res = $this->forum->getCategories();
		
		$this->render('index');
	}
	
	/**
	 * Threads
	 */
	public function threads() {
		$this->categoryname = $this->forum->getCategoryName();
		$this->categorydesc = $this->forum->getCategoryDescription();
		$this->pagetitle = $this->categoryname;		
		$this->res = $this->forum->getThreads();
		
		$this->render('threads');
	}
	
	/**
	 * Thread
	 */
	public function thread() {
		$this->categoryname = $this->forum->getCategoryNameById();
		$this->threadname = $this->forum->getThreadName();
		$this->pagetitle = $this->threadname;	
		$this->res = $this->forum->getThread();
		
		$this->render('thread');
	}
	
	/**
	 * New Thread
	 */
	public function newThread() {
		if ($this->session->isLoggedIn()) {
			$this->categoryname = $this->forum->getCategoryNameById();
			$this->pagetitle = 'New Thread';
			
			$this->render('createthread');
			
			if (isset($_POST['create-thread'])) {
				$this->forum->createThread();
			}
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	/**
	 * Reply To Thread
	 */
	public function replyToThread() {
		if ($this->session->isLoggedIn()) {
			$this->threadname = $this->forum->getThreadName();
			$this->categoryname = $this->forum->getCategoryNameById();
			
			$this->pagetitle = 'Reply to thread: ' . $this->threadname;
				
			$this->render('createreply');
				
			if (isset($_POST['create-reply'])) {
				$this->forum->createReply();
			}
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	/**
	 * Edit Post
	 */
	public function editPost() {
		if ($this->session->isLoggedIn()) {
			$this->threadname = $this->forum->getThreadName();
			$this->categoryname = $this->forum->getCategoryNameById();
			$this->postauthor = $this->forum->getPostAuthor();
				
			$this->pagetitle = 'Editing reply of thread: ' . $this->threadname;
	
			// User wants to change password? OK, lets do it
			if (isset($_POST['update-post'])) {
				$this->forum->updatePost();
			}
			
			// Check if user is the owner to the post but also check if the user is not a admin
			if ($this->postauthor == $_SESSION['username'] && !$this->session->isAdmin()) {
				$this->vals = $this->forum->getPostById();
				$this->render('updatepost');
			// Check if user is a admin, if so then user can edit any post, not just his own
			} else if ($this->session->isAdmin()) {
				$this->vals = $this->forum->getPostByIdIfAdmin();
				$this->render('updatepost');
			}
			else {
				header('location: ' . CORE_URL);
			}
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	
	/**
	 * Login Handler
	 */
	public function login() {
		if ($this->session->isLoggedIn()) {
			header('location: ' . CORE_URL);
		}
		else {
			$this->pagetitle = 'Login';
			$this->render('login');// Render the login template
			
			$username = isset($_POST['username']);
			$password = isset($_POST['password']);
				
			if (isset($_POST['login'])) {
				$this->session->doLoginWithPostData($username, $password);
			}
		}
	}
	
	/**
	 * Register Handler
	 */
	public function register() {
		if (!$this->session->isLoggedIn()) {
			$this->pagetitle = 'Register';
			
			// Someone wants to register, huh? Let him do it, just make sure all the inputs where populated...
			if (isset($_POST['register']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['country']) && !empty($_POST['password'])) {
				// Check if passwords match eachother, then proceed to the user creation process
				$this->user->createNewUser();
			}
			
			$this->render('register');
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	public function logout() {
		if ($this->session->isLoggedIn()) {
			$this->session->doLogout();
			$this->render('logout');
			header('refresh:5;url=' . CORE_URL);
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	/**
	 * Account Handler
	 */
	public function account() {
		
		if ($this->session->isLoggedIn()) {
			$this->pagetitle = 'Account Settings';
			
			// User wants to update account settings? Maybe change the password as well? Well, lets do it
			if (isset($_POST['update-account']) && !empty($_POST['email']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['country'])
			) {
				// Check if user has entered the password fields as well, may want to change his password
				if (!empty($_POST['password']) && !empty($_POST['password2'])) {
						$this->user->updateUserPassword();
				}
				//default
				$this->user->updateUser();
			}
			
			$this->vals = $this->user->getUserDetails();
				
			$this->render('account');
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	/**
	 * Admnistration Index
	 */
	public function adminIndex() {
		$this->pagetitle = 'Adminstration';
	
		$this->render('admin.index');
	}
	
	/**
	 * Categories (Administration)
	 */
	public function adminCategories() {
		if ($this->session->isAdmin()) {
			$this->pagetitle = 'Categories';
			
			$this->res = $this->forum->getCategories();
			
			$this->render('admin.categories');
		}
		else {
			header('location: ' . CORE_URL);
		}	
	}
	
	/**
	 * New Category (Administration)
	 */
	public function adminNewCategory() {
		if ($this->session->isAdmin()) {
			$this->pagetitle = 'New Category';
				
			if (isset($_POST['create-category']) && !empty($_POST['categoryname']) && !empty($_POST['categorydesc'])) {
				$this->admin->createNewCategory();
			}
			
			$this->render('admin.createcategory');
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	/**
	 * Edit Category (Administration)
	 */
	public function adminEditCategory() {
		if ($this->session->isAdmin()) {
			$categoryId = $_GET['id'];
			
			$this->pagetitle = 'Edit Category';
				
			if (isset($_POST['update-category']) && !empty($_POST['categoryname']) && !empty($_POST['categorydesc'])) {
				$this->admin->updateCategory();
			}
			
			$this->vals = $this->admin->getCategoryDetails($categoryId);
			$this->render('admin.editcategory');
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
	
	/**
	 * Delete Category (Administration)
	 */
	public function adminDeleteCategory() {	
		if ($this->session->isAdmin()) {
			$this->admin->removeCategory();
		}
		else {
			header('location: ' . CORE_URL);
		}
	}
}
?>