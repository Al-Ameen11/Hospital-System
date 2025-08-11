<?php include '../includes/header.php'; include '../includes/db.php';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])){
    $action = $_POST['action'];
    if($action==='add'){
        $name = esc($_POST['name']); $spec = esc($_POST['specialization']); $days = esc($_POST['available_days']); $time = esc($_POST['available_time']); $contact = esc($_POST['contact']);
        $ins = $conn->prepare('INSERT INTO doctors (name,specialization,available_days,available_time,contact) VALUES (?,?,?,?,?)');
        $ins->bind_param('sssss',$name,$spec,$days,$time,$contact);
        $ins->execute();
    }
    if($action==='delete' && !empty($_POST['doctor_id'])){
        $stmt = $conn->prepare('DELETE FROM doctors WHERE doctor_id=?'); $stmt->bind_param('i',$_POST['doctor_id']); $stmt->execute();
    }
}
$res = $conn->query('SELECT * FROM doctors');
?>

<h3>Doctors</h3>
<div class="mb-3">
  <button class="btn btn-sm btn-success" data-bs-toggle="collapse" data-bs-target="#addDoc">Add Doctor</button>
  <div id="addDoc" class="collapse mt-2">
    <form method="post" class="row g-2">
      <input type="hidden" name="action" value="add">
      <div class="col-md-3"><input name="name" class="form-control" placeholder="Name"></div>
      <div class="col-md-3"><input name="specialization" class="form-control" placeholder="Specialization"></div>
      <div class="col-md-2"><input name="available_days" class="form-control" placeholder="Mon-Fri"></div>
      <div class="col-md-2"><input name="available_time" class="form-control" placeholder="09:00-17:00"></div>
      <div class="col-md-2"><input name="contact" class="form-control" placeholder="Contact"></div>
      <div class="col-12"><button class="btn btn-primary btn-sm">Save</button></div>
    </form>
  </div>
</div>

<table class="table table-bordered">
  <thead><tr><th>Name</th><th>Spec</th><th>Days</th><th>Time</th><th>Contact</th><th>Action</th></tr></thead>
  <tbody>
  <?php while($d = $res->fetch_assoc()): ?>
    <tr>
      <td><?=htmlspecialchars($d['name'])?></td>
      <td><?=htmlspecialchars($d['specialization'])?></td>
      <td><?=htmlspecialchars($d['available_days'])?></td>
      <td><?=htmlspecialchars($d['available_time'])?></td>
      <td><?=htmlspecialchars($d['contact'])?></td>
      <td>
        <form method="post" style="display:inline-block">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="doctor_id" value="<?=$d['doctor_id']?>">
          <button class="btn btn-danger btn-sm" onclick="return confirm('Delete doctor?')">Delete</button>
        </form>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

