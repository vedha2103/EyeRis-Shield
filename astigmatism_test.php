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
            background:rgb(11, 51, 125);
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

        .box {
            max-width: 80%;
            background-color: white;
            color: black;
            margin: 40px auto; /* This centers it horizontally */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }


        .box h2 {
            font-size: 50px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .box h3 {
            font-size: 22px;
            margin: 10px 0;
        }

        .box p {
            font-size: 16px;
            color: #222;
            text-align: center;
        }

        .instructions {
            max-width: 90%;
            margin: 0 auto 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            color: black;
        }

        ol {
            max-width: 80%;
            margin: 0 auto 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-left: 4px solid #007acc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            color: black;
            text-align: left;
        }

        .question {
            max-width: 60%;
            margin: 0 auto 20px auto;
            padding: 20px;
            background-color:rgb(146, 211, 255);
            border-left: 4px solid #007acc;
            border-right: 4px solid #007acc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            color: black;
            text-align: center;
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

        #result {
            text-align: center;
            font-size: 28px;
            margin-top: 20px;
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
        <a href="homepage.php">Home</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php" id="testing-link">Vision Testing</a>
        <a href="advice.php" id="advice-link">Vision Advice and Assistance</a>
        <a href="exercises.php">Exercises and Tips</a>
        <a href="login.php" style="display: inline-block; padding: 10px 25px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;">Log in</a>
    <?php endif; ?>
</nav>
</header>

<section class="section">
    <h2 style="text-align: center;">Vision Testing</h2>
    <p style="text-align: center; margin: 0 auto; max-width: 800px;">This vision testing detects refractive errors such as near-sighted, far-sighted, and astigmatism. It will provide brief recommendations based on the results obtained.</p>
    <div class="controls">
        <button onclick="window.location.href='testing.php'">Nearsight (Myopia)</button>
        <button onclick="window.location.href='hyperopia_test.php'">Farsight (Hyperopia)</button>
        <button class="active" onclick="setTest('astigmatism')">Astigmatism</button>
    </div><br>

<div class="box">
<h2>Take our 1-minute astigmatism test now!</h2>

<h3>Follow along with this quick vision test to check your eyes for signs of astigmatism.</h3>
<p>Note: This tool does not provide a diagnosis—only your eye doctor can do that.</p><br>

<h3>The below image is called the Astigmatism Dial, an astigmatism chart.</h3><br>
<img id="astigmatismTest" src="images/astigmatism_test.png" alt="Astigmatism Test"><br><br>

<ol>
    <h4>Follow the instructions below to conduct the test:</h4>
    <li>Relax, make sure your screen is an arm's length away.</li><br>
    <li>Cover one side of your eye. Using your left hand, gently cover your left eye so you can only see out of your right eye. Be sure not to apply pressure to your covered eye.</li><br>
    <li>Stare right at the center of the semicircle.</li>
</ol>
<br>
<div class="question">
<h3>Right Eye Test</h3>
<h4>With your left eye covered, do any of the lines appear clearer or bolder than the others?</h4>
<div class="controls">
    <button onclick="setRightEyeResult('yes')" style="background-color:#00ff00;">Yes</button>
    <button onclick="setRightEyeResult('no')" style="background-color:#ff0000;">No</button>
</div>
</div>
<br>
<ol>
    <li>Next, cover the other eye. With your right hand, gently cover your right eye so you can only see out of your left eye. Be sure not to apply pressure to your covered eye.</li>
</ol>

<div class="question"> 
<h3>Left Eye Test</h3>
<h4>With your right eye covered, do any of the lines appear clearer or bolder than the others?</h4>
<div class="controls">
    <button onclick="setLeftEyeResult('yes')" style="background-color:#00ff00;">Yes</button>
    <button onclick="setLeftEyeResult('no')" style="background-color:#ff0000;">No</button>
</div>
</div>

<br>
<button style="display: inline-block; margin-top: 20px; padding: 10px 20px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;" onclick="showResult()">Show Result</button>
<p id="result" style="font-weight: bold; color: blue;"></p>

</div>

<p style="color:black; font-size: 18px;">📝 Note: This is a basic simulation. For medical accuracy, consult a professional eye care provider.</p>

<script>
    let rightEye = null;
    let leftEye = null;

    function setRightEyeResult(answer) {
        rightEye = answer;
        alert("Right eye answer saved: " + answer.toUpperCase());
    }

    function setLeftEyeResult(answer) {
        leftEye = answer;
        alert("Left eye answer saved: " + answer.toUpperCase());
    }

    function showResult() {
        if (rightEye === null || leftEye === null) {
            document.getElementById("result").textContent = "Please complete both tests before viewing the result.";
            return;
        }

        let resultText = "";

        if (rightEye === "yes" && leftEye === "yes") {
            resultText = "Both eyes show signs of astigmatism.";
        } else if (rightEye === "yes" && leftEye === "no") {
            resultText = "Your right eye shows signs of astigmatism.";
        } else if (rightEye === "no" && leftEye === "yes") {
            resultText = "Your left eye shows signs of astigmatism.";
        } else {
            resultText = "No signs of astigmatism detected in either eye.";
        }

        document.getElementById("result").textContent = resultText;

        // Save result to database
        fetch('save_test_results.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                test_type: 'Astigmatism',
                result: resultText,
                notes: `Right Eye: ${rightEye}, Left Eye: ${leftEye}`
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status !== 'success') {
                alert("❌ Failed to save result: " + data.message);
            } else {
                console.log("✅ Result saved");
            }
        })
        .catch(error => {
            alert("❌ Network error: " + error.message);
        });
    }
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