<?php
session_start();
require 'inc/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO notes (note_title, note_content, user_id) VALUES ('$title', '$content', $user_id)";
        mysqli_query($con, $sql);
      
    }
      header("Location:panel.php");
        exit;
}

$notes_query = "SELECT * FROM `notes` WHERE `user_id` = '$user_id'";
$notes_result = mysqli_query($con, $notes_query);
$profile_sql="SELECT `name`,`profile_pic`FROM `users` WHERE `user_id`='$user_id'";
$profile_result=mysqli_query($con,$profile_sql);
$profile_user=mysqli_fetch_assoc($profile_result);
$profile_pic=$profile_user['profile_pic'];
$default_pic='assets/img/default-avatar.jpg';
if(!empty($profile_user['profile_pic'])){
    $profile_image=$profile_user['profile_pic'];
}else{
    $profile_image=$default_pic;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Evernote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
  <div class="row">
    <!-- 🧑‍💼 پروفایل کاربر -->
    <div class="col-md-3">
      <div class="card text-center shadow">
        <img src="<?= $profile_image ?>" class="card-img-top rounded-circle mx-auto mt-3" style="width:120px; height:120px; object-fit:cover;" alt="Profile">
        <div class="card-body">
          <h4 class="card-title mb-3"><?=htmlspecialchars($profile_user['name']) ?></h4>
          <a href="profile.php" class="btn btn-m btn-outline-primary mb-3">Edit Profile</a>
          <a href="logout.php" class="btn btn-m btn-outline-danger mb-3">Logout</a>
        </div>
      </div>
    </div>

    <!-- 📝 فرم و نوت‌ها -->
    <div class="col-md-9">
      <!-- فرم نوت جدید -->
      <div class="card shadow mb-4">
        <div class="card-body">
          <h4 class="card-title mb-3 text-center">Add New Note</h4>
          <form method="post">
            <input type="text" name="title" class="form-control mb-2 p-3" placeholder="Note Title">
            <textarea name="content" class="form-control mb-2 p-3" placeholder="Write your note..."></textarea>
            <button type="submit" name="add" class="btn btn-primary">Add Note</button>
          </form>
        </div>
      </div>

      <!-- نوت‌ها به صورت شبکه‌ای و مرتب -->
      <div class="row">
        <?php while ($note = mysqli_fetch_assoc($notes_result)): ?>
          <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
              <div class="card-body">
                <h5><?= htmlspecialchars($note['note_title']) ?></h5>
                <p><?= nl2br(htmlspecialchars($note['note_content'])) ?></p>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <small><?= $note['create_date'] ?></small>
                <div>
                  <a href="edit_note.php?id=<?= $note['note_id'] ?>" class="btn btn-sm btn-outline-success">Edit</a>
                  <a href="delete_note.php?id=<?= $note['note_id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>









