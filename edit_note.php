<?php
session_start();
require_once 'inc/db.php';
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$note_id = $_GET['id'];
//گرفتن نوت
$sql="SELECT * FROM `notes` WHERE `note_id`='$note_id' AND `user_id`='$user_id'";
$result=mysqli_query($con,$sql);
$note  =mysqli_fetch_assoc($result);
if(!$note){
    echo 'Note not found.';
    exit;
}
if(isset($_POST['update'])){
    $title=$_POST['title'];
    $content=$_POST['content'];
    $sql="UPDATE notes SET `note_title`='$title', `note_content`='$content' WHERE `note_id`='$note_id' AND `user_id`='$user_id'";
    $result=mysqli_query($con,$sql);
    header("Location:panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h3 class="card-title mb-4">Edit Note</h3>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($note['note_title']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="6" class="form-control" required><?= htmlspecialchars($note['note_content']) ?></textarea>
                </div>

                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="panel.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>