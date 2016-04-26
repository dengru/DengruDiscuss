<?php
/**
 * @name Admin Model
 *
 * DengruDiscuss
 * --------------
 * @author dennis
 *
 */

class Admin extends DengruDiscuss {
	
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
	 * Get Category Details
	 */
	public function getCategoryDetails($categoryId) {
		$sql = 'SELECT cat_name, cat_description FROM dd_categories WHERE cat_id = :category';
		$stmt = parent::prepare($sql);
		$stmt->bindValue(':category', $categoryId);
		$stmt->execute();
		
		$res = $stmt->fetchObject();
		
		
		if ($res) {
			return $res;
		}
		//default return
		return false;
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
	 * Create New Category
	 */
	public function createNewCategory() {
		
		//Sanitize the variables to maintain a trustful security
		$categoryName = htmlentities($_POST['categoryname'], ENT_QUOTES);
		$categoryDesc = htmlentities($_POST['categorydesc'], ENT_QUOTES);
			
		try {
			$sql = 'INSERT INTO dd_categories (cat_name, cat_description) VALUES(:categoryname, :categorydesc)';
			$stmt = parent::prepare($sql);
			$stmt->bindValue(':categoryname', $categoryName, PDO::PARAM_STR);
			$stmt->bindValue(':categorydesc', $categoryDesc, PDO::PARAM_STR);
				
			$creation_success = $stmt->execute();
			
			if ($creation_success) {
				echo 'The new category has been created.';				
				header('refresh:0;url=' . CORE_URL . '/index.php?q=admin&a=categories');
				return true;
			}
			else {
				echo 'The category-creation process has failed. Please try again.';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		//default return
		return false;
	}
	
	/**
	 * Update Category
	 */
	public function updateCategory() {
		// Sanitize the variables to maintain a trustful security
		$categoryId = $_GET['id'];
		$categoryName = htmlentities($_POST['categoryname'], ENT_QUOTES);
		$categoryDesc = htmlentities($_POST['categorydesc'], ENT_QUOTES);

		try {
			// Update the table with the updated records
			$sql = "UPDATE dd_categories SET cat_name = :catname, cat_description = :catdesc WHERE cat_id = :catid";
			$stmt = parent::prepare($sql);
			$stmt->bindValue(':catid', $categoryId);
			$stmt->bindValue(':catname', $categoryName);
			$stmt->bindValue(':catdesc', $categoryDesc);
				
			$update_success = $stmt->execute();
				
			if ($update_success) {						
				echo 'The category has been updated successfully.';
				header('refresh:1;url=' . CORE_URL . '/index.php?q=admin&a=categories');
				return true;
			}
			else {
				echo 'The category-update process has failed. Please try again.';
			}
		} 
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		//default return
		return false;
		
	}
	
	/**
	 * Remove Category
	 */
	public function removeCategory() {
		// Sanitize the variables to maintain a trustful security
		$categoryId = $_GET['id'];
	
		try {
			// Update the table with the updated records
			$sql = "DELETE FROM dd_categories WHERE cat_id = :catid";
			$stmt = parent::prepare($sql);
			$stmt->bindValue(':catid', $categoryId);
		
			$remove_success = $stmt->execute();
		
			if ($remove_success) {
				echo 'The category has been deleted successfully.';
				header('refresh:1;url=' . CORE_URL . '/index.php?q=admin&a=categories');
				return true;
			}
			else {
				echo 'The category-removal process has failed. Please try again.';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		//default return
		return false;
	
	}
	
}
?>