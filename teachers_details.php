<?php
$page_title = "Teacher Details";
include("include/header.php");
include("config/config.php");

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    
    // Delete old photo file too
    $old_result = $conn->query("SELECT photo FROM employees_tbl WHERE id=$id");
    if ($old_result && $old_result->num_rows > 0) {
        $old_data = $old_result->fetch_assoc();
        if (!empty($old_data['photo']) && file_exists($old_data['photo'])) {
            unlink($old_data['photo']);
        }
    }

    $conn->query("DELETE FROM employees_tbl WHERE id = $id");
    $_SESSION['success'] = "Teacher deleted successfully.";
    header("Location: teachers_details.php");
    exit();
}

// Handle edit form request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $edit_result = $conn->query("SELECT * FROM employees_tbl WHERE id = $id");
    $edit_data = $edit_result->fetch_assoc();
}

// Handle update action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $role = $conn->real_escape_string($_POST['role']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $email = $conn->real_escape_string($_POST['email']);
    $qualification = $conn->real_escape_string($_POST['qualification']);
    $experience_years = intval($_POST['experience_years']);
    $address = $conn->real_escape_string($_POST['address']);

    // Handle photo upload
    $photo_sql = "";
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/teachers/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Delete old photo
            $old_result = $conn->query("SELECT photo FROM employees_tbl WHERE id=$id");
            if ($old_result && $old_result->num_rows > 0) {
                $old_data = $old_result->fetch_assoc();
                if (!empty($old_data['photo']) && file_exists($old_data['photo'])) {
                    unlink($old_data['photo']);
                }
            }

            $photo_sql = ", photo='$target_file'";
        }
    }

    $sql = "UPDATE employees_tbl SET
                first_name='$first_name',
                last_name='$last_name',
                role='$role',
                mobile='$mobile',
                email='$email',
                qualification='$qualification',
                experience_years=$experience_years,
                address='$address'
                $photo_sql
            WHERE id=$id";

    if ($conn->query($sql)) {
        $_SESSION['success'] = "Teacher updated successfully.";
    } else {
        $_SESSION['error'] = "Update failed: " . $conn->error;
    }

    header("Location: teachers_details.php");
    exit();
}

// Search logic
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT * FROM employees_tbl WHERE 
              first_name LIKE '%$search%' OR 
              last_name LIKE '%$search%' OR 
              email LIKE '%$search%' OR 
              qualification LIKE '%$search%'";
} else {
    $query = "SELECT * FROM employees_tbl";
}
$result = $conn->query($query);
?>

<div class="container py-4">
    <h2 class="mb-4">Teacher Details</h2>

    <!-- Success / Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Edit Form (shown only if edit is triggered) -->
    <?php if (isset($edit_data)): ?>
        <h4>Edit Teacher</h4>
        <form method="post" class="mb-4" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">

            <div class="row mb-2">
                <div class="col"><input type="text" name="first_name" class="form-control" value="<?= $edit_data['first_name'] ?>" required></div>
                <div class="col"><input type="text" name="last_name" class="form-control" value="<?= $edit_data['last_name'] ?>" required></div>
            </div>
            <div class="row mb-2">
                <div class="col"><input type="text" name="role" class="form-control" value="<?= $edit_data['role'] ?>"></div>
                <div class="col"><input type="text" name="mobile" class="form-control" value="<?= $edit_data['mobile'] ?>"></div>
            </div>
            <div class="row mb-2">
                <div class="col"><input type="email" name="email" class="form-control" value="<?= $edit_data['email'] ?>"></div>
                <div class="col"><input type="text" name="qualification" class="form-control" value="<?= $edit_data['qualification'] ?>"></div>
            </div>
            <div class="row mb-2">
                <div class="col"><input type="number" name="experience_years" class="form-control" value="<?= $edit_data['experience_years'] ?>"></div>
                <div class="col"><input type="text" name="address" class="form-control" value="<?= $edit_data['address'] ?>"></div>
            </div>

            <!-- Current Photo Preview -->
            <?php if (!empty($edit_data['photo'])): ?>
                <div class="mb-2">
                    <img src="<?= $edit_data['photo'] ?>" alt="Current Photo" style="width:100px;height:100px;border-radius:50%;">
                </div>
            <?php endif; ?>

            <!-- Upload New Photo -->
            <div class="row mb-2">
                <div class="col">
                    <label>Photo (Leave blank to keep current)</label>
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    <?php endif; ?>

    <!-- Search Form -->
    <form class="mb-3 row" method="get">
        <div class="col-md-10">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or qualification..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn button-bg text-white w-100">Search</button>
        </div>
    </form>

    <!-- Teacher Cards -->
    <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card teacher-card shadow-sm">
                        <div class="card-body text-center">
                            <?php if ($row['photo']): ?>
                                <img src="<?= $row['photo'] ?>" alt="Teacher Photo" style="width:100px;height:100px;border-radius:50%;">
                            <?php else: ?>
                                <img src="default-user.png" alt="Default" style="width:100px;height:100px;border-radius:50%;">
                            <?php endif; ?>
                            <h5 class="mt-3"><?= $row['first_name'] . ' ' . $row['last_name'] ?></h5>
                            <p class="mb-1"><strong>Role:</strong> <?= $row['role'] ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?= $row['email'] ?></p>
                            <p class="mb-1"><strong>Mobile:</strong> <?= $row['mobile'] ?></p>
                            <p class="mb-1"><strong>Qualification:</strong> <?= $row['qualification'] ?></p>
                            <p class="mb-1"><strong>Experience:</strong> <?= $row['experience_years'] ?> yrs</p>
                            <p class="mb-1"><strong>Address:</strong> <?= $row['address'] ?></p>

                            <!-- Edit/Delete Buttons -->
                            <div class="mt-3 d-flex justify-content-center gap-2">
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                                </form>

                                <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="alert alert-warning">No teacher records found.</p>
    <?php endif; ?>
</div>
</body>
</html>
