<?php
session_start();
include("config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in both fields'); window.history.back();</script>";
        exit;
    }

    $sql = "SELECT * FROM user_tbl WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Compare MD5 of entered password with stored hash
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if (strtolower($user['role']) === "admin") {
                header("Location: admin interference.php"); // ensure filename matches exactly
            } elseif (strtolower($user['role']) === "teacher") {
                header("Location: teacher_dashboard.php");
            } else {
                echo "<script>alert('Unknown role.'); window.history.back();</script>";
            }
            exit;

        } else {
            echo "<script>alert('Invalid password.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('User not found.'); window.history.back();</script>";
        exit;
    }
}
