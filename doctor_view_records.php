<?php
session_start();
$conn = new mysqli("localhost", "root", "", "eyeris");

// Check login and role
if (!isset($_SESSION['doctor_id']) || $_SESSION['role'] !== 'doctor') {
    echo "Access denied. Please log in as a doctor.";
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$selected_patient = $_GET['patient'] ?? null;

// Fetch distinct patients who chatted with the doctor
$stmt = $conn->prepare("SELECT DISTINCT username FROM messages WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$patientsResult = $stmt->get_result();
$patientUsernames = [];
while ($row = $patientsResult->fetch_assoc()) {
    $patientUsernames[] = $row['username'];
}

// Fetch test records if patient selected and is valid
$records = [];
if ($selected_patient && in_array($selected_patient, $patientUsernames)) {
    $userStmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $userStmt->bind_param("s", $selected_patient);
    $userStmt->execute();
    $userResult = $userStmt->get_result();

    if ($userRow = $userResult->fetch_assoc()) {
        $user_id = $userRow['user_id'];

        $recordStmt = $conn->prepare("SELECT test_type, result, test_date, notes FROM eye_test_records WHERE user_id = ? ORDER BY test_date DESC");
        $recordStmt->bind_param("i", $user_id);
        $recordStmt->execute();
        $records = $recordStmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>EyeRis Shield - View Records</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #000428, #004e92);
            color: #333;
        }

        header {
            background-color: #00274d;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            width: 90px;
            margin-right: 10px;
        }

        header .header-title {
            display: flex;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #f4a261;
        }

        .nav-links a.active {
            background-color:rgb(114, 175, 241); /* Active color */
            font-weight: bold;
        }

        .container { display: flex; height: 100vh; }

        .sidebar {
            width: 250px;
            background: #003366;
            color: white;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h3 { margin-top: 0; }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            padding: 8px;
            background: #0055aa;
            border-radius: 5px;
        }
        .sidebar a:hover { background: #3399ff; }

        .content {
            flex: 1;
            background: #f0f8ff;
            padding: 20px;
            overflow-y: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgb(177, 222, 242);
        }
        th, td {
            padding: 12px;
            border: 1px solid #000;
            text-align: left;
        }
        th {
            background-color: #00274d;
            color: white;
        }
        h1 {
            margin-top: 0;
        }

        footer {
            background-color: #00274d;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }

        footer .social-links {
            margin-top: 10px;
        }

        footer .social-links a {
            color: #f4a261;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }

        footer .social-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <div class="header-title">
        <img src="images/logo.jpg" alt="Logo">
        <h1>EyeRis Shield</h1>
        <img src="images/pantai_hosp.jpeg" alt="PHLogo" style="margin-left: 30px; height: 70px; width: 190px;">
    </div>
    <nav class="nav-links">
        <a href="doctorhomepage.php">Dashboard</a>
        <a href="doctor_chat.php">Chats</a>
        <a href="doctor_view_records.php">View Records</a>
        <a href="logout.php" style="display: inline-block; padding: 10px 25px; background:red; color: white; text-decoration: none; border: none;">Log Out</a>
    </nav>
</header>

<div class="container">
    <!-- Sidebar with patients -->
    <div class="sidebar">
    <h3>Patients</h3>
    <?php foreach ($patientUsernames as $username): ?>
            <a href="?patient=<?= urlencode($username) ?>" class="<?= $username === $selected_patient ? 'active' : '' ?>">
                <?= htmlspecialchars($username) ?>
            </a>
    <?php endforeach; ?>
    </div>

    <div class="content">
        <h1>Test Records</h1>
        <?php if ($selected_patient): ?>
            <h3>Viewing records for: <?= htmlspecialchars($selected_patient) ?></h3>
            <?php if ($records && $records->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Test Type</th>
                            <th>Result</th>
                            <th>Date</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $records->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['test_type']) ?></td>
                                <td><?= htmlspecialchars($row['result']) ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($row['test_date'])) ?></td>
                                <td><?= htmlspecialchars($row['notes']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No test records found for this patient.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Please select a patient from the sidebar to view their records.</p>
        <?php endif; ?>
    </div>

</div>

<footer>
    &copy; 2025 EyeRis Shield | <a href="#" style="color: #f4a261;">Privacy Policy</a>
    <div class="social-links">
        <a href="https://facebook.com">Facebook</a>
        <a href="https://instagram.com">Instagram</a>
        <a href="https://wa.link/2zestt">Contact Us</a>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(link => {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.classList.add('active');
         }
    });
 });
</script>

</body>
</html>