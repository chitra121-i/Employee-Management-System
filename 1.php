<?php

include("config/config.php"); // Your DB connection


// Decide which teacher to show
$teacher_id = null;
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Teacher' && isset($_GET['teacher_id'])) {
    $teacher_id = intval($_GET['teacher_id']); // Admin viewing specific teacher
} elseif (isset($_SESSION['id'])) {
    $teacher_id = intval($_SESSION['id']); // Logged-in teacher
} else {
    header("Location: login.php");
    exit();
}

// Fetch teacher profile
$profile_stmt = $conn->prepare("SELECT id, first_name, last_name, role, mobile, email, qualification, experience_years, address, photo 
                                FROM employees_tbl WHERE id = ?");
$profile_stmt->bind_param("i", $teacher_id);
$profile_stmt->execute();
$profile = $profile_stmt->get_result()->fetch_assoc();
$profile_stmt->close();

// Fetch academic calendar
$calendar_res = $conn->query("SELECT id, description, start_date, end_date, created_at 
                               FROM academic_calender ORDER BY start_date ASC");

// Fetch subjects for this teacher
$sub_stmt = $conn->prepare("SELECT subject_name, class_name FROM subject_teacher_mapping WHERE teacher_id = ?");
$sub_stmt->bind_param("i", $teacher_id);
$sub_stmt->execute();
$subjects = $sub_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$sub_stmt->close();

// Fetch batches for this teacher as counsellor
$batch_stmt = $conn->prepare("SELECT batch_name FROM batch_counsellor_mapping WHERE counsellor_id = ?");
$batch_stmt->bind_param("i", $teacher_id);
$batch_stmt->execute();
$batches = $batch_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$batch_stmt->close();

// Fetch notices
$notice_res = $conn->query("SELECT title, message, created_at FROM notices ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .card { border-radius: 12px; box-shadow: 0 6px 18px rgba(19,24,33,0.06); }
        .profile-pic { width:88px; height:88px; object-fit:cover; border-radius:50%; border:3px solid #fff; box-shadow:0 4px 12px rgba(0,0,0,0.08); }
        .notice-card { background: linear-gradient(90deg,#fffaf0,#fff8e5); }
        .muted-small { font-size:0.85rem; color:#6b7280; }
    </style>
</head>
<body>

<!-- Top navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#1f2937;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Teacher Dashboard</a>
    <div class="ms-auto d-flex align-items-center gap-2">
      <?php if(isset($_SESSION['first_name'])): ?>
        <span class="text-light me-2 d-none d-sm-inline"><?=htmlspecialchars($_SESSION['first_name'])?></span>
      <?php endif; ?>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container my-4">
<div class="row g-4">

  <!-- Profile + Notices -->
  <div class="col-lg-4">
    <div class="card p-3 mb-4">
      <div class="d-flex align-items-center gap-3">
        <?php
           $photo = ($profile && !empty($profile['photo'])) ? htmlspecialchars($profile['photo']) : 'https://via.placeholder.com/120';
        ?>
        <img src="<?= $photo ?>" alt="photo" class="profile-pic">
        <div>
          <h5 class="mb-0"><?= ($profile) ? htmlspecialchars($profile['first_name'].' '.$profile['last_name']) : 'Unknown Teacher' ?></h5>
          <div class="muted-small"><?= ($profile) ? htmlspecialchars($profile['role']) : '' ?></div>
          <div class="mt-2 muted-small">
            <?= ($profile) ? htmlspecialchars($profile['email']) : '' ?><br>
            <?= ($profile) ? htmlspecialchars($profile['mobile']) : '' ?>
          </div>
        </div>
      </div>
      <?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
        <div class="mt-3">
          <small class="text-muted">Viewing as admin (Teacher ID: <?= $teacher_id ?>)</small>
        </div>
      <?php endif; ?>
    </div>

    <div class="card p-3 notice-card">
      <h6 class="mb-3">📢 Latest Notices</h6>
      <?php if($notice_res->num_rows === 0): ?>
        <p class="mb-0 muted-small">No notices found.</p>
      <?php else: ?>
        <?php while($n = $notice_res->fetch_assoc()): ?>
          <div class="mb-3">
            <div class="d-flex justify-content-between">
              <strong><?= htmlspecialchars($n['title']) ?></strong>
              <small class="muted-small"><?= htmlspecialchars($n['created_at']) ?></small>
            </div>
            <p class="mb-1 muted-small"><?= htmlspecialchars(strlen($n['message'])>140 ? substr($n['message'],0,140).'...' : $n['message']) ?></p>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Calendar, Subjects, Batches -->
  <div class="col-lg-8">
    <div class="card p-3 mb-4">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">📅 Academic Calendar</h5>
        <small class="muted-small">Ordered by start date</small>
      </div>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr><th>Description</th><th>Start Date</th><th>End Date</th><th>Added</th></tr>
          </thead>
          <tbody>
            <?php while($row = $calendar_res->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['start_date']) ?></td>
                <td><?= htmlspecialchars($row['end_date'] ?? '') ?></td>
                <td class="muted-small"><?= htmlspecialchars($row['created_at']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <div class="card p-3">
          <h6>Your Subjects</h6>
          <?php if(empty($subjects)): ?>
            <p class="muted-small">No subject allocation found.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach($subjects as $s): ?>
                <li class="list-group-item">
                  <strong><?= htmlspecialchars($s['subject_name']) ?></strong><br>
                  <span class="muted-small"><?= htmlspecialchars($s['class_name']) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-3">
          <h6>Your Batches (Counsellor)</h6>
          <?php if(empty($batches)): ?>
            <p class="muted-small">No batch counsellor allocation found.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach($batches as $b): ?>
                <li class="list-group-item"><?= htmlspecialchars($b['batch_name']) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>