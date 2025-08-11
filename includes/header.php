<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/hospital-system/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/hospital-system/index.php">Hospital</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/hospital-system/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/doctors.php">Doctors</a></li>
        <?php if(isset($_SESSION['patient_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/book_appointment.php">Book Appointment</a></li>
            <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/my_appointments.php">My Appointments</a></li>
            <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/logout.php">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/login.php">Login</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="/hospital-system/pages/admin_dashboard.php">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
