<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location:login.php');
    exit;
}
require_once 'inc/db.php';
$user_id=$_SESSION['user_id'];
$sql="SELECT * FROM `users` WHERE `user_id`= '$user_id' ";
$result=mysqli_query($con,$sql);
$user=mysqli_fetch_assoc($result);
if(isset($_POST['save_changes'])){
    $name=$_POST['name'];
    $bio=$_POST['bio'];
    if(!empty($_FILES['profile_pic']['name'])){
        $img_name=$_FILES['profile_pic']['name'];
        $img_tmp=$_FILES['profile_pic']['tmp_name'];
        $img_path='uploads/'.time().'_'.$img_name;
        move_uploaded_file($img_tmp,$img_path);
    }else{
        $img_path=$user['profile_pic'];
    }
    $update_sql="UPDATE `users` SET `name`='$name', `bio`='$bio',`profile_pic`='$img_path' WHERE `user_id`='$user_id'";
    if(mysqli_query($con,$update_sql)){
        $message="Profile updated successfully.";
        //گرفتن دوباره اطلاعات ک اپدیت شدن
        $result=mysqli_query($con,$sql);
        $user=mysqli_fetch_assoc($result);
    }else{
        $message="Eror updating profile.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Edit Profile</h3>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bio:</label>
                    <textarea name="bio" class="form-control" rows="4"><?=$user['bio'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Picture:</label>
                    <input type="file" name="profile_pic" class="form-control">
                </div>
                <?php if (!empty($user['profile_pic'])): ?>
                    <div class="mb-3 text-center">
                        <img src="<?= $user['profile_pic'] ?>" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                <?php endif; ?>
                <div class="d-grid">
                    <button type="submit" name="save_changes" class="btn btn-primary mb-3">Save</button>
                    <a href="panel.php" class="btn btn-primary">Back to panel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Optional Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>