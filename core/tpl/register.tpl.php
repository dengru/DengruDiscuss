			<div>
				<div id="breadcrumbs">
					<?php echo '<p><a href="' . CORE_URL . '">Home</a> &raquo; <strong>' . $this->pagetitle . '</strong></p>';?>
				</div>
				
				<h3>Register</h3>
				<form id="register" class="form" action="" method="post">
					<fieldset>
						
						<div class="field-text">
							<div class="field-label">
								<label>Username:</label>
							</div>
							<div class="field">
								<input name="username" type="text" size="40" placeholder="enter a username..." required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Email:</label>
							</div>
							<div class="field">
								<input name="email" type="email" size="40" placeholder="enter your email address..." required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>First Name:</label>
							</div>
							<div class="field">
								<input name="firstname" type="text" size="40" placeholder="enter your firstname..." required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Last Name:</label>
							</div>
							<div class="field">
								<input name="lastname" type="text" size="40" placeholder="enter your lastname..." required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Country:</label>
							</div>
							<div class="field">
								<input name="country" type="text" size="40" placeholder="where are you from...?" required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Password:</label>
							</div>
							<div class="field">
								<input name="password" type="password" size="40" placeholder="enter a password..." required />
							</div>
						</div>
						
						<div class="field-text">
							<div class="field-label">
								<label>Confirm Password:</label>
							</div>
							<div class="field">
								<input name="password2" type="password" size="40" placeholder="enter your password once again..." required />
							</div>
						</div>
						
						<div class="field-btns">
							<button class="button" type="submit" name="register">register &gt;</button>
						</div>
						
					</fieldset>
				</form>
			</div>