<?php
/**
 * @name DengruDiscuss.class
 *
 * DengruDiscuss
 * -------------
 * @author Dennis Grundelius
 *
 */
@include(dirname(dirname(__FILE__)) . '/config.core.php');

class DengruDiscuss extends PDO {
	
	public $db;
	public $handler;
	
	public $user;
	public $session;
	public $password;
				
	private $_is_sqlite;
		
	/**
	 * Constructor
	 */
	function __construct() {		
		//global $db, $user, $session, $password;
		$this->db = $this->getDb();
	}
	
	/**
	 * Get Database
	 */
	public function getDb() {
		$drivers = PDO::getAvailableDrivers();
		try {
			if (strlen(DB_USER) < 1 || strlen(DB_PASS) < 1) {
				if (!in_array('sqlite', $drivers) || strlen(SQLITE_FILE) < 1)
					die('A SQLite database connection could not be established because '. (!in_array('sqlite', $drivers) ? ' the `sqlite` driver':' SQLITE_FILE name') .' is not available!');
				parent::__construct('sqlite:'.SQLITE_FILE, '', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			else {
				if (!in_array('mysql', $drivers) || strlen(DB_HOST) < 1 || strlen(DB_NAME) < 1)
					die('A MySQL database connection could not be established because '. (!in_array('mysql', $drivers) ? 'the mysql PDO driver is not available': 'the database host or database name is empty').'.');
				parent::__construct('mysql:dbname='. DB_NAME .';host='. DB_HOST, DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
		}
		catch (PDOException $e) {
			die('Connection failed: '. $e->getMessage());
		}
	
		$this->_is_sqlite = $this->getAttribute(PDO::ATTR_DRIVER_NAME) == 'sqlite';
	}
	
	/**
	 * Render
	 *
	 * @param unknown_type $filename
	 * @param unknown_type $render_without_header_and_footer
	 */
	public function render($filename, $render_without_header_and_footer = false) {
		
		if ($render_without_header_and_footer == true) {
			require TPL_PATH . '/' . $filename . '.tpl.php';
		}
		else {
			require TPL_PATH . '/header.tpl.php';
			require TPL_PATH . '/' . $filename . '.tpl.php';
			require TPL_PATH . '/footer.tpl.php';
		}
	}
	
	
	/**
	 * Load Model
	 * 
	 * @param unknown_type $name
	 */
	public function loadModel($name) {
		$path = MODELS_PATH . '/' . strtolower($name) . '.model.php';
		
		if (file_exists($path)) {
			require MODELS_PATH . '/' . strtolower($name) . '.model.php';
			$modelName = $name;
			
			return new $modelName($this->db);
		}
	}
	
	/**
	 * Load Library
	 * 
	 * @param unknown_type $name
	 */
	public function loadLibrary($name) {
		$path = LIBS_PATH . '/' . $name . '.php';
		
		if (file_exists($path)) {
			require LIBS_PATH . '/' . $name . '.php';
			$libName = $name;
			
			return new $libName($this->db);
		}
	}
	
	/**
	 * Initialize
	 */
	public function initialize() {
		$this->loadLibrary('Router');
	}
}
?>