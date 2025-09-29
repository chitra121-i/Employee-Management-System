<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teacher Management System</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="asset/css/1.css">
<script src="asset/js/1.js"></script>
</head>
<body>
 
<nav class="navbar navbar-expand-lg navbar-dark bg">
  <div class="container-fluid">
    <div class="d-flex align-items-center me-auto">
      <button class="btn me-2" >
        <a href="admin interference.php" class ="nav-link">
        <i class="fa-solid fa-arrow-left text-white fa-2xl"></i>
      </a>
      </button>
      <h4 class="mb-0 text-white">
        <?php echo isset($page_title) ? $page_title : 'Default Title'; ?>
      </h4>
    </div>
    <div class="dropdown">
  <button class="btn dropdown-toggle d-flex align-items-center text-white" data-bs-toggle="dropdown">
    <div class="text-end me-2">
      <div><i class="fa fa-user me-2"></i>Chirag</div>
      <div><small>Admin of Portal</small></div>
    </div>
    <!-- Arrow appears here -->
  </button>
  <ul class="dropdown-menu bg1">
    <li><a class="dropdown-item" href="index.php">
      <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
    </a></li>
  </ul>
</div>
  </div>
</nav>


