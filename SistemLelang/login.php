<?php session_start() ?>
<div class="container-fluid">
	<form action="" id="login-frm">
		<div class="form-group">
			<label for="" class="control-label">Username</label>
			<input type="text" name="username" required="" class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Password</label>
			<input type="password" name="password" required="" class="form-control">
			<small><a href="javascript:void(0)" id="new_account">Create New Account</a></small>
		</div>
		<button class="button btn btn-primary btn-sm">Login</button>
		<button class="button btn btn-secondary btn-sm text-dark" type="button" data-dismiss="modal">Cancel</button>
	</form>
</div>


<!-- <section class="bg-gray-50 dark:bg-gray-900 flex flex-col justify-center items-center">
	<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
					Sign in to your account
				</h1>
				<form class="space-y-4 md:space-y-6" action="" id="login-frm">
					<div>
						<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
						<input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="your email" required="">
					</div>
					<div>
						<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
						<input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
					</div>
					<button class="button w-full text-black bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
					<p class="text-sm font-light text-gray-500 dark:text-gray-400">
						Don’t have an account yet? <a href="./signup.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500" id="new_account">Sign up</a>
					</p>
				</form>
			</div>
		</div>
	</div>
</section> -->

<style>
	#uni_modal .modal-footer {
		display: none;
	}
</style>

<script>
	$('#new_account').click(function() {
		uni_modal("Create an Account", 'signup.php?redirect=index.php?page=checkout')
	})
	$('#login-frm').submit(function(e) {
		e.preventDefault()
		start_load()
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'admin/ajax.php?action=login2',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				end_load()

			},
			success: function(resp) {
				if (resp == 1) {
					location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
				} else {
					$('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>')
					end_load()
				}
			}
		})
	})
</script>