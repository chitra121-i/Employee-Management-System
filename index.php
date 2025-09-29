
<!-- HTML Part -->
<!DOCTYPE html>
<html>
<head>
    <title>Employee Management Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="asset/css/1.css">
<script src="asset/js/1.js"></script>
<style>
		body {
			background-image: url('asset/images/frontpage1.png');
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: 100% 100%;
		}
	</style>

</head>
<body>
<div class="container1">
	<div class="mb-5">
	<h5 class="text-center "> EMPLOYEE MANAGEMENT LOGIN </h5>
</div>
	<form action="login.php" method="POST">
		<div class="mb-5">
		<label for="role">Login As</label>
		<select id="role" name="role" required>
			<option value="">  Select Role  </option>
			<option value="admin">Admin</option>
			<option value="employee">Teacher</option>
		</select>
	</div>
		<div class="mb-5">
		<label for="username">Username</label>	
      <input type="text" id="username" name="username" required>
        </div>
        <div class="mb-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password"  required>
        </div>
        <div class="mb-5">
  <button type="submit">Login</button>
  <a href="change_password.php" style="margin-left: 10px;">Change Password</a>
</div>
    </form>
  </div>
	
</div>
</body>
</html>