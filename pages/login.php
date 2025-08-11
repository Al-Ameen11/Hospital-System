<?php include '../includes/header.php'; include '../includes/db.php';
$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = esc($_POST['email']);
    $password = $_POST['password'];
    if(!$email || !$password){ $msg = 'Enter credentials'; }
    else {
        $stmt = $conn->prepare('SELECT patient_id,password,name FROM patients WHERE email=? LIMIT 1');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($pid,$hash,$name);
        if($stmt->fetch()){
            if(password_verify($password,$hash)){
                $_SESSION['patient_id'] = $pid;
                $_SESSION['patient_name'] = $name;
                header('Location: /hospital-system/index.php'); exit;
            } else { $msg='Invalid credentials'; }
        } else { $msg='User not found'; }
    }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h4>Patient Login</h4>
        <?php if($msg): ?><div class="alert alert-danger"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" onsubmit="return validateLogin()">
          <div class="mb-2"><input id="email" name="email" class="form-control" placeholder="Email"></div>
          <div class="mb-2"><input id="password" name="password" type="password" class="form-control" placeholder="Password"></div>
          <button class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>


