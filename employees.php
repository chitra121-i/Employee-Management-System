<?php 
$page_title = "Employees";
include("include/header.php");
include("config/config.php"); // ✅ fixed path
?>
<div class="container mt-5">
    <h3 class="text-center text-success">Teachers Records</h3>
     <!-- ✅ Search Bar -->
   <div class="mb-3">
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" id="searchInput" onkeyup="searchByName()" class="form-control" placeholder="Search by name...">
    </div>
</div>
    <table id="dataTable" class="table table-hover table-bordered bg">
        <thead class="table-dark">
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Role</th>
                <th>Mobile No.</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM employees_tbl ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
