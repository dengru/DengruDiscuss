<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<title><?php if (!empty($this->pagetitle)) echo $this->pagetitle; else echo 'Untitled'; ?> :: <?php if (!empty($this->sitename)) echo $this->sitename; else echo 'Site Name'; ?></title>
	
	<link href="assets/static/css/main.css" rel="stylesheet">
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><!--  Load jQuery -->
</head>
<body>
	
	<div class="header-wrapper">
		<header>
			<div class="header-container">
				 <div class="logo">
				 	<h1><span class="skim">D</span>engru<span class="skim">D</span>iscuss</h1>
				 	<p>A PHP/MySQL-Powered Discussion Board</p>
				 </div>
				 <nav class="primary-nav left">
				 	<ul class="group horiz-list">
				 		<li<?php if (empty($_GET['q'])) echo ' class="active"';?>><a href="<?php echo CORE_URL . '/';?>">Home</a>
					<?php if ($this->session->isLoggedIn()) { ?>
				 		<li<?php if (!empty($_GET['q']) && $_GET['q'] == 'account') echo ' class="active"';?>><a href="<?php echo CORE_URL . '/index.php?q=account';?>">Account</a>
				 	<?php } else { ?>
				 		<li<?php if (!empty($_GET['q']) && $_GET['q'] == 'register') echo ' class="active"';?>><a href="<?php echo CORE_URL . '/index.php?q=register';?>">Register</a>
				 	<?php } ?>
				 	<?php if ($this->session->isAdmin()) { ?>
				 		<li<?php if (!empty($_GET['q']) && $_GET['q'] == 'admin') echo ' class="active"';?>><a href="<?php echo CORE_URL . '/index.php?q=admin';?>">Admin</a></li>
				 	<?php } ?>
				 	</ul>
				 </nav>
				 <div class="login-container right">
				<?php if ($this->session->isLoggedIn()) { ?>
				<ul>
					<li>
						<a href="<?php echo CORE_URL . '/index.php?q=account';?>"><?php echo $_SESSION['username']; ?></a>
					</li>
					<li>
						<a href="<?php echo CORE_URL . '/index.php?q=logout';?>">Logout</a>
				</ul>
				<?php } else { ?>
				<p>
					<a href="<?php echo CORE_URL . '/index.php?q=login';?>">Login</a> or <a href="<?php echo CORE_URL . '/index.php?q=register';?>">Register</a>
				</p>
				<?php }?>
			</div>
			</div>
		</header>
	</div>
	
	<div class="main-container">
		<div class="main wrapper clearfix">