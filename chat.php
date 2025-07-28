<?php

session_start(); // <-- Add this

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "eyeris");
$conn->set_charset("utf8mb4");


$doctor_id = $_GET['doctor_id'];
$patient = $_SESSION['username']; 

// Insert message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $sender = $_POST['sender'];

    $stmt = $conn->prepare("INSERT INTO messages (username, doctor_id, message, sender_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $patient, $doctor_id, $message, $sender);
    $stmt->execute();
}

// Get doctor name
$doctor = $conn->query("SELECT full_name FROM doctors WHERE doctor_id = $doctor_id")->fetch_assoc();

// Fetch messages using correct column name
$messages = $conn->query("SELECT * FROM messages WHERE username='$patient' AND doctor_id=$doctor_id ORDER BY timestamp ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?= htmlspecialchars($doctor['full_name']) ?></title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #1cbbff;
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

        .banner {
            text-align: center;
            margin: 20px auto;
            max-width: 100%;
        }

        .banner img {
            width: 100%;
            height: auto;
        }

        .section {
            padding: 60px 20px;
            text-align: center;
            background: #1cbbff;
            color: white;
        }

        .section h2 {
            font-size: 50px;
            margin-bottom: 30px;
        }

        .section p {
            font-size: 20px;
            color: #e6e9f0;
            line-height: 1.8;
            margin: 0 auto 30px auto;
            max-width: 800px;
            text-align: justify;
        }

        .chat-container {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .chat-header {
            background: #4c90ff;
            color: black;
            padding: 15px;
            font-size: 18px;
        }
        .chat-messages {
            height: 400px;
            padding: 20px;
            overflow-y: scroll;
            background: #f9f9f9;
        }
        .message {
            margin: 10px 0;
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 20px;
            clear: both;
            word-wrap: break-word;
        }
        .doctor {
            background: #e0f7e9;
            float: left;
            color: black;
        }
        .patient {
            background: rgb(104, 167, 255);
            float: right;
            text-align: right;
            color: black;
        }
        .chat-input {
            display: flex;
            padding: 15px;
            border-top: 1px solid #ccc;
            background: #fff;
        }
        .chat-input textarea {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
            font-size: 14px;
        }
        .chat-input button {
            margin-left: 10px;
            padding: 10px 20px;
            background: #4c90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background: #3b74d3;
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
    <header>
    <div class="header-title">
        <img src="images/logo.jpg" alt="Logo">
        <h1>EyeRis Shield</h1>
        <img src="images/pantai_hosp.jpeg" alt="PHLogo" style="margin-left: 30px; height: 70px; width: 190px;">
    </div>
    <nav class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php">Vision Testing</a>
        <a href="advice.php">Vision Advice and Assistance</a>
        <a href="exercises.php">Exercises and Tips</a>
        <a href="records.php">Testing Records and History</a>
        <a href="logout.php" style="display: inline-block; padding: 10px 25px; background:red; color: white; text-decoration: none; border: none;">Log Out</a>
    </nav>
</header>

<section class="section">
    <div class="chat-container">
    <div class="chat-header">
        <?= htmlspecialchars($doctor['full_name']) ?>
    </div>

    <div class="chat-messages" id="chatBox">
        <?php while ($msg = $messages->fetch_assoc()): ?>
            <div class="message <?= $msg['sender_type'] ?>">
                <?= nl2br(htmlspecialchars($msg['message'])) ?>
                <br>
                <small style="font-size:10px; color:#000;">
                    <?= $msg['timestamp'] ?>
                </small>
            </div>
            <div style="clear:both;"></div>
        <?php endwhile; ?>
    </div>

    <form class="chat-input" method="POST">
        <textarea name="message" rows="2" required placeholder="Type your message..."></textarea>
        <input type="hidden" name="sender" value="patient">
        <button type="submit">Send</button>
    </form>
    <p style="font-size: 18px; font-family:Times New Roman; color: black; text-align: center;">To access keyboard emoji pickers;<br>
        on Windows: Win + . | on Mac: Cmd + Ctrl + Space | on Mobile: keyboards with emoji tabs
    </p>
</div>

</section>

<footer>
    &copy; 2025 EyeRis Shield | <a href="#" style="color: #f4a261;">Privacy Policy</a>
    <div class="social-links">
        <a href="https://facebook.com">Facebook</a>
        <a href="https://instagram.com">Instagram</a>
        <a href="https://wa.link/2zestt">Contact Us</a>
    </div>
</footer>

<script>

    // Auto scroll to bottom
    var chatBox = document.getElementById("chatBox");
    chatBox.scrollTop = chatBox.scrollHeight;

</script>

</body>
</html>