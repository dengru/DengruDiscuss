			<div>
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '">'. $this->categoryname . '</a> &raquo; <strong>New Thread</strong></p>';?>
				</div>
				
				<h3>New Thread :: <?php echo $this->categoryname; ?></h3>
				<form id="register" class="form" action="" method="post">
					<fieldset>
						<div class="field-text">
							<div class="field-label">
								<label>Subject:</label>
							</div>
							<div class="field">
								<input name="threadname" type="text" size=40" placeholder="enter a thread name/subject (min 3 characters)..." />
							</div>
						</div>
						
						<div class="field-textarea">
							<div class="field-label">
								<label>Message <i>(max 1000 characters)</i>:</label>
							</div>
							<div class="field">
								<textarea name="message" class="msg-editor"></textarea>
							</div>
						</div>
						
						<div class="field-btns">
							<?php echo '<a href="' . CORE_URL . '/index.php?c=' . $_GET['c'] . '" class="btn cancel-btn">cancel</a>';?>
							<button class="button" type="submit" name="create-thread">create thread &gt;</button>
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