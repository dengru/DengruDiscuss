			<div id="admin-index">
				<div id="breadcrumbs">
					<p>Administration :: Categories</p>
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
				
				<h3>Categories</h3>
				
				<div class="x-grid" id="grid-default">
					<div class="x-grid-body" id="grid-default-body">
						<div id="grid-controls-top">
							<a class="add-btn" href="?q=admin&a=new-category">New Category</a>
						</div>
						
						<table class="x-grid-table" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr class="x-grid-header-row">
									
									<th class="x-grid-header x-grid-col" style="width:3%;">
										<div class="x-grid-column-header">	
											<div class="x-grid-column-header-inner">	
												<span class="x-grid-column-header-inner-text">
													#
												</span>
											</div>
										</div>
									</th>
									
									<th class="x-grid-header x-grid-col" style="width:18%;">
										<div class="x-grid-column-header x-grid-column-header-first">	
											<div class="x-grid-column-header-inner">	
												<span class="x-grid-column-header-inner-text">
													Name
												</span>
											</div>
										</div>
									</th>
										
									<th class="x-grid-header x-grid-col" style="width:25%;">
										<div class="x-grid-column-header">	
											<div class="x-grid-column-header-inner">	
												<span class="x-grid-column-header-inner-text">
													Description
												</span>
											</div>
										</div>
									</th>
									
									<th class="x-grid-header x-grid-col" style="width:5%;">
										<div class="x-grid-column-header">	
											<div class="x-grid-column-header-inner">	
												<span class="x-grid-column-header-inner-text">
													Threads
												</span>
											</div>
										</div>
									</th>
									
									<th class="x-grid-header x-grid-col" style="width:5%;">
										<div class="x-grid-column-header">	
											<div class="x-grid-column-header-inner">	
												<span class="x-grid-column-header-inner-text">
													Posts
												</span>
											</div>
										</div>
									</th>
																		
									<th class="x-grid-header x-grid-col" style="width:15%;">
										<div class="x-grid-column-header">	
											<div class="x-grid-column-header-inner">
											</div>
										</div>
									</th>
								</tr>
								<?php
								foreach ($this->res as $key => $row) {
								
									echo '<tr class="x-grid-row">
									<td class="x-grid-cell">
										<div class="x-grid-cell-inner">
											<p>' . $row['cat_id']. '</p>
										</div>
									</td>';
									
									echo '<td class="x-grid-cell">
										<div class="x-grid-cell-inner">
											<div class="x-grid-cell-inner-title">
												<p>' . $row['cat_name'] . '</p>
											</div>
										</div>
									</td>';
									
									echo '<td class="x-grid-cell">
										<div class="x-grid-cell-inner">
											<div class="x-grid-cell-inner-title">
												<p>';
											if (strlen($row['cat_description']) > 40) {
												echo substr($row['cat_description'], 0, 40). ' ...';
											} else { echo $row['cat_description']; }
										  echo '</p>
											</div>
										</div>
									</td>';
									
									echo '<td class="x-grid-cell">
										<div class="x-grid-cell-inner">
											<p>' . $this->admin->getThreadCount($row['cat_id']) . '</p>
										</div>
									</td>';
									
									echo '<td class="x-grid-cell">
										<div class="x-grid-cell-inner">
											<p>' . $this->admin->getPostCount($row['cat_id']) . '</p>
										</div>
									</td>';
									
									echo '<td class="x-grid-cell">
										<div class="x-grid-cell-inner">
											<div class="x-grid-cell-inner-btns">
												
												<a class="x-btn-center x-grid-btn" href="' . CORE_URL . '/index.php?q=admin&a=edit-category&id=' . $row['cat_id'] .'">
													<span class="x-btn-inner x-grid-btn-inner">Edit</span>
												</a>
											
												<a class="x-btn-center x-grid-btn delete-btn" href="' . CORE_URL . '/index.php?q=admin&delete-category&id=' . $row['cat_id'] . '">
													<span class="x-btn-inner x-grid-btn-inner">Delete</span>
												</a>
												<div class="x-clear"></div>
											</div>
										</div>
									</td>
								</tr>';
						} ?>
							</tbody>
						</table>
					</div>
				</div>
								
							
			</div>