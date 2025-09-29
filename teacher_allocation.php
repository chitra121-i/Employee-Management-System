<?php
$page_title = "Subject Teacher Allocation";
include("include/header.php");
include("config/config.php");

// Insert Mapping
if (isset($_POST['assign'])) {
    $teacher_id = $_POST['teacher_id'];
    $subject = $_POST['subject'];
    $class = $_POST['class'];

    $conn->query("INSERT INTO subject_teacher_mapping (teacher_id, subject_name, class_name)
                  VALUES ('$teacher_id', '$subject', '$class')");
}

// Delete Mapping
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM subject_teacher_mapping WHERE id=$id");
}
?>

<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">Subject-Teacher Allocation</h2>
    
    <form method="POST" class="row g-3 bg-white p-4 rounded shadow-sm">
        <div class="col-md-4">
            <label for="teacher_id" class="form-label">Select Teacher</label>
            <select class="form-select" name="teacher_id" required>
                <option value="">-- Choose Teacher --</option>
                <?php
                $res = $conn->query("SELECT id, first_name, last_name FROM employees_tbl WHERE role = 'teacher'");
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Class Name</label>
            <input type="text" name="class" class="form-control" required>
        </div>
        <div class="col-12 text-center">
            <button type="submit" name="assign" class="btn button-bg text-white">Assign</button>
        </div>
    </form>

    <hr class="my-4">

    <h4 class="mb-3">All Subject Allocations</h4>
    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Teacher</th>
                <th>Subject</th>
                <th>Class</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("
                SELECT m.id, e.first_name, e.last_name, m.subject_name, m.class_name 
                FROM subject_teacher_mapping m 
                JOIN employees_tbl e ON m.teacher_id = e.id
            ");
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['first_name']} {$row['last_name']}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['class_name']}</td>
                    <td>
                        <a href='?delete={$row['id']}' class='btn btn-danger btn-sm'
                           onclick=\"return confirm('Delete this allocation?')\">Delete</a>
                    </td>
                </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>