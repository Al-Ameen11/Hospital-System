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

<div class="flex justify-center">
  <div class="w-full max-w-xl">
    <div class="rounded-lg border border-app-border bg-app-surface">
      <div class="p-6">
        <h4 class="text-xl font-semibold mb-3">Patient Login</h4>
        <?php if($msg): ?><div class="mb-3 rounded border border-red-400 bg-red-900/30 px-4 py-2 text-red-200"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" onsubmit="return validateLogin()" class="space-y-3">
          <div><input id="email" name="email" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Email"></div>
          <div><input id="password" name="password" type="password" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Password"></div>
          <button class="inline-flex items-center rounded-md bg-app-primary px-4 py-2 text-white hover:bg-blue-400 transition-colors">Login</button>
        </form>
      </div>
    </div>
  </div>
  </div>

<?php include '../includes/footer.php'; ?>
