<?php 
$page_title = "Add New Teacher";
include("include/header.php");
include("config/config.php"); 
?>

<div class="container mt-5">
  <div class="card shadow border-0">
    <div class="card-header bg text-white">
      <h5 class="mb-0">Add New Teacher</h5>
    </div>
    <div class="card-body">
      <form action="submit_user.php" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select name="role" class="form-select" required>
              <option value="">Select Role</option>
              <option value="Teacher">Teacher</option>
              <option value="Admin">Admin</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Mobile <span class="text-danger">*</span></label>
            <input type="tel" name="mobile" class="form-control" placeholder="Enter Mobile No" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Qualification <span class="text-danger">*</span></label>
            <input type="text" name="qualification" class="form-control" placeholder="Qualification" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Experience (Years)</label>
            <input type="number" name="experience_years" class="form-control" placeholder="Enter Experience in Years">
          </div>
          <div class="col-md-6">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <textarea name="address" class="form-control" rows="3" placeholder="Enter Address"></textarea>
        </div>

        <div class="text-end mt-4">
          <button type="submit" name="submit" class="btn button-bg px-4 text-white">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>