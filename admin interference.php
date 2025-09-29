
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teacher Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="asset/css/1.css">
  <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Navbar -->
  
<nav class="navbar navbar-expand-lg navbar-dark bg">
  <div class="container-fluid">
    <!-- Brand -->
    <h4 class="text-white">Admin Portal</h4>

   <div class="dropdown">
  <button class="btn dropdown-toggle d-flex align-items-center text-white" data-bs-toggle="dropdown">
    <div class="text-end me-2">
      <div><i class="fa fa-user me-2"></i>Chirag</div>
      <div><small>Admin of Portal</small></div>
    </div>
    <!-- Arrow appears here -->
  </button>
  <ul class="dropdown-menu bg1">
    <li><a class="dropdown-item" href="logout.php">
      <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
    </a></li>
  </ul>
</div>
  </div>
</nav>

  <div class="container3 mt-5 text-center">
    <h1 class="display-4">Welcome to Teacher Management Portal</h1>
    <p class="lead">Efficiently manage all teaching staff at one place.</p>
  </div>

 <div class="container shadow bg mt-5 pt-5 ">
  <div class="row text-center text-white">
    <div class="col-md-3">
      <div class="border">
      <a href="employees.php" class ="nav-link">
        <i class="fa-solid fa-magnifying-glass fa-2xl"></i><br/><br/>
      <h4>Employees</h4> 
      </a> 
    </div>
    </div>
    <div class="col-md-3">
      <div class="border">
       <a href="calendar.php" class ="nav-link">
      <i class="fa-regular fa-calendar fa-2xl"></i><br/><br/>
      <h4>Academic Calendar</h4>
      </a>
      </div> 
    </div>
    <div class="col-md-3">
      <div class="border">
       <a href="teacher_allocation.php" class ="nav-link">
        <i class="fa-solid fa-book-open fa-2xl"></i><br/><br/>
      <h4>Subject Teacher<br/> Allocation</h4>  
    </a>
  </div>
    </div>
    <div class="col-md-3">
      <div class="border">
       <a href="batch counsellor_allocation.php" class ="nav-link">
        <i class="fa-solid fa-people-group fa-2xl"></i><br/><br/>
      <h4>Batch counsellor<br/> Allocation</h4> 
      </a> 
    </div>
    </div>
    <div class="col-md-4 mt mb-5">
      <div class="border">
       <a href="notice.php" class ="nav-link">
        <i class="fa-solid fa-clipboard-list fa-2xl"></i><br/><br/>
       <h4>Notice/Circular</h4>  
     </a>
   </div>
    </div>
     <div class="col-md-4 mt">
      <div class="border">
       <a href="addt.php" class ="nav-link">
        <i class="fa-solid fa-plus fa-2xl"></i><br/><br/>
       <h4>Add New Teacher</h4> 
        </a> 
      </div>
    </div>
     <div class="col-md-4 mt ">
      <div class="border">
       <a href="teachers_details.php" class ="nav-link"> 
       <i class="fa-solid fa-info fa-2xl"></i><br/><br/>       
       <h4>Teacher Details</h4>
        </a>
      </div>
    </div>
  </div>
</div>
