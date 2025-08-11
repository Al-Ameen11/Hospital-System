<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<h1 class="mb-3">Find a Doctor</h1>
<form method="get" class="row g-2 mb-4">
  <div class="col-md-4">
    <input class="form-control" name="q" placeholder="Search by specialization or name" value="<?= isset($_GET['q'])?htmlspecialchars($_GET['q']):'' ?>">
  </div>
  <div class="col-auto"><button class="btn btn-primary">Search</button></div>
</form>

<div class="row">
  <?php
  $q = '';
  if(!empty($_GET['q'])){
    $q = esc($_GET['q']);
    $sql = "SELECT * FROM doctors WHERE name LIKE '%$q%' OR specialization LIKE '%$q%'";
  } else {
    $sql = "SELECT * FROM doctors";
  }
  $res = $conn->query($sql);
  if($res->num_rows>0){
    while($d = $res->fetch_assoc()):
  ?>
  <div class="col-md-4">
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title"><?=htmlspecialchars($d['name'])?></h5>
        <p class="card-text">Specialization: <?=htmlspecialchars($d['specialization'])?></p>
        <p class="card-text">Available: <?=htmlspecialchars($d['available_days'])?> | <?=htmlspecialchars($d['available_time'])?></p>
        <a href="/hospital-system/pages/book_appointment.php?doctor_id=<?=$d['doctor_id']?>" class="btn btn-sm btn-primary">Book</a>
      </div>
    </div>
  </div>
  <?php
    endwhile;
  } else {
    echo '<p class="text-muted">No doctors found.</p>';
  }
  ?>
</div>

