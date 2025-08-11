<?php include '../includes/header.php'; include '../includes/db.php';
if(!isset($_SESSION['patient_id'])){ header('Location: /hospital-system/pages/login.php'); exit; }
$pid = $_SESSION['patient_id'];
$sql = "SELECT a.*, d.name as doctor_name, p.name as patient_name FROM appointments a JOIN doctors d ON a.doctor_id=d.doctor_id JOIN patients p ON a.patient_id=p.patient_id WHERE a.patient_id=$pid ORDER BY a.appointment_date DESC";
$res = $conn->query($sql);
?>
<h4>My Appointments</h4>
<div class="table-wrap">
<table class="table table-striped">
  <thead><tr><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
  <tbody>
    <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?=htmlspecialchars($r['doctor_name'])?></td>
        <td><?=htmlspecialchars($r['appointment_date'])?></td>
        <td><?=htmlspecialchars($r['appointment_time'])?></td>
        <td><?=htmlspecialchars($r['status'])?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>