<?php
session_start();

// Simple hardcoded admin credentials
$admin_email = "admin@hospital.com";
$admin_pass = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if ($email === $admin_email && $pass === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<style>
body {
    background: #121212;
    color: white;
}
.card {
    background: #1f1f1f;
    border-radius: 12px;
    padding: 20px;
    margin-top: 100px;
}
input {
    background: #2c2c2c;
    color: white;
    border: none;
}
button {
    background: #6a5acd;
    border: none;
}
</style>
</head>
<body>
<div class="container">
<div class="row justify-content-center">
<div class="col-md-4">
<div class="card">
<h3 class="text-center">Admin Login</h3>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
<div class="form-group mb-2">
<input type="email" name="email" class="form-control" placeholder="Email" required>
</div>
<div class="form-group mb-3">
<input type="password" name="password" class="form-control" placeholder="Password" required>
</div>
<button type="submit" class="btn btn-primary w-100">Login</button>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
