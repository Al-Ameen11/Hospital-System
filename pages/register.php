<?php include '../includes/header.php'; include '../includes/db.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = esc($_POST['name']);
    $email = esc($_POST['email']);
    $phone = esc($_POST['phone']);
    $password = $_POST['password'];
    $age = (int)$_POST['age'];
    $gender = esc($_POST['gender']);

    if(!$name || !$email || !$phone || !$password){
        $msg = 'Please fill required fields';
    } else {
        $check = $conn->prepare('SELECT patient_id FROM patients WHERE email=? LIMIT 1');
        $check->bind_param('s',$email);
        $check->execute();
        $check->store_result();
        if($check->num_rows>0){ $msg='Email already registered'; }
        else {
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $ins = $conn->prepare('INSERT INTO patients (name,email,phone,password,age,gender) VALUES (?, ?, ?, ?, ?, ?)');
            $ins->bind_param('ssssis', $name, $email, $phone, $hash, $age, $gender);
            if($ins->execute()){
                $msg = 'Registration successful. You may login now.';
            } else { $msg='Error: '. $conn->error; }
        }
    }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h4>Patient Registration</h4>
        <?php if($msg): ?><div class="alert alert-info"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" onsubmit="return validateRegister()">
          <div class="mb-2"><input id="name" name="name" class="form-control" placeholder="Full name"></div>
          <div class="mb-2"><input id="email" name="email" class="form-control" placeholder="Email"></div>
          <div class="mb-2"><input id="phone" name="phone" class="form-control" placeholder="Phone"></div>
          <div class="mb-2"><input id="password" name="password" type="password" class="form-control" placeholder="Password"></div>
          <div class="mb-2 row">
            <div class="col"><input name="age" type="number" class="form-control" placeholder="Age"></div>
            <div class="col">
              <select name="gender" class="form-select">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
          <button class="btn btn-primary">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

