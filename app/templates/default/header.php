<?php
/**
 * Sample layout
 */

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>

	<!-- Site meta -->
	<meta charset="utf-8">
	<?php
	//hook for plugging in meta tags
	$hooks->run('meta');
	?>
	<title><?php echo $data['title'].' - '.SITETITLE; //SITETITLE defined in app/Core/Config.php ?></title>

	<!-- CSS -->
	<?php
	Assets::css(array(
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
		Url::templatePath() . 'css/style.css',
	));

	//hook for plugging in css
	$hooks->run('css');
	?>

</head>
<body>
<?php
//hook for running code after body tag
$hooks->run('afterBody');
?>

<div class="container">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<li><a href="<?= DIR ?>">Home</a></li>
				<li><a href="<?= DIR."articles_list"?>">Articles List</a></li>
				<li><a href="<?= DIR."article_creation_form"?>">Create Article</a></li>
				<li><a href="<?= DIR."authentifier/registerForm" ?>">Sign up</a></li>
				<li><a href="<?= DIR."authentifier/loginForm" ?>">Login</a></li>
				<li><a href="<?= DIR."authentifier/logout" ?>">Logout</a></li>
				<li><a>
					<?= $data['user_status'] ?>
					</a>
				</li>
				<li>
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" >More <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href="<?= DIR."authentifier/admin/users_management_panel" ?>">Administration panel</a></li>
							<li><a href="<?= DIR."authentifier/userProfile" ?>">Profile</a></li>
							<li><a href="<?= DIR."authentifier/profileUpdateForm" ?>">Update your profile</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</nav>