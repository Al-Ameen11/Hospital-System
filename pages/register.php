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

<div class="flex justify-center">
  <div class="w-full max-w-xl">
    <div class="rounded-lg border border-app-border bg-app-surface">
      <div class="p-6">
        <h4 class="text-xl font-semibold mb-3">Patient Registration</h4>
        <?php if($msg): ?><div class="mb-3 rounded border border-blue-400 bg-blue-900/30 px-4 py-2 text-blue-200"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" onsubmit="return validateRegister()" class="space-y-3">
          <div><input id="name" name="name" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Full name"></div>
          <div><input id="email" name="email" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Email"></div>
          <div><input id="phone" name="phone" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Phone"></div>
          <div><input id="password" name="password" type="password" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Password"></div>
          <div class="grid grid-cols-2 gap-3">
            <div><input name="age" type="number" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Age"></div>
            <div>
              <select name="gender" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
          <button class="inline-flex items-center rounded-md bg-app-primary px-4 py-2 text-white hover:bg-blue-400 transition-colors">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>