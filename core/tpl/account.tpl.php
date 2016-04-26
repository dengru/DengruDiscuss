			<div>
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <strong>' . $this->pagetitle . '</strong></p>';?>
				</div>
				
				<h3>Account Settings</h3>
				<form id="edit-account" class="form" action="" method="post">
					<fieldset>
						<div class="field-text">
							<div class="field-label">
								<label>Email:</label>
							</div>
							<div class="field">
								<input name="email" type="email" size="40" value="<?php echo $this->vals->email; ?>" required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>First Name:</label>
							</div>
							<div class="field">
								<input name="firstname" type="text" size="40" value="<?php echo $this->vals->firstname; ?>" required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Last Name:</label>
							</div>
							<div class="field">
								<input name="lastname" type="text" size="40" value="<?php echo $this->vals->lastname; ?>" required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Country:</label>
							</div>
							<div class="field">
								<input name="country" type="text" size="40" value="<?php echo $this->vals->country; ?>" required />
							</div>
						</div>
						
						<h4>Change Password</h4>
						<div class="field-text">
							<div class="field-label">
								<label>New Password:</label>
							</div>
							<div class="field">
								<input name="password" size="40" type="password" />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Confirm New Password:</label>
							</div>
							<div class="field">
								<input name="password2" size="40" type="password" />
							</div>
						</div>
						
						<div class="field-btns">
							<button class="button" type="submit" name="update-account">save changes &gt;</button>
						</div>

					</fieldset>
				</form>
			</div>