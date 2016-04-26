<?php
/**
 * @name Router
 * 
 * DengruDiscuss
 * --------------
 * @author dennis
 *
 */

class Router extends DengruDiscuss {
	
	public $queryString;
	public $argString;
	public $idString;
	public $hostString;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		
		$this->queryString = 'q';
		$this->catString = 'c';
		$this->threadString = 't';
		$this->argString = 'a';
		$this->idString = 'id';
		$this->postIdString = 'postid';
		$this->hostString = 'HTTP_HOST';
		
		$this->handler = $this->loadLibrary('Handler');
		
		$this->run();
	}
	
	
	
	public function run() {
		if (!isset($_GET[$this->queryString]) && !isset($_GET[$this->argString]) && !isset($_GET[$this->catString]) && !isset($_GET[$this->threadString]) && !isset($_GET[$this->postIdString])) {
			$this->handler->forumIndex();
		}
		
		// Route requests with ?c= (category string)
		if (!isset($_GET[$this->queryString]) && !isset($_GET[$this->argString]) && isset($_GET[$this->catString]) && !isset($_GET[$this->threadString]) && !isset($_GET[$this->postIdString])) {
			$this->handler->threads();
		}
		
		// Route requests with ?c=&t= (category string and thread string)
		if (!isset($_GET[$this->queryString]) && !isset($_GET[$this->argString]) && isset($_GET[$this->catString]) && isset($_GET[$this->threadString]) && !isset($_GET[$this->postIdString])) {
			$this->handler->thread();
		}
		
		// Route requests with ?c=&a= (category string and argument string)
		if (!isset($_GET[$this->queryString]) && isset($_GET[$this->argString]) && isset($_GET[$this->catString]) && !isset($_GET[$this->threadString]) && !isset($_GET[$this->postIdString])) {
			$this->handler->newThread();
		}
		
		// Route requests with ?c=&t=&a= (category string, thread string and argument string)
		if (!isset($_GET[$this->queryString]) && isset($_GET[$this->argString]) && isset($_GET[$this->catString]) && isset($_GET[$this->threadString]) && !isset($_GET[$this->postIdString])) {
			$this->handler->replyToThread();
		}
		
		// Route requests with ?c=&t=&a=&postid (category string, thread string and argument string)
		if (!isset($_GET[$this->queryString]) && isset($_GET[$this->argString]) && isset($_GET[$this->catString]) && isset($_GET[$this->threadString]) && isset($_GET[$this->postIdString])) {
			$this->handler->editPost();
		}
		
		//Route requests inside the administration section
		if (isset($_GET[$this->queryString]) && isset($_GET[$this->argString]) && !isset($_GET[$this->idString]) && !isset($_GET[$this->catString]) && !isset($_GET[$this->threadString]) && !isset($_GET[$this->postIdString])) {
			switch ($_GET[$this->queryString]) {
				case 'admin':
					switch ($_GET[$this->argString]) {
						case 'categories':
							$this->handler->adminCategories();
							break;
						case 'new-category':
							$this->handler->adminNewCategory();
							break;
					}
			}
		}
		
		if (isset($_GET[$this->queryString]) && isset($_GET[$this->argString]) && isset($_GET[$this->idString])) {
			switch ($_GET[$this->argString]) {
				case 'edit-category':
					$this->handler->adminEditCategory();
					break;
				case 'delete-category':
					$this->handler->adminDeleteCategory();
					break;
				default:
					$this->handler->adminIndex();
					break;
			}
		}
		
		// Route regular requests where only the query string is used, such as ?q=account or ?q=login etc
		if (isset($_GET[$this->queryString]) && !isset($_GET[$this->argString]) && !isset($_GET[$this->idString])) {
			switch ($_GET[$this->queryString]) {
				case 'login':
					$this->handler->login();
					break;
				case 'register':
					$this->handler->register();
					break;
				case 'logout':
					$this->handler->logout();
					break;
				case 'account':
					$this->handler->account();
					break;
				case 'admin':
					$this->handler->adminIndex();
					break;
					
				default:
					$this->handler->forumIndex();
					break;
			}
		}
	}
	
}
?>