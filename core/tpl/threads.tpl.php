			<div id="threads-index">
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <strong>' . $this->categoryname . '</strong></p>';?>
				</div>
				
				<h1><?php echo $this->categoryname; ?></h1>
				<p><?php echo $this->categorydesc; ?></p>
								
				<table border="1" width="100%">
					<tr id="thread-headers">
						<th id="thread-name-header">Subject / Started by</th>
						<th id="thread-replies-header">Replies</th>
						<th id="thread-last-header">Last post</th>
					</tr>
					<?php					
																
					echo '<table width="100%">';
					// display data
					foreach ($this->res as $key => $row) {
						
						echo '<tr id="thread">';
						
						echo '<td id="thread-name" class="left">';
						echo '<h4><a href="' . CORE_URL . '/index.php?c=' . $row['cat_id'] . '&t=' . $row['thread_id']. '">' . $row['thread_name']. '</a></h4><p>Started by <strong>' . $row['thread_createdby'] . '</strong></p>';
						echo '</td>';
						echo '<td id="thread-replies" class="middle">';
						echo '<p>' . $this->forum->getThreadRepliesCount($row['thread_id']) . ' Replies</p>';
						echo '</td>';
						echo '<td id="thread-last" class="right">';
						echo '<p>' . $this->forum->getLastPostDateByThreadId($row['thread_id']) . '<br/>by <strong>' . $this->forum->getThreadLastPostAuthor($row['thread_id']) . '</strong></p>';
						echo '</td>';

						echo '</tr>';
					}
					// close the table
					echo '</table>';
					echo '<div class="clearfix"></div>';
					
					if ($this->session->isLoggedIn()) {
						echo '<div class="act-btns">';
							echo '<a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '&a=newthread" class="btn thread-btn">New Thread</a>';
						echo '</div>';
						echo '<div class="clearfix"></div>';
					}
					
					?>
				</table>
			</div>