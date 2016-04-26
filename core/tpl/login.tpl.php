			<div>
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <strong>' . $this->pagetitle . '</strong></p>';?>
				</div>
				
				<h1>Login</h3>
				<form id="account-login" class="form" action="" method="post">
					<fieldset>
					
						<div class="field-text">
							<div class="field-label">
								<label>Username:</label>
							</div>
							<div class="field">
								<input name="username" type="text" size="40" placeholder="enter a username..." />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Password:</label>
							</div>
							<div class="field">
								<input name="password" type="password" size="40" placeholder="enter a password..." />
							</div>
						</div>
					
						<div class="field-btns">
							<button class="button" type="submit" name="login">login &gt;</button>
						</div>
						
					</fieldset>
				</form>
			</div>