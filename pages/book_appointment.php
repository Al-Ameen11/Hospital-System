<?php include '../includes/header.php'; include '../includes/db.php';
if(!isset($_SESSION['patient_id'])){ header('Location: /hospital-system/pages/login.php'); exit; }
$msg='';
$selected_doctor = isset($_GET['doctor_id'])? (int)$_GET['doctor_id'] : 0;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $patient_id = $_SESSION['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $appointment_date = esc($_POST['appointment_date']);
    $appointment_time = esc($_POST['appointment_time']);
    $chk = $conn->prepare('SELECT appointment_id FROM appointments WHERE doctor_id=? AND appointment_date=? AND appointment_time=? AND status<>"cancelled"');
    $chk->bind_param('iss',$doctor_id,$appointment_date,$appointment_time);
    $chk->execute(); $chk->store_result();
    if($chk->num_rows>0){ $msg='Selected slot is already booked. Please choose another.'; }
    else {
        $ins = $conn->prepare('INSERT INTO appointments (patient_id,doctor_id,appointment_date,appointment_time,status) VALUES (?,?,?,?,"pending")');
        $ins->bind_param('iiss',$patient_id,$doctor_id,$appointment_date,$appointment_time);
        if($ins->execute()) $msg='Appointment requested successfully. Waiting for admin approval.';
        else $msg='Error: '.$conn->error;
    }
}
$doctors = $conn->query('SELECT * FROM doctors');
?>

<div class="flex justify-center">
  <div class="w-full max-w-xl">
    <div class="rounded-lg border border-app-border bg-app-surface">
      <div class="p-6">
        <h4 class="text-xl font-semibold mb-3">Book Appointment</h4>
        <?php if($msg): ?><div class="mb-3 rounded border border-blue-400 bg-blue-900/30 px-4 py-2 text-blue-200"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" onsubmit="return validateAppointment()" class="space-y-3">
          <div>
            <select id="doctor_id" name="doctor_id" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Doctor</option>
              <?php while($d=$doctors->fetch_assoc()): ?>
                <option value="<?=$d['doctor_id']?>" <?=($selected_doctor== $d['doctor_id'])? 'selected':''?>><?=htmlspecialchars($d['name']).' - '.htmlspecialchars($d['specialization'])?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div><input id="appointment_date" name="appointment_date" type="date" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></div>
          <div><input id="appointment_time" name="appointment_time" type="time" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></div>
          <button class="inline-flex items-center rounded-md bg-app-primary px-4 py-2 text-white hover:bg-blue-400 transition-colors">Request Appointment</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>