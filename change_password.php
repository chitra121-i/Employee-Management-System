<?php
include("config/config.php"); // DB connection

$message = ""; // To store status message

if (isset($_POST['submit'])) {
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);

    // Validate inputs
    if (empty($mobile) || empty($email) || empty($new_password)) {
        $message = "<div class='alert alert-danger'>All fields are required.</div>";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $message = "<div class='alert alert-danger'>Invalid mobile number format. Must be 10 digits.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Invalid email format.</div>";
    } else {
        // Check if user exists with both mobile and email
        $sql = "SELECT u.employee_id FROM user_tbl u 
                JOIN employees_tbl e ON u.employee_id = e.id
                WHERE e.mobile = '$mobile' AND e.email = '$email'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['employee_id'];

            // Hash password before storing (recommended)
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update = "UPDATE user_tbl SET password = '$hashed_password' WHERE employee_id = $user_id";
            if (mysqli_query($conn, $update)) {
                $message = "<div class='alert alert-success'>Password updated successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error updating password.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>No user found with this Mobile Number and Email ID.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="mb-3 text-center">Change Password</h2>
        <?php echo $message; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Mobile Number</label>
                <input type="text" name="mobile" class="form-control" placeholder="Enter 10-digit mobile" required>
            </div>

            <div class="mb-3">
                <label>Email ID</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Update Password</button>
        </form>
    </div>
</div>

</body>
</html>