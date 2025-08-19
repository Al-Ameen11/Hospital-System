<?php include '../includes/header.php'; include '../includes/db.php';

// Hardcoded admin credentials (demo purposes)
$admin_email = 'admin@hospital.com';
$admin_pass = 'admin123';

// Handle admin authentication
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auth']) && $_POST['auth'] === 'login') {
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$pass  = isset($_POST['password']) ? $_POST['password'] : '';
	if ($email === $admin_email && $pass === $admin_pass) {
		$_SESSION['admin_logged_in'] = true;
		header('Location: /hospital-system/pages/admin_dashboard.php');
		exit;
	} else {
		$login_error = 'Invalid email or password.';
	}
}

// Handle admin logout
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
	unset($_SESSION['admin_logged_in']);
	header('Location: /hospital-system/pages/admin_dashboard.php');
	exit;
}

// Guard: Only allow management actions if admin is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
		$action = $_POST['action'];
		// Appointments actions
		if (($action === 'approve' || $action === 'cancel') && !empty($_POST['appointment_id'])) {
			$appointmentId = (int)$_POST['appointment_id'];
			$newStatus = $action === 'approve' ? 'approved' : 'cancelled';
			$up = $conn->prepare('UPDATE appointments SET status=? WHERE appointment_id=?');
			$up->bind_param('si', $newStatus, $appointmentId);
			$up->execute();
		}
		// Doctors actions (add/delete)
		if ($action === 'add') {
			$name = esc($_POST['name']);
			$spec = esc($_POST['specialization']);
			$days = esc($_POST['available_days']);
			$time = esc($_POST['available_time']);
			$contact = esc($_POST['contact']);
			$ins = $conn->prepare('INSERT INTO doctors (name,specialization,available_days,available_time,contact) VALUES (?,?,?,?,?)');
			$ins->bind_param('sssss', $name, $spec, $days, $time, $contact);
			$ins->execute();
		}
		if ($action === 'delete' && !empty($_POST['doctor_id'])) {
			$docId = (int)$_POST['doctor_id'];
			$stmt = $conn->prepare('DELETE FROM doctors WHERE doctor_id=?');
			$stmt->bind_param('i', $docId);
			$stmt->execute();
		}
	}
}
?>

<?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true): ?>
	<div class="flex justify-center">
		<div class="w-full max-w-md">
			<div class="rounded-lg border border-app-border bg-app-surface">
				<div class="p-6">
					<h4 class="text-xl font-semibold mb-3">Admin Login</h4>
					<?php if ($login_error): ?><div class="mb-3 rounded border border-red-400 bg-red-900/30 px-4 py-2 text-red-200"><?= htmlspecialchars($login_error) ?></div><?php endif; ?>
					<form method="post" class="space-y-3">
						<input type="hidden" name="auth" value="login">
						<div><input type="email" name="email" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="Email" required></div>
						<div><input type="password" name="password" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="Password" required></div>
						<button class="w-full inline-flex items-center justify-center rounded-md bg-app-primary px-4 py-2 text-white hover:bg-blue-400">Login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="flex items-center justify-between mb-4">
		<h3 class="text-2xl font-semibold">Admin Dashboard</h3>
		<a class="inline-flex items-center rounded-md border border-gray-600 px-4 py-2 text-gray-100 hover:bg-gray-800" href="/hospital-system/pages/admin_dashboard.php?logout=1">Logout</a>
	</div>

	<!-- Appointments Management -->
	<div class="rounded-lg border border-app-border bg-app-surface mb-6">
		<div class="p-5">
			<h5 class="text-lg font-semibold mb-3">Manage Appointments</h5>
			<div class="overflow-x-auto rounded-lg border border-app-border">
				<table class="min-w-full divide-y divide-app-border">
					<thead class="bg-[#0c1426]">
						<tr>
							<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Patient</th>
							<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Doctor</th>
							<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Date</th>
							<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Time</th>
							<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Status</th>
							<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Action</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-app-border">
						<?php
							$apps = $conn->query('SELECT a.*, d.name AS doctor_name, p.name AS patient_name FROM appointments a JOIN doctors d ON a.doctor_id=d.doctor_id JOIN patients p ON a.patient_id=p.patient_id ORDER BY a.appointment_date DESC, a.appointment_time DESC');
							while ($row = $apps->fetch_assoc()):
						?>
						<tr class="odd:bg-white/5">
							<td class="px-4 py-2"><?= htmlspecialchars($row['patient_name']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($row['doctor_name']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($row['appointment_date']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($row['appointment_time']) ?></td>
							<td class="px-4 py-2">
								<?php $badge = $row['status']==='pending' ? 'bg-yellow-500 text-black' : ($row['status']==='approved' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'); ?>
								<span class="inline-flex items-center rounded px-2 py-1 text-xs font-medium <?= $badge ?>"><?= htmlspecialchars(ucfirst($row['status'])) ?></span>
							</td>
							<td class="px-4 py-2">
								<?php if ($row['status'] === 'pending'): ?>
									<form method="post" class="inline-block">
										<input type="hidden" name="action" value="approve">
										<input type="hidden" name="appointment_id" value="<?= (int)$row['appointment_id'] ?>">
										<button class="inline-flex items-center rounded-md bg-green-600 px-3 py-1.5 text-sm text-white hover:bg-green-500">Approve</button>
									</form>
									<form method="post" class="inline-block" onsubmit="return confirm('Cancel this appointment?')">
										<input type="hidden" name="action" value="cancel">
										<input type="hidden" name="appointment_id" value="<?= (int)$row['appointment_id'] ?>">
										<button class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm text-white hover:bg-red-500">Cancel</button>
									</form>
								<?php else: ?>
									<em class="text-gray-400">N/A</em>
								<?php endif; ?>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Doctors Management -->
	<div class="rounded-lg border border-app-border bg-app-surface">
		<div class="p-5">
			<h5 class="text-lg font-semibold mb-3">Manage Doctors</h5>
			<button id="toggleAddDoc" class="mb-3 inline-flex items-center rounded-md bg-green-600 px-3 py-1.5 text-sm text-white hover:bg-green-500">Add Doctor</button>
			<div id="addDoc" class="hidden">
				<form method="post" class="grid grid-cols-1 md:grid-cols-5 gap-2">
					<input type="hidden" name="action" value="add">
					<div><input name="name" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="Name"></div>
					<div><input name="specialization" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="Specialization"></div>
					<div><input name="available_days" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="Mon-Fri"></div>
					<div><input name="available_time" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="09:00-17:00"></div>
					<div><input name="contact" class="w-full rounded-md bg-gray-900 border border-app-border text-gray-100 px-3 py-2" placeholder="Contact"></div>
					<div class="md:col-span-5"><button class="inline-flex items-center rounded-md bg-app-primary px-4 py-2 text-sm text-white hover:bg-blue-400">Save</button></div>
				</form>
			</div>
			<?php $docs = $conn->query('SELECT * FROM doctors'); ?>
			<div class="mt-3 overflow-x-auto rounded-lg border border-app-border">
				<table class="min-w-full divide-y divide-app-border">
					<thead class="bg-[#0c1426]"><tr>
						<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Name</th>
						<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Spec</th>
						<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Days</th>
						<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Time</th>
						<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Contact</th>
						<th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Action</th>
					</tr></thead>
					<tbody class="divide-y divide-app-border">
						<?php while ($d = $docs->fetch_assoc()): ?>
						<tr class="odd:bg-white/5">
							<td class="px-4 py-2"><?= htmlspecialchars($d['name']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($d['specialization']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($d['available_days']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($d['available_time']) ?></td>
							<td class="px-4 py-2"><?= htmlspecialchars($d['contact']) ?></td>
							<td class="px-4 py-2">
								<form method="post" class="inline-block" onsubmit="return confirm('Delete doctor?')">
									<input type="hidden" name="action" value="delete">
									<input type="hidden" name="doctor_id" value="<?= (int)$d['doctor_id'] ?>">
									<button class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm text-white hover:bg-red-500">Delete</button>
								</form>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endif; ?>
<script>
  const addDocBtn = document.getElementById('toggleAddDoc');
  const addDoc = document.getElementById('addDoc');
  if (addDocBtn && addDoc) {
    addDocBtn.addEventListener('click', () => addDoc.classList.toggle('hidden'));
  }
</script>
<?php include '../includes/footer.php'; ?>
