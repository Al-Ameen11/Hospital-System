<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Booking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ["Poppins", "ui-sans-serif", "system-ui", "-apple-system", "Segoe UI", "Roboto", "Ubuntu", "Cantarell", "Noto Sans", "Arial", "sans-serif"] },
            colors: {
              app: {
                body: "#0f172a",
                surface: "#111827",
                border: "#233047",
                primary: "#3b82f6",
              }
            }
          }
        },
        darkMode: 'class'
      }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="/hospital-system/css/theme.css" rel="stylesheet">
</head>
<body>
<nav class="bg-app-surface border-b border-app-border">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <a class="text-white font-semibold" href="/hospital-system/index.php">Hospital</a>
      <button id="navToggle" class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-app-primary" aria-controls="mobileNav" aria-expanded="false">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <div class="hidden lg:flex items-center gap-6" id="desktopNav">
        <a class="text-gray-300 hover:text-white" href="/hospital-system/index.php">Home</a>
        <?php if(isset($_SESSION['patient_id'])): ?>
          <a class="text-gray-300 hover:text-white" href="/hospital-system/pages/book_appointment.php">Book Appointment</a>
          <a class="text-gray-300 hover:text-white" href="/hospital-system/pages/my_appointments.php">My Appointments</a>
          <a class="text-gray-300 hover:text-white" href="/hospital-system/pages/logout.php">Logout</a>
        <?php else: ?>
          <a class="text-gray-300 hover:text-white" href="/hospital-system/pages/register.php">Register</a>
          <a class="text-gray-300 hover:text-white" href="/hospital-system/pages/login.php">Login</a>
        <?php endif; ?>
        <a class="text-gray-300 hover:text-white" href="/hospital-system/pages/admin_dashboard.php">Admin</a>
      </div>
    </div>
  </div>
  <div class="lg:hidden hidden" id="mobileNav">
    <div class="space-y-1 px-4 pb-4">
      <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/index.php">Home</a>
      <?php if(isset($_SESSION['patient_id'])): ?>
        <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/pages/book_appointment.php">Book Appointment</a>
        <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/pages/my_appointments.php">My Appointments</a>
        <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/pages/logout.php">Logout</a>
      <?php else: ?>
        <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/pages/register.php">Register</a>
        <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/pages/login.php">Login</a>
      <?php endif; ?>
      <a class="block rounded px-3 py-2 text-gray-300 hover:text-white hover:bg-gray-800" href="/hospital-system/pages/admin_dashboard.php">Admin</a>
    </div>
  </div>
</nav>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
