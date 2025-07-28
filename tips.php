<?php
session_start();
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
            max-width: 80%;
            text-align: justify;
        }

        .controls {
        margin-top: 20px;
        }

        .controls button {
        margin: 5px;
        padding: 10px 20px;
        font-size: 16px;
        }

        .controls button:hover {
        background-color: #f4a261;
        color: white;
        }

        .controls button.active {
        background-color: #00274d;
        color: white;
        font-weight: bold;
        }

        .tip-section {
            display: flex;
            margin-bottom: 10px;
            margin: 0 auto 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            max-width: 80%;
        }
        .tip-section .left {
            flex: 1;
        }
        .tip-section .left img {
            width: 90%;
            height: auto;
            object-fit: cover;
        }
        .tip-section .right {
            flex: 2;
            padding: 20px;
        }

        .tip-section .right h2 {
            font-size: 40px;
        margin-top: 0;
        color: #333;
        }

        .tip-section .right ol {
        padding-left: 20px;
        color: #555;
        font-size:20px ;
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
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- User is logged in -->
        <a href="dashboard.php">Dashboard</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php">Vision Testing</a>
        <a href="advice.php">Vision Advice and Assistance</a>
        <a href="tips.php">Exercises and Tips</a>
        <a href="records.php">Testing Records and History</a>
        <a href="logout.php" style="display: inline-block; padding: 10px 25px; background:red; color: white; text-decoration: none; border: none;">Log Out</a>
    <?php else: ?>
        <!-- User is not logged in -->
        <a href="index.php">Home</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php" id="testing-link">Vision Testing</a>
        <a href="advice.php" id="advice-link">Vision Advice and Assistance</a>
        <a href="tips.php">Exercises and Tips</a>
        <a href="login.php" style="display: inline-block; padding: 10px 25px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;">Log in</a>
    <?php endif; ?>
</nav>
</header>

<section class="section">
    <h2 style="text-align: center;">Exercises and Tips</h2>
    <p style="text-align: center; margin: 0 auto; max-width: 80%;">These tips provide practical advice on maintaining eye health, including proper nutrition, regular eye exercises, safe screen usage, hygiene, routine eye checkups and many more. Whether you wear glasses, spend long hours on digital devices, or want to preserve your vision, these tips are tailored to support healthy eyes for all ages.</p>
    <div class="controls">
    <button onclick="location.href='exercises.php'">Exercises</button>
    <button class="active" onclick="location.href='tips.php'">Tips</button>
    </div>
</section>

<?php
include 'config/db.php'; 

$sql = "SELECT * FROM tips";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="tip-section">
            <div class="left">
                <img src="' . htmlspecialchars($row["tip_image_path"]) . '" alt="' . htmlspecialchars($row["tip_title"]) . '">
            </div>
            <div class="right">
                <h2>' . htmlspecialchars($row["tip_title"]) . '</h2>
                ' . $row["tip_content"] . '
            </div>
        </div>';
    }
} else {
    echo "<p style='text-align: center;'>No tips found in database.</p>";
}
$conn->close();
?>


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