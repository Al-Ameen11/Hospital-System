<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<div class="rounded-xl bg-app-surface border border-app-border p-8 mb-6">
  <div class="py-6">
    <h1 class="text-3xl md:text-4xl font-bold text-white">Smart Healthcare, Seamless Appointments</h1>
    <p class="mt-3 max-w-2xl text-gray-300">Find the right doctor, book appointments in seconds, and manage your healthcare effortlessly.</p>
    <div class="mt-5 flex flex-wrap items-center gap-3">
      <a href="/hospital-system/pages/register.php" class="inline-flex items-center justify-center rounded-md bg-app-primary px-5 py-3 text-white hover:bg-blue-400 transition-colors">Get Started</a>
      <a href="/hospital-system/pages/book_appointment.php" class="inline-flex items-center justify-center rounded-md border border-gray-600 px-5 py-3 text-gray-100 hover:bg-gray-800 transition-colors">Book Appointment</a>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
  <div class="rounded-lg border border-app-border bg-app-surface shadow-sm">
    <div class="p-5">
      <div class="text-3xl mb-2">🩺</div>
      <h5 class="text-lg font-semibold text-white">Expert Doctors</h5>
      <p class="text-gray-300">Browse verified specialists with up-to-date availability.</p>
    </div>
  </div>
  <div class="rounded-lg border border-app-border bg-app-surface shadow-sm">
    <div class="p-5">
      <div class="text-3xl mb-2">⚡</div>
      <h5 class="text-lg font-semibold text-white">Fast Booking</h5>
      <p class="text-gray-300">Pick a date and time that fits your schedule—no calls needed.</p>
    </div>
  </div>
  <div class="rounded-lg border border-app-border bg-app-surface shadow-sm">
    <div class="p-5">
      <div class="text-3xl mb-2">🔔</div>
      <h5 class="text-lg font-semibold text-white">Status Updates</h5>
      <p class="text-gray-300">Track approval status for every appointment request.</p>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
