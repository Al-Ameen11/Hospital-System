<?php include '../includes/header.php'; include '../includes/db.php';
if(!isset($_SESSION['patient_id'])){ header('Location: /hospital-system/pages/login.php'); exit; }
$pid = $_SESSION['patient_id'];
$sql = "SELECT a.*, d.name as doctor_name, p.name as patient_name FROM appointments a JOIN doctors d ON a.doctor_id=d.doctor_id JOIN patients p ON a.patient_id=p.patient_id WHERE a.patient_id=$pid ORDER BY a.appointment_date DESC";
$res = $conn->query($sql);
?>
<h4 class="text-xl font-semibold mb-3">My Appointments</h4>
<div class="overflow-x-auto rounded-lg border border-app-border">
<table class="min-w-full divide-y divide-app-border">
  <thead class="bg-[#0c1426]">
    <tr>
      <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Doctor</th>
      <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Date</th>
      <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Time</th>
      <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Status</th>
    </tr>
  </thead>
  <tbody class="divide-y divide-app-border">
    <?php while($r = $res->fetch_assoc()): ?>
      <tr class="odd:bg-white/5">
        <td class="px-4 py-2"><?=htmlspecialchars($r['doctor_name'])?></td>
        <td class="px-4 py-2"><?=htmlspecialchars($r['appointment_date'])?></td>
        <td class="px-4 py-2"><?=htmlspecialchars($r['appointment_time'])?></td>
        <td class="px-4 py-2"><?=htmlspecialchars($r['status'])?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php include '../includes/footer.php'; ?>