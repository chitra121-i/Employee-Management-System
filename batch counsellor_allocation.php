<?php
$page_title = "Batch Counsellor Allocation";
include("include/header.php");
include("config/config.php");


// Insert mapping
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $batch = $_POST['batch_name'];
    $counsellor = $_POST['counsellor_id'];
    $conn->query("INSERT INTO batch_counsellor_mapping (batch_name, counsellor_id) VALUES ('$batch', $counsellor)");
}

// Delete mapping
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM batch_counsellor_mapping WHERE id=$id");
}

// Get counsellors list
$counsellors = $conn->query("SELECT id, first_name, last_name FROM employees_tbl");

// Get existing mappings
$mappings = $conn->query("SELECT bcm.id, bcm.batch_name, e.first_name, e.last_name 
                          FROM batch_counsellor_mapping bcm 
                          JOIN employees_tbl e ON bcm.counsellor_id = e.id");
?>

    <div class="container py-4">
    <h2 class="mb-4">Batch Counsellor Allocation</h2>

    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-5">
            <label class="form-label">Batch Name</label>
            <input type="text" name="batch_name" class="form-control" required>
        </div>
        <div class="col-md-5">
            <label class="form-label">Select Counsellor (Teacher)</label>
            <select name="counsellor_id" class="form-select" required>
                <option value="">Select</option>
                <?php while($row = $counsellors->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['first_name'] . ' ' . $row['last_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" name="add" class="btn button-bg text-white w-100">Allocate</button>
        </div>
    </form>

    <h4 class="mb-3">Existing Counsellor Allocations</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Batch</th>
                <th>Counsellor Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while($row = $mappings->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['batch_name'] ?></td>
                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this allocation?')" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>