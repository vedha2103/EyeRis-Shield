<?php

session_start();

$conn = new mysqli("localhost", "root", "", "eyeris");

$result = $conn->query("SELECT * FROM doctors");

// Handle file upload
    $profile_image = "";
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = basename($_FILES['profile_image']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid("profile_", true) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $profile_image = $destPath;
            } else {
                $message = "Error moving uploaded file.";
            }
        } else {
            $message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EyeRis Shield</title>
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

        .nav-links a.active {
            background-color:rgb(114, 175, 241); /* Active color */
            font-weight: bold;
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
            max-width: 100%;
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
            max-width: 100%;
            text-align: justify;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 2 columns */
            gap: 20px;
            max-width: 100%;
            margin: 0 auto;
        }
        .doctor-card {
            background: #ffffff;
            color: rgb(0, 0, 0);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .doctor-card:hover {
            transform: scale(1.02);
        }
        .doctor-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #4c90ff;
        }
        .doctor-name {
            font-size: 20px;
            font-weight: bold;
        }
        .doctor-specialty, .doctor-availability {
            font-size: 14px;
            color: #555;
        }
        .start-chat {
            margin-top: 15px;
        }
        .start-chat input[type="text"] {
            padding: 5px;
            width: 80%;
            margin-bottom: 10px;
        }
        .start-chat button {
            padding: 8px 16px;
            background: #4c90ff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .start-chat button:hover {
            background: #3c76d6;
        }

        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 90%; margin: 30px auto; }

        .card { border: 1px solid #ccc; padding: 15px; border-radius: 10px; text-align: center; background: #fff; color:rgb(0, 0, 0); }

        .card p {
            font-size: 14px;
            margin: 5px 0;
            color: #333;
        }

        .card img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }

        button { margin-top: 10px; padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 5px; }

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
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- User is logged in -->
        <a href="dashboard.php">Dashboard</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php">Vision Testing</a>
        <a href="advice.php">Vision Advice and Assistance</a>
        <a href="exercises.php">Exercises and Tips</a>
        <a href="records.php">Testing Records and History</a>
        <a href="logout.php" style="display: inline-block; padding: 10px 25px; background:red; color: white; text-decoration: none; border: none;">Log Out</a>
    <?php else: ?>
        <!-- User is not logged in -->
        <a href="index.php">Home</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php" id="testing-link">Vision Testing</a>
        <a href="advice.php" id="advice-link">Vision Advice and Assistance</a>
        <a href="exercises.php">Exercises and Tips</a>
        <a href="login.php" style="display: inline-block; padding: 10px 25px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;">Log in</a>
    <?php endif; ?>
</nav>
</header>

<section class="section">
    <h2>Vision Advice and Assistance</h2>
    <h3 style="font-size: 30px;">Select a Doctor to Chat With</h3>
    <div class="grid">
        <?php while ($doctor = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($doctor['profile_image']) ?>" alt="Profile Image">
                <h3><?= htmlspecialchars($doctor['full_name']) ?></h3>
                <p><strong>Qualifications:</strong> <?= htmlspecialchars($doctor['qualifications']) ?></p>
                <p><strong>Languages:</strong> <?= htmlspecialchars($doctor['languages']) ?></p>
                <form method="GET" action="chat.php">
                    <input type="hidden" name="doctor_id" value="<?= $doctor['doctor_id'] ?>">
                    <button type="submit">Chat</button>
                </form>
            </div>
        <?php endwhile; ?>
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
    document.addEventListener("DOMContentLoaded", function () {
        const testingLink = document.getElementById("testing-link");
        const adviceLink = document.getElementById("advice-link");

        function showAccountAlert(e) {
            e.preventDefault();
            alert("Please create an account or log in to access this feature.");
            // Optional: Redirect to login page after alert
            // window.location.href = 'login.php';
        }

        testingLink.addEventListener("click", showAccountAlert);
        adviceLink.addEventListener("click", showAccountAlert);

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