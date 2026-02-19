<?php
include '../public/db_connect.php';  
$error = "";

if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['loginid']);
    $password = htmlspecialchars($_POST['password1']);

    
    $query = $connection->prepare("SELECT * FROM users WHERE username = :u AND password = :p");
    $query->execute(array(':u' => $username, ':p' => $password));

    if ($query->rowCount() > 0) {
        echo "<script>alert('Login Successful! Welcome Admin.'); window.location.href='../service/index.php';</script>";
        exit;
    } else {
         echo "<script>alert('Invalid username or password!!');window.location.href='../admin/login.php';</script>";
        exit;
    
    }
}
?>

<?php include '../public/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/style.css"> 
</head>
<body>
    


<div class= "pic">
<div class="login-container">
    <h2>Admin Login</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <label for="loginid">Username</label>
            <input type="text" id="loginid" name="loginid" placeholder="Enter username" required>
        </div>

        <div class="input-group">
            <label for="password1">Password</label>
            <input type="password" id="password1" name="password1" placeholder="Enter password" required>
        </div>

        <button type="submit" name="login" class="btn-login">Login</button>
    </form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>