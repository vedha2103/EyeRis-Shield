<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EyeRis Shield - Myopia Simulator</title>
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

        .hero {
            text-align: center;
            padding: 40px 20px;
            color: white;
            background: linear-gradient(to bottom, #0a0f44, #1e3c72);
        }

        .hero h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            color: #dfe9f3;
            line-height: 1.8;
            margin: 0 auto;
            max-width: 800px;
            text-align: justify;
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

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .image-grid img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        canvas {
        display: block;
        margin: 20px auto;
        border: 4px solid #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        background-color: #eee;
        }

        #intensitySlider {
        width: 100%;
        max-width: 1000px;
        margin-top: 20px;
        }

        datalist {
        display: flex;
        justify-content: space-between;
        width: 54%;
        margin: 5px auto 0 auto;
        padding: 0;
        }

        datalist option {
        text-align: center;
        font-size: 18px;
        color: black;
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

<!-- Replace everything inside <section class="section"> with the code below -->
<section class="section">
    <h2 style="text-align: center;">Vision Simulator</h2>
    <p style="text-align: center; margin: 0 auto; max-width: 800px;">
        This vision simulator provides a comparison between normal vision and the effects of declining eye health. Use the slider below to simulate Myopia (nearsightedness) from 0 to +6 diopters.
    </p>

    <!-- Controls -->
    <div class="controls">
        <button onclick="window.location.href='myopia_simulator.php'">Myopia</button>
        <button class="active" onclick="setVision('hyperopia')">Hyperopia</button>
        <button onclick="window.location.href='astigmatism_simulator.php'">Astigmatism</button>
    </div>

    <!-- Canvas image-->
    <div id="hyperopiaContainer" style="margin-top: 30px;">
        <img id="hyperopiaImage" alt="Hyperopia" style="max-width: 100%; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: filter 0.3s;">
    </div>

    <!-- Intensity Slider -->
    <div id="sliderContainer" style="margin-top: 40px;">
        <label style="color: black; font-size: 20px;">Hyperopia Intensity: <span id="intensityLabel">0</span> D</label><br>
        <input type="range" id="intensitySlider" min="0" max="6" step="1" value="0" list="hyperopiaTicks" />
            <datalist id="hyperopiaTicks">
                <option value="0" label="0"></option>
                <option value="1" label="+ 1"></option>
                <option value="2" label="+ 2"></option>
                <option value="3" label="+ 3"></option>
                <option value="4" label="+ 4"></option>
                <option value="5" label="+ 5"></option>
                <option value="6" label="+ 6"></option>
            </datalist>
    </div>

    <script>
    const hyperopiaImage = document.getElementById('hyperopiaImage');
    const intensitySlider = document.getElementById('intensitySlider');
    const intensityLabel = document.getElementById('intensityLabel');

    const labels = [
        "0",
        "+1",
        "+2",
        "+3",
        "+4",
        "+5",
        "+6"
    ];

    // Update image and label when slider is moved
    intensitySlider.addEventListener('input', function () {
        const level = parseInt(intensitySlider.value);
        intensityLabel.textContent = labels[level];
        hyperopiaImage.src = `images/hyperopia_${level}.png`;
    });

    function setVision(type) {
        if (type === 'hyperopia') {
            document.getElementById('sliderContainer').style.display = 'block';
            intensitySlider.dispatchEvent(new Event('input')); // trigger initial image and label
        } else {
            document.getElementById('sliderContainer').style.display = 'none';
        }
    }

    // Set default view to astigmatism on load
    setVision('hyperopia');

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
</section>

<footer>
    &copy; 2025 EyeRis Shield | <a href="#" style="color: #f4a261;">Privacy Policy</a>
    <div class="social-links">
        <a href="https://facebook.com">Facebook</a>
        <a href="https://instagram.com">Instagram</a>
        <a href="https://wa.link/2zestt">Contact Us</a>
    </div>
</footer>

</body>
</html>