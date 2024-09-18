<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Admin | Book Store</title>

	<?php include('./header.php'); ?>
	<?php include('./db_connect.php'); ?>
	<?php 
	session_start();
	if(isset($_SESSION['login_id']))
	header("location:index.php?page=home");

	$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach ($query as $key => $value) {
		if(!is_numeric($key))
		$_SESSION['setting_'.$key] = $value;
	}
	?>

</head>
<style>
	body {
		width: 100%;
		height: calc(100%);
		background-image: url("bg.jpg");
		background-size: cover;
		background-position: center;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	main#main {
		width: 100%;
		height: 100vh;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.card {
		background-color: rgba(255, 255, 255, 0.85);
		border-radius: 1rem;
		box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
	}

	/* Adjusted padding */
	.card-body {
		padding: 2rem;
	}

	/* Adjusted spacing */
	.form-group {
		margin-bottom: 1.5rem;
	}

	/* Logo adjustments */
	.logo {
		margin: auto;
		font-size: 8rem;
		background: white;
		border-radius: 50%;
		height: 120px;
		width: 120px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
		margin-bottom: 1rem;
	}

	.logo img {
		height: 80%;
		width: 80%;
	}

	/* Button styling */
	.btn-primary {
		width: 100%;
		padding: 0.75rem;
	}

	/* Eye icon styling */
	.input-group-text {
		cursor: pointer;
		background-color: #007bff;
		color: white;
		border: none;
	}

	.back-to-top {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background: #007bff;
		color: white;
		padding: 10px;
		border-radius: 50%;
		display: none;
		z-index: 999;
	}
</style>

<body>
	<main id="main">
		<div class="card col-md-4">
		
			<div class="card-body">
				<form id="login-form">
					<h3 class="text-center mb-4">Login</h3>

					<div class="form-group">
						<label for="username" class="control-label">Username</label>
						<input type="text" id="username" name="username" class="form-control" placeholder="Enter your username">
					</div>

					<div class="form-group">
						<label for="password" class="control-label">Password</label>
						<div class="input-group">
							<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
							<div class="input-group-append">
								<span class="input-group-text" onclick="togglePasswordVisibility()">
									<i class="fa fa-eye" id="eye-icon"></i>
								</span>
							</div>
						</div>
					</div>

					<div class="text-center">
						<button class="btn btn-primary btn-wave" type="submit">Login</button>
					</div>
				</form>
			</div>
		</div>
	</main>

	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

	<script>
		$('#login-form').submit(function(e) {
			e.preventDefault()
			$('#login-form button[type="submit"]').attr('disabled', true).html('Logging in...');
			if ($(this).find('.alert-danger').length > 0)
				$(this).find('.alert-danger').remove();
			$.ajax({
				url: 'ajax.php?action=login',
				method: 'POST',
				data: $(this).serialize(),
				error: err => {
					console.log(err)
					$('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
				},
				success: function(resp) {
					if (resp == 1) {
						location.href = 'index.php?page=home';
					} else if (resp == 2) {
						location.href = 'voting.php';
					} else {
						$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
						$('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
					}
				}
			})
		})

		function togglePasswordVisibility() {
			var passwordInput = document.getElementById('password');
			var eyeIcon = document.getElementById('eye-icon');
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				eyeIcon.classList.remove('fa-eye');
				eyeIcon.classList.add('fa-eye-slash');
			} else {
				passwordInput.type = 'password';
				eyeIcon.classList.remove('fa-eye-slash');
				eyeIcon.classList.add('fa-eye');
			}
		}

		// Back to top button behavior
		$(window).scroll(function() {
			if ($(this).scrollTop() > 100) {
				$('.back-to-top').fadeIn();
			} else {
				$('.back-to-top').fadeOut();
			}
		});
		$('.back-to-top').click(function() {
			$('html, body').animate({ scrollTop: 0 }, 600);
			return false;
		});
	</script>
</body>

</html>
