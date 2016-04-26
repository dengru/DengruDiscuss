			<div id="posts-index">
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '">'. $this->categoryname . '</a> &raquo; <strong>' . $this->threadname . '</strong></p>';?>
				</div>
				
				<h1><?php echo $this->threadname; ?></h1>
			<?php					
				$i = 0;
				// display data
				foreach ($this->res as $key => $row) {
					echo '<div id="post" data-postid="'. $row['post_id']. '">';
						$i++;
						
						echo '<div class="post-author">';//left postarea
						echo '<h4>'. $row['post_createdby'] . '</h4>';
						echo '</div>';
						
						echo '<div class="post-content">';//right postarea
							echo '<div class="post-info">';
								echo '<p class="post-name">'; if($i>1) echo 'Re: '; echo $this->threadname . '</p>'; 
								echo '<p class="post-date">'; 
									 echo '&laquo; <strong>Reply #' . $i . '</strong>'; echo ' <strong>on:</strong> '; echo date('F j, Y g:i:s A', strtotime($row['post_createdon'])); echo ' &raquo';
									 echo '</p>';
							echo '</div>';
							
							//if logged in, user can edit his posts
							if ($this->session->isLoggedIn()) {
								if ($row['post_createdby'] == $_SESSION['username'] || $this->session->isAdmin()) {
									echo '<div class="post-btns">';
										echo '<div id="post-btn-edit"><a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '&t=' . $_GET['t'] . '&a=edit&postid=' . $row['post_id'] .'" class="btn edit-btn">edit</a></div>';
									echo '</div>';
								}
							}
							
							echo '<div class="post-msg">' . html_entity_decode($row['post_content']) . '</div>';
							
							
							if (!empty($row['post_modifiedon']) && !empty($row['post_modifiedby'])) {
								echo '<div class="post-modified">';
									echo '<p>This post was last edited by '; { echo '<strong>' . $row['post_modifiedby'] . '</strong>'; } echo ' on ' . $row['post_modifiedon'] . '.</p>';
								echo '</div>';
							}
						
						echo '</div>';
				echo '</div>';
				}
				?>
				
				<?php if ($this->session->isLoggedIn()) {
						echo '<div class="act-btns">';
							echo '<a href="' . CORE_URL . '/index.php?c='. $_GET['c'] . '&t=' . $_GET['t'] . '&a=reply" class="btn reply-btn">Reply to this thread</a>';
						echo '</div>';
				}
				?>
					
			</div>