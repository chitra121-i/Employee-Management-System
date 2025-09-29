<?php 
$page_title = "Academic Calendar";
include("include/header.php");
include("config/config.php"); 



// Insert or Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desc = $conn->real_escape_string($_POST['description']);
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $classes = $conn->real_escape_string($_POST['classes']);
    $calendar_id = $_POST['calendar_id'];

    if ($calendar_id != '') {
        $conn->query("UPDATE academic_calendar SET description='$desc', start_date='$start', end_date='$end', classes='$classes' WHERE id=$calendar_id");
    } else {
        $conn->query("INSERT INTO academic_calendar (description, start_date, end_date, classes) VALUES ('$desc', '$start', '$end', '$classes')");
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM academic_calendar WHERE id=$id");
    header("Location: calendar.php");
    exit();
}
?>
<body class="bg-light">
<div class="container py-5">
    <h2 class="text-center mb-4">📅 Academic Calendar (Admin Panel)</h2>

    <!-- Add/Edit Form -->
    <div class="card mb-4 shadow">
        <div class="card-header bg text-white">Add / Edit Calendar Entry</div>
        <div class="card-body">
            <form method="POST" id="calendarForm">
                <input type="hidden" name="calendar_id" id="calendar_id">
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Classes Affected</label>
                    <input type="text" name="classes" id="classes" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Save Entry</button>
                <button type="reset" class="btn btn-secondary" onclick="clearForm()">Reset</button>
            </form>
        </div>
    </div>

    <!-- Calendar Table -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">All Calendar Entries</div>
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>S.No</th>
                    <th>Description</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Classes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM academic_calendar ORDER BY start_date ASC");
                $sno = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$sno}</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . $row['start_date'] . "</td>";
                    echo "<td>" . $row['end_date'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['classes']) . "</td>";
                    echo "<td>
                            <button class='btn btn-warning btn-sm me-2' onclick=\"editCalendar(" . $row['id'] . ", '" . addslashes($row['description']) . "', '" . $row['start_date'] . "', '" . $row['end_date'] . "', '" . addslashes($row['classes']) . "')\">Edit</button>
                            <a href='?delete=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this entry?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                    $sno++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>