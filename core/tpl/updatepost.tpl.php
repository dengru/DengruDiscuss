			<div>
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '">'. $this->categoryname . '</a> &raquo; <a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '&t=' . $_GET['t'] . '">'. $this->threadname . '</a> &raquo; <strong>Edit Reply</strong></p>';?>
				</div>
				
				<h3>Edit Reply :: <?php echo $this->threadname; ?></h3>
				<?php if (!empty($this->vals->post_modifiedon) && !empty($this->vals->post_modifiedby)) { 
				echo '<p><i>This post was last edited by '; if ($this->vals->post_modifiedby == $_SESSION['username']) { echo '<strong>you</strong>'; } else { echo '<strong>' . $this->vals->post_modifiedby . '</strong>'; } echo ' on ' . $this->vals->post_modifiedon . '.</i></p>';
				}?>
				<form id="edit-account" class="form" action="" method="post">
					<fieldset>
					
						<div class="field-textarea">
							<div class="field-label">
								<label>Message <i>(max 1000 characters)</i>:</label>
							</div>
							<div class="field">
								<textarea name="message" class="msg-editor"><?php echo $this->vals->post_content;?></textarea>
							</div>
						</div>
						
						<div class="field-btns">
							<?php echo '<a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '&t=' . $_GET['t'] . '" class="btn cancel-btn">cancel</a>';?>
							<button class="button" type="submit" name="update-post">save changes &gt;</button>
						</div>
						
					</fieldset>
				</form>
			</div>
			
			<!--  Load the TinyMCE WYSIWYG-editor -->
			<script type="text/javascript" src="assets/static/js/tinymce/tinymce.min.js"></script>
			<script type="text/javascript">
					tinymce.init({
					    selector: "textarea",
					    plugins: [
					        "advlist autolink lists link image charmap print preview anchor",
					        "searchreplace wordcount table visualblocks code fullscreen",
					        "insertdatetime emoticons textcolor media table contextmenu paste"
					    ],
					    toolbar: "insertfile undo redo | styleselect | forecolor backcolor emoticons | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
					});
			</script>