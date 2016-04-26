			<div id="admin-index">
				<div id="breadcrumbs">
					<p>Administration :: Create Category</p>
				</div>
				
				<div class="admin-menu">
					<nav class="primaryNav left">
					 	<ul class="group horizList">
					 		<li><a href="?q=admin">Admin Home</a></li>
					 		<li><a href="<?php echo CORE_URL . '/index.php?q=admin&a=categories';?>">Categories</a></li>
 						 	<li><a href="<?php echo CORE_URL . '/index.php?q=admin&a=new-category';?>">New Category</a></li>
					 	</ul>
					</nav>
				</div>
				
				<h3>Create Category</h3>
				
				<form id="category-create" class="form" action="" method="post">
					<fieldset>
						<div class="field-text">
							<div class="field-label">
								<label>Category Name:</label>
							</div>
							<div class="field">
								<input name="categoryname" type="text" size="40" placeholder="enter a category name..." required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Category Description:</label>
							</div>
							<div class="field">
								<input name="categorydesc" type="text" size="40" placeholder="enter a category description..." required />
							</div>
						</div>
						
						<div class="field-btns">
							<button class="button" type="submit" name="create-category">create category &gt;</button>
						</div>

					</fieldset>
				</form>
				
			</div>