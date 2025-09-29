<?php
include("config/config.php");

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $first_name    = trim($_POST['first_name']);
    $last_name     = trim($_POST['last_name']);
    $role          = trim($_POST['role']);
    $mobile        = trim($_POST['mobile']);
    $email         = trim($_POST['email']);
    $qualification = trim($_POST['qualification']);
    $experience_years= isset($_POST['experience_years']) ? intval($_POST['experience_years']) : 0;
    $address       = isset($_POST['address']) ? trim($_POST['address']) : '';
    $photo_path    = '';

    // Validation
    if (!empty($first_name) && !empty($last_name) && !empty($role) && !empty($mobile) && !empty($email) && !empty($qualification)) {

        if (!is_numeric($mobile)) {
            $_SESSION['error'] = "Mobile number must be numeric.";
            header("Location: addt.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format.";
            header("Location: addt.php");
            exit();
        }

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = time() . '_' . basename($_FILES['photo']['name']);
            $photo_path = $uploadDir . $filename;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        }

        // Insert
        $sql = "INSERT INTO employees_tbl 
                (first_name, last_name, role, mobile, email, qualification, experience_years, address, photo)
                VALUES 
                ('$first_name', '$last_name', '$role', '$mobile', '$email', '$qualification', '$experience_years', '$address', '$photo_path')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "Teacher added successfully.";
        } else {
            $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Please fill in all required fields.";
    }

    header("Location: addt.php");
    exit();
}
?>