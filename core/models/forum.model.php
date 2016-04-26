<?php
/**
 * @name Forum Model
 *
 * DengruDiscuss
 * --------------
 * @author dennis
 *
 */

class Forum extends DengruDiscuss {
	
	/**
	 * Constructor
	 */
	public function __construct() {		
		parent::__construct();
	}
	
	/**
	 * Get Categories
	 */
	public function getCategories() {
		
		$sql = 'SELECT dd_categories.cat_id, dd_categories.cat_name, dd_categories.cat_description FROM dd_categories';
		$stmt = parent::prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC); //Associate result so that we can use it as an associative array
		
		return $result;						
	}
	
	/**
	 * Get Latest Thread
	 */
	public function getLatestThread() {
		$sql = "SELECT thread_id, thread_name, thread_createdon, thread_createdby, cat_id FROM dd_threads ORDER BY thread_createdon DESC LIMIT 1";
		$stmt = parent::prepare($sql);		
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		//array_push($result);
		
		return $result;
	}
	
	/**
	 * Get Threads
	 */
	public function getThreads() {
		$categoryId = $_GET['c'];
		$sql = 'SELECT thread_id, thread_name, thread_createdon, thread_createdby, cat_id FROM dd_threads WHERE cat_id = :category ORDER BY thread_createdon DESC';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	/**
	 * Get Thread Count (of an category)
	 * @param unknown_type $categoryId
	 * @return number
	 */
	public function getThreadCount($categoryId) {
		$sql = 'SELECT thread_id FROM dd_threads WHERE cat_id = :category';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
	
		$count = $stmt->rowCount();
		
		return $count;
	}
	
	/**
	 * Get Post Count (of an category)
	 * @param unknown_type $categoryId
	 * @return number
	 */
	public function getPostCount($categoryId) {
		$sql = 'SELECT post_id FROM dd_posts WHERE cat_id = :category';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
	
		$count = $stmt->rowCount();
	
		return $count;
	}
	
	/**
	 * Get Thread Replies Count
	 * @param unknown_type $threadId
	 */
	public function getThreadRepliesCount($threadId) {
		$sql = 'SELECT post_id FROM dd_posts WHERE thread_id = :thread';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':thread', $threadId);
		$stmt->execute();
	
		$count = $stmt->rowCount();
	
		return $count;
	}
	
	/**
	 * Get Category Name By ID
	 * @return string
	 */
	public function getCategoryNameById() {
		$categoryId = $_GET['c'];//changed from isset($_GET['c'] to $_GET['c'] 8:41:40 2014-04-13
		$sql = 'SELECT cat_id, cat_name FROM dd_categories WHERE cat_id = :category';		
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
		$result = $stmt->fetchColumn('1');
		
		return $result;
	}
	
	/**
	 * Get Last Post Date By Category ID
	 * @return string
	 */
	public function getLastPostDateByCatId($categoryId) {
		$sql = 'SELECT post_createdon FROM dd_posts WHERE cat_id = :category ORDER BY post_createdon DESC';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchColumn('0');
	
		return $result;
	}
	
	/**
	 * Get the date of the last post by using the Thread ID
	 * @param unknown_type $threadId
	 */
	public function getLastPostDateByThreadId($threadId) {
		$sql = 'SELECT post_createdon FROM dd_posts WHERE thread_id = :thread ORDER BY post_createdon DESC';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':thread', $threadId, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchColumn('0');
	
		return $result;
	}
	
	public function getLastPostThreadIdByCatId($categoryId) {
		// Try to get the thread ID
		try {
			$sql = 'SELECT thread_id, post_createdon FROM dd_posts WHERE cat_id = :category ORDER BY post_createdon DESC';
			$stmt = parent::prepare($sql);
			$stmt->bindValue(':category', $categoryId, PDO::PARAM_INT);
			$stmt->execute();
			
			$threadid = $stmt->fetchColumn('0');
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		return $threadid;
	}
	
	// We cant to get the Thread name of the last posted item by using the 'thread_id'
	public function getLastPostThreadNameByCatId($categoryId) {

		try {
			$sql = 'SELECT thread_id, post_createdon FROM dd_posts WHERE cat_id = :category ORDER BY post_createdon DESC';
			$stmt = parent::prepare($sql);
			$stmt->bindValue(':category', $categoryId, PDO::PARAM_INT);
			$stmt->execute();
				
			$threadid = $stmt->fetchColumn('0');
			
			// Find out the thread name by using the previous fetched '$threadid'
			try {
				$sql = 'SELECT thread_id, thread_name FROM dd_threads WHERE thread_id = :threadid';
				$stmt = parent::prepare($sql);
				$stmt->bindValue(':threadid', $threadid, PDO::PARAM_INT);
				$stmt->execute();
				$threadname = $stmt->fetchColumn('1');
			}
			catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		return $threadname;
	}
	
	public function getLastPostAuthor($categoryId) {
		$sql = 'SELECT post_createdby, post_createdon FROM dd_posts WHERE cat_id = :category ORDER BY post_createdon DESC';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
		$result = $stmt->fetchColumn('0');
	
		return $result;
	}
	
	public function getThreadLastPostAuthor($threadId) {
		$sql = 'SELECT post_createdby, post_createdon FROM dd_posts WHERE thread_id = :thread ORDER BY post_createdon DESC';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':thread', $threadId);
		$stmt->execute();
		$result = $stmt->fetchColumn('0');
	
		return $result;
	}
	
	/**
	 * Get Category ID
	 */
	public function getCategoryId() {
		$sql = 'SELECT dd_categories.cat_id
		FROM dd_categories
		LEFT JOIN dd_threads ON dd_threads.cat_id = dd_categories.cat_id';
		$stmt = parent::prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchColumn('0');
	
		return $result;
	}
	
	/**
	 * Get Category Name
	 */
	public function getCategoryName() {
		$categoryId = $_GET['c'];
		$sql = 'SELECT cat_id, cat_name FROM dd_categories WHERE cat_id = :category';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
		$result = $stmt->fetchColumn('1'); //Will fetch the 'cat_name' column from the query
		
		return $result;
	}
	
	/**
	 * Get Category Description
	 */
	public function getCategoryDescription() {
		$categoryId = $_GET['c'];
		$sql = 'SELECT cat_id, cat_description FROM dd_categories WHERE cat_id = :category';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
		$result = $stmt->fetchColumn('1'); //Will fetch the 'cat_name' column from the query
	
		return $result;
	}
	
	/**
	 * Get Thread Name
	 */
	public function getThreadName() {
		$threadId = $_GET['t'];
		$sql = 'SELECT thread_id, thread_name FROM dd_threads WHERE thread_id = :thread';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':thread', $threadId);
		$stmt->execute();
		$result = $stmt->fetchColumn('1');
		
		return $result;
	}
	
	/**
	 * Get Post Author
	 */
	public function getPostAuthor() {
		$postId = $_GET['postid'];
		$sql = 'SELECT post_id, post_createdby FROM dd_posts WHERE post_id = :postid';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':postid', $postId);
		$stmt->execute();
		$result = $stmt->fetchColumn('1');
	
		return $result;
	}
	
	/**
	 * Get Thread
	 */
	public function getThread() {
		$threadId = $_GET['t'];//Sanitize variable for security reasons
		$sql = 'SELECT post_id, post_createdby, post_modifiedon, post_createdon, post_modifiedby, post_content, thread_id, cat_id FROM dd_posts WHERE thread_id = :thread';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':thread', $threadId);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	
	/**
	 * Create Thread
	 */
	public function createThread() {
		
		//Sanitize the variables to maintain a trustful security
		$threadName = htmlentities($_POST['threadname'], ENT_QUOTES);
		$threadAuthor = $_SESSION['username'];
		$threadMessage = htmlentities($_POST['message'], ENT_QUOTES);
		$category = $_GET['c'];

		// Validate the thread-creation
		if ($this->validate_threadcreation()) {
			
			// Record the timestamp with the correct date format 'Y-m-d h:i:s' (Year-month-day hour:minute:second)
			$date = time();
			$dateNow = date('Y-m-d h:i:s', $date);
			
			try {
				$sql = 'INSERT INTO dd_threads (thread_name, thread_createdon, thread_createdby, cat_id) VALUES(:threadname, :threaddate, :threadauthor, :category)';
				$stmt = parent::prepare($sql);
				$stmt->bindValue(':threadname', $threadName, PDO::PARAM_STR);
				$stmt->bindValue(':threaddate', $dateNow);
				$stmt->bindValue(':threadauthor', $threadAuthor, PDO::PARAM_STR);
				$stmt->bindValue(':category', $category, PDO::PARAM_STR);
					
				$creation_success = $stmt->execute();
				$threadid = parent::lastInsertId('thread_id');//Get the thread ID
				
				if (($creation_success) && !empty($threadid)) {
					// Insert the 'message' (reply) by using the last inserted ID to determine the thread ID
					$this->insertReply($threadid, $threadAuthor, $threadMessage, $dateNow, $category);
					
					//echo 'Your thread has been created successfully.';
					header('refresh:0;url=' . CORE_URL . '/index.php?c=' . $category . '&t=' . $threadid);
					return true;
				}
				else {
					echo 'The thread-creation process has failed. Please try again.';
				}
			}
			catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		//default return
		return false;
	}
	
	/**
	 * Insert Reply
	 * @param unknown_type $thread_id
	 * @param unknown_type $author
	 * @param unknown_type $message
	 * @param unknown_type $date
	 * @param unknown_type $category
	 */
	public function insertReply($thread_id, $author, $message, $date, $category) {
		
		try {
			$sql = 'INSERT INTO dd_posts (post_createdon, post_createdby, thread_id, post_content, cat_id) VALUES(:postdate, :postauthor, :threadid, :message, :category)';
			$stmt = parent::prepare($sql);
			$stmt->bindValue(':postdate', $date);
			$stmt->bindValue(':postauthor', $author, PDO::PARAM_STR);
			$stmt->bindValue(':threadid', $thread_id, PDO::PARAM_INT);
			$stmt->bindValue(':message', $message, PDO::PARAM_STR);
			$stmt->bindValue(':category', $category, PDO::PARAM_INT);
				
			$creation_success = $stmt->execute();
			if ($creation_success) {	
				echo 'Your reply has been created successfully.';
				return true;
			}
			else {
				echo 'The insert-reply process has failed. Please try again.';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		//default return
		return false;
	}
	
	/**
	 * Create Reply
	 */
	public function createReply() {
		//Sanitize the variables to maintain a trustful security
		$threadId = $_GET['t'];
		$postAuthor = $_SESSION['username'];
		$postMessage = htmlentities($_POST['message'], ENT_QUOTES);
		$category = $_GET['c'];//Make sure the category id has been set before the form is visibl
		
		// Validate the thread-creation
		if ($this->validate_reply()) {
				
			// Record the timestamp using 'time()' with the correct date format 'Y-m-d h:i:s' (Year-month-day hour:minute:second)
			$date = time();
			$dateNow = date('Y-m-d h:i:s', $date);
			
			// Run the insertion
			$this->insertReply($threadId, $postAuthor, $postMessage, $dateNow, $category);
			header('refresh:0;url=' . CORE_URL . '/index.php?c=' . $category . '&t=' . $threadId);
		}
	}
	
	/**
	 * Get Post By ID
	 */
	public function getPostById() {
		$postId = $_GET['postid'];
		$username = $_SESSION['username'];
		
		$sql = 'SELECT post_id, post_createdby, post_modifiedby, post_modifiedon, post_content FROM dd_posts WHERE post_id = :postid AND post_createdby = :username';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':postid', $postId);
		$stmt->bindValue(':username', $username);
		$stmt->execute();
		
		$res = $stmt->fetchObject();
		
		if ($res) {
			return $res;
		}
					
		//default return
		return false;
	}
	
	public function getPostByIdIfAdmin() {
		$postId = $_GET['postid'];
		
		$sql = 'SELECT post_id, post_createdby, post_modifiedby, post_modifiedon, post_content FROM dd_posts WHERE post_id = :postid';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':postid', $postId);
		$stmt->execute();
		
		$res = $stmt->fetchObject();
		
		if ($res) {
			return $res;
		}
			
		//default return
		return false;
	}
	
	/**
	 * Update Post
	 */
	public function updatePost() {
		// Sanitize the variables to maintain a trustful security
		$postId = $_GET['postid'];
		$postMessage = htmlentities($_POST['message'], ENT_QUOTES);
		$postAuthor = $_SESSION['username'];
		
		// Validate the reply-update
		if ($this->validate_reply()) {
		
			// Record the timestamp using 'time()' with the correct date format 'Y-m-d h:i:s' (Year-month-day hour:minute:second)
			$date = time();
			$dateNow = date('Y-m-d h:i:s', $date);
			
			try {
				// Update the table with the updated records
				$sql = "UPDATE dd_posts SET post_content = :message, post_modifiedon = :modifydate, post_modifiedby = :modifiedby WHERE post_id = :postid";
				$stmt = parent::prepare($sql);
				$stmt->bindValue(':postid', $postId);
				$stmt->bindValue(':message', $postMessage);
				$stmt->bindValue(':modifydate', $dateNow);
				//$stmt->bindValue(':postauthor', $postAuthor);
				$stmt->bindValue(':modifiedby', $postAuthor);
					
				$update_success = $stmt->execute();
					
				if ($update_success) {						
					echo 'Your post has been updated successfully.';
					header('refresh:1;url=' . CORE_URL . '/index.php?c=' . $_GET['c'] . '&t=' . $_GET['t']);
					return true;
				}
				else {
					echo 'The post-update process has failed. Please try again.';
				}
			} 
			catch (PDOException $e) {
				echo $e->getMessage();
			}
			//default return
			return false;
			
		}
	}
	
	/**
	 * Validate Reply
	 */
	public function validate_reply() {
		if (!empty($_POST['message'])
				//check message field
				&& strlen($_POST['message']) <= 1000
				&& strlen($_POST['message']) >= 3
		) {
			return true;
		
			// Empty field validation
		} elseif (empty($_POST['message'])) {
			echo 'Empty message';
		
			// Length and scheme validation
		} elseif (strlen($_POST['message']) > 1000 || strlen($_POST['message']) < 3) {
			echo 'Message cannot be shorter than 3 or longer than 1000 characters';
				
		} else {
			echo 'An unknown error occurred.';
		}
		
		return false;
	}
	
	/**
	 * Validate Thread Creation
	 * @return boolean
	 */
	public function validate_threadcreation() {
	
		if (!empty($_POST['threadname'])
				//check threadname field
				&& strlen($_POST['threadname']) <= 64
				&& strlen($_POST['threadname']) >= 3
				//check message field
				&& strlen($_POST['message']) <= 1000
				&& strlen($_POST['message']) >= 3
		) {
			return true;
	
		// Empty field validation
		} elseif (empty($_POST['threadname'])) {
			echo 'Empty Threadname/Subject';
			
		} elseif (empty($_POST['message'])) {
			echo 'Empty message';
		
		// Length and scheme validation
		} elseif (strlen($_POST['threadname']) > 64 || strlen($_POST['threadname']) < 3) {
			echo 'Threadname/subject cannot be shorter than 3 or longer than 64 characters';
			
		} elseif (strlen($_POST['message']) > 1000 || strlen($_POST['message']) < 3) {
			echo 'Message cannot be shorter than 3 or longer than 1000 characters';
			
		} else {
			echo 'An unknown error occurred.';
		}
	
		return false;
	}
}
?>