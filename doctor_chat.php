<?php
session_start();
$conn = new mysqli("localhost", "root", "", "eyeris");

// Check login and role
if (!isset($_SESSION['doctor_id']) || $_SESSION['role'] !== 'doctor') {
    echo "Access denied. Please log in as a doctor.";
    exit();
}

// Fetch session data
$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['full_name'];
$doctor_image = $_SESSION['profile_image'];
$selected_patient = $_GET['patient'] ?? null;

// Handle message send
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['patient'])) {
    $message = $_POST['message'];
    $patient = $_POST['patient'];
    $sender = 'doctor';

    $stmt = $conn->prepare("INSERT INTO messages (username, doctor_id, message, sender_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $patient, $doctor_id, $message, $sender);
    $stmt->execute();
}

// Fetch distinct patients
$stmt = $conn->prepare("SELECT DISTINCT username FROM messages WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$patientsResult = $stmt->get_result();

// Fetch chat history
$chatMessages = [];
if ($selected_patient) {
    $stmt = $conn->prepare("SELECT * FROM messages WHERE doctor_id = ? AND username = ? ORDER BY timestamp ASC");
    $stmt->bind_param("is", $doctor_id, $selected_patient);
    $stmt->execute();
    $chatMessages = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Chat</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #eef2f3; }

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

        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .topbar {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #004080;
            color: white;
        }

        .topbar img {
            height: 50px;
            width: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f0f0f0;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 10px;
            max-width: 70%;
            clear: both;
        }

        .doctor { background: #d1f7c4; float: right; }

        .patient { background: #bbdefb; float: left; }

        form {
            display: flex;
            padding: 15px;
            border-top: 1px solid #ccc;
        }

        textarea {
            flex: 1;
            resize: none;
            padding: 10px;
        }

        button {
            padding: 10px 20px;
            background: #004080;
            color: white;
            border: none;
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
    <?php while ($row = $patientsResult->fetch_assoc()): ?>
        <a href="doctor_chat.php?patient=<?= urlencode($row['username']) ?>">
            <?= htmlspecialchars($row['username']) ?>
        </a>
    <?php endwhile; ?>
    </div>

    <!-- Chat area -->
    <div class="chat-area">
        <!-- Doctor profile -->
        <div class="topbar">
            <img src="<?= htmlspecialchars($doctor_image) ?>" alt="Profile">
            <strong><?= htmlspecialchars($doctor_name) ?></strong>
        </div>

        <!-- Chat messages -->
        <div class="chat-messages">
            <?php if ($selected_patient): ?>
                <?php while ($msg = $chatMessages->fetch_assoc()): ?>
                    <div class="message <?= $msg['sender_type'] ?>">
                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                        <br><small><?= $msg['timestamp'] ?></small>
                    </div>
                    <div style="clear: both;"></div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="padding: 20px;">Please select a patient to start chatting.</p>
            <?php endif; ?>
        </div>

        <!-- Message form -->
        <?php if ($selected_patient): ?>
            <form method="POST">
                <input type="hidden" name="patient" value="<?= htmlspecialchars($selected_patient) ?>">
                <textarea name="message" rows="2" required placeholder="Type your message here..."></textarea>
                <button type="submit">Send</button>
            </form>
            <p style="font-size: 18px; font-family:Times New Roman; color: black; text-align: center;">To access keyboard emoji pickers;<br>
                on Windows: Win + . | on Mac: Cmd + Ctrl + Space | on Mobile: keyboards with emoji tabs
            </p>
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
