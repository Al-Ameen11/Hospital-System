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

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h4>Book Appointment</h4>
        <?php if($msg): ?><div class="alert alert-info"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" onsubmit="return validateAppointment()">
          <div class="mb-2">
            <select id="doctor_id" name="doctor_id" class="form-select">
              <option value="">Select Doctor</option>
              <?php while($d=$doctors->fetch_assoc()): ?>
                <option value="<?=$d['doctor_id']?>" <?=($selected_doctor== $d['doctor_id'])? 'selected':''?>><?=htmlspecialchars($d['name']).' - '.htmlspecialchars($d['specialization'])?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-2"><input id="appointment_date" name="appointment_date" type="date" class="form-control"></div>
          <div class="mb-2"><input id="appointment_time" name="appointment_time" type="time" class="form-control"></div>
          <button class="btn btn-primary">Request Appointment</button>
        </form>
      </div>
    </div>
  </div>
</div>

