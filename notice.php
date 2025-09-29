<?php 
$page_title = "Notice/Circular";
include("include/header.php");
include("config/config.php"); // ✅ fixed path



// Handle POST (Create or Update)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $message = $conn->real_escape_string($_POST['message']);

    if (isset($_POST['notice_id']) && $_POST['notice_id'] != '') {
        // Update
        $id = intval($_POST['notice_id']);
        $conn->query("UPDATE notices SET title='$title', message='$message' WHERE id=$id");
    } else {
        // Create
        $conn->query("INSERT INTO notices (title, message) VALUES ('$title', '$message')");
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM notices WHERE id=$id");
    header("Location: admin interference.php"); // Refresh to avoid resubmission
    exit();
}
?>

<body class="bg-light">
<div class="container py-5">
    <h2 class="text-center mb-4">📢 Admin Notice Panel</h2>

    <!-- Create / Edit Notice Form -->
    <div class="card shadow mb-4">
        <div class="card-header bg text-white">Create / Edit Notice</div>
        <div class="card-body">
            <form method="POST" id="noticeForm">
                <input type="hidden" name="notice_id" id="notice_id">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">📤 Save Notice</button>
                <button type="reset" onclick="clearForm()" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>

    <!-- Notice List -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">All Notices</div>
        <ul class="list-group list-group-flush">
            <?php
            $res = $conn->query("SELECT * FROM notices ORDER BY created_at DESC");
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo '<li class="list-group-item">';
                    echo '<div class="d-flex justify-content-between">';
                    echo '<div>';
                    echo '<h5>' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p>' . nl2br(htmlspecialchars($row['message'])) . '</p>';
                    echo '<small class="text-muted">Posted on: ' . $row['created_at'] . '</small>';
                    echo '</div>';
                    echo '<div class="text-end">';
                    echo '<button class="btn btn-sm btn-warning me-2" onclick="editNotice(' . $row['id'] . ', ' . addslashes($row['title']) . ', ' . addslashes($row['message']) . ')">Edit</button>';
                    echo '<a href="?delete=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this notice?\')">Delete</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item text-muted">No notices available.</li>';
            }
            ?>
        </ul>
    </div>
</div>
</body>
</html>