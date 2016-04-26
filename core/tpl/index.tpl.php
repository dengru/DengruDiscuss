			<div id="forum-index">
				<div id="breadcrumbs">
					<p>Home</p>
				</div>
				<h1>Home</h1>
				<p>Welcome to the DengruDiscuss discussion board, take your time exploring it's features.</p>
				
				<table border="1" width="100%">
					<tr id="category-headers">
						<th id="category-name-header">Category Name</th>
					</tr>
					<?php					
																
					echo '<table width="100%">';
					// display data
					foreach ($this->res as $key => $row) {
						echo '<tr id="category">';
						
							echo '<td id="category-name" class="left">';
							echo '<h3><a href="' . CORE_URL . '/index.php?c=' . $row['cat_id'] . '">' . $row['cat_name']. '</a></h3><p class="desc">' . $row['cat_description']. '</p>';
							echo '</td>';
							echo '<td id="category-stats" class="middle">';
							echo '<p>' . $this->forum->getPostCount($row['cat_id']) . ' Posts<br/> ' . $this->forum->getThreadCount($row['cat_id']) . ' Threads</p>';
							echo '</td>';
							echo '<td id="category-last" class="right">';
							echo '<p>Last post by <strong>' . $this->forum->getLastPostAuthor($row['cat_id']) . '</strong><br/>in <a href="' . CORE_URL . '/index.php?c=' . $row['cat_id'] . '&t=' . $this->forum->getLastPostThreadIdByCatId($row['cat_id']) . '">';
							if (strlen($this->forum->getLastPostThreadNameByCatId($row['cat_id'])) > 20) {
								echo substr($this->forum->getLastPostThreadNameByCatId($row['cat_id']), 0, 20). ' ...';
							} else { echo $this->forum->getLastPostThreadNameByCatId($row['cat_id']); }
							echo '</a> on ' . $this->forum->getLastPostDateByCatId($row['cat_id']) . '</p>';
							echo '</td>';

						echo '</tr>';
					}
					// close the table
					echo '</table>';
					
					?>
				</table>
			</div>