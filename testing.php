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

        .section1 {
            padding: 60px 20px;
            text-align: center;
            background:rgb(180, 233, 255);
            color: white;
        }

        .section1 h2 {
            font-size: 50px;
            margin-bottom: 30px;
        }

        .section1 p {
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

        table {
          font-size: 15px;
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

        canvas {
      background: white;
      border: 2px solid #333;
      margin-top: 20px;
    }

    button {
      padding: 10px 20px;
      margin: 10px;
      font-size: 16px;
      cursor: pointer;
    }

    #status {
      font-size: 18px;
      margin-top: 15px;
    }

    #result {
      font-size: 20px;
      font-weight: bold;
      margin-top: 20px;
      color: green;
    }

    #mobile-controls button {
      padding: 15px 25px;
      font-size: 24px;
      margin: 5px;
      border: none;
      background-color: #00274d;
      color: white;
      border-radius: 8px;
      transition: background 0.3s;
    }

    #mobile-controls button:hover {
      background-color: #f4a261;
    }

    .testbox {
    max-width: 80%;
    background-color: white;
    color: black;
    margin: 40px auto; /* This centers it horizontally */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
    <h2 style="text-align: center;">Vision Testing</h2>
    <p style="text-align: center; margin: 0 auto; max-width: 800px;">This vision testing detects refractive errors such as near-sighted, far-sighted, and astigmatism. It will provide brief recommendations based on the results obtained.</p>
    <div class="controls">
        <button class="active" onclick="window.location.href='testing.php'">Nearsight (Myopia)</button>
        <button onclick="window.location.href='hyperopia_test.php'">Farsight (Hyperopia)</button>
        <button onclick="window.location.href='astigmatism_test.php'">Astigmatism</button>
    </div><br>

    <div class="testbox">
    <h1>Tumbling E Visual Acuity Test</h1>
    <h2>Jaeger-type Near Vision Test (14–16 inches)</h2>
    <p style="text-align: center; color:black;"><strong>Instructions:</strong> Sit at the required distance (less than an arm's length from the screen). </p>
  <p style="text-align: center; color:black;">Select which eye to test. Cover the other eye.</p>
  <button onclick="startTest('Left Eye')">Start Left Eye</button>
  <button onclick="startTest('Right Eye')">Start Right Eye</button><br>

  <canvas id="eCanvas" width="300" height="300"></canvas><br>

  <br><p style="text-align:center; color:black;S">Press ↑ ↓ ← → to guess the direction the E is pointing</p>
  <div id="status"></div>
  <div id="result"></div>

  <div id="mobile-controls" style="margin-top: 20px;">
  <p style="color:black; font-weight: bold; text-align: center; ">Tap the direction of the E:</p>
  <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
    <button onclick="handleDirection('up')">↑</button>
  </div>
  <div style="display: flex; justify-content: center; gap: 10px;">
    <button onclick="handleDirection('left')">←</button>
    <button onclick="handleDirection('down')">↓</button>
    <button onclick="handleDirection('right')">→</button>
  </div>
</div>

  <br><br>

  <section class="section1" id="interpretationTable" style="display: none;">
  <h2 style="text-align:center; color:black;">Jaeger Near Vision Interpretation</h2>
  <table style="margin: 0 auto; border-collapse: collapse; width: 90%; background-color: white; color: black; font-size: 16px;">
  <thead>
    <tr style="background-color: #00274d; color: white;">
      <th style="padding: 12px; border: 1px solid #ddd;">Jaeger Level</th>
      <th style="padding: 12px; border: 1px solid #ddd;">Font Size</th>
      <th style="padding: 12px; border: 1px solid #ddd;">Interpretation</th>
      <th style="padding: 12px; border: 1px solid #ddd;">Recommendation</th>
    </tr>
  </thead>
  <tbody>
  <tr>
    <td>J8</td>
    <td>12 pt</td>
    <td>This is very large print. It should be readable even with limited near vision.</td>
    <td>Very large print is readable. Suitable for low vision. You may not need reading glasses.</td>
  </tr>
  <tr>
    <td>J7</td>
    <td>10 pt</td>
    <td>This is slightly smaller and might be harder to read with mild hyperopia.</td>
    <td>Slightly smaller text. Basic reading glasses may improve comfort.</td>
  </tr>
  <tr>
    <td>J6</td>
    <td>8 pt</td>
    <td>Some people will require glasses to read this text comfortably.</td>
    <td>Mild near vision blur. Consider using reading aids.</td>
  </tr>
  <tr>
    <td>J5</td>
    <td>7 pt</td>
    <td>A slight struggle here may suggest the need for mild reading correction.</td>
    <td>Some strain expected. A mild reading prescription may help.</td>
  </tr>
  <tr>
    <td>J4</td>
    <td>6 pt</td>
    <td>Typical print size found in newspapers or books.</td>
    <td>Normal near vision if you can read this easily.</td>
  </tr>
  <tr>
    <td>J3</td>
    <td>5 pt</td>
    <td>Can you comfortably read this line? If not, near vision may be reduced.</td>
    <td>If blurry, consider an eye exam to check for presbyopia.</td>
  </tr>
  <tr>
    <td>J2</td>
    <td>4 pt</td>
    <td>Fine print begins here. Eyestrain or blur may indicate presbyopia.</td>
    <td>Fine print causing strain may indicate presbyopia.</td>
  </tr>
  <tr>
    <td>J1</td>
    <td>3 pt</td>
    <td>This is extremely small text. If you can read this clearly, your near vision is excellent.</td>
    <td>Excellent near vision. No action needed.</td>
  </tr>
</tbody>
</table><br><br>

  <p style="color:black; font-size: 18px; max-width: 80%; text-align: center; ">📝 Note: Jaeger results help assess near vision sharpness. For an accurate diagnosis, consult an optometrist.</p>

</section>
  <script>
const canvas = document.getElementById('eCanvas');
const ctx = canvas.getContext('2d');
const directions = ['up', 'right', 'down', 'left'];
const keyMap = {
  'ArrowUp': 'up',
  'ArrowRight': 'right',
  'ArrowDown': 'down',
  'ArrowLeft': 'left'
};
const sizeSteps = [22, 18, 16, 14, 12, 10, 8, 6];
const visualAcuityMap = ['J8', 'J7', 'J6', 'J5', 'J4','J3', 'J2', 'J1'];

let currentStep = 0;
let currentDirection = '';
let correctCount = 0;
let incorrectCount = 0;
let selectedEye = '';
let testInProgress = false;

function drawE(size, direction) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.save();
  ctx.translate(canvas.width / 2, canvas.height / 2);

  const angleMap = {
    'right': 0,
    'down': Math.PI / 2,
    'left': Math.PI,
    'up': -Math.PI / 2
  };

  ctx.rotate(angleMap[direction]);
  ctx.fillStyle = 'black';

  const bar = size / 5;
  const offsetX = -size / 2;
  const offsetY = -size / 2;

  ctx.fillRect(offsetX, offsetY, size, bar);                      // Top bar
  ctx.fillRect(offsetX, offsetY + size / 2 - bar / 2, size, bar); // Middle bar
  ctx.fillRect(offsetX, offsetY + size - bar, size, bar);         // Bottom bar
  ctx.fillRect(offsetX, offsetY, bar, size);                      // Vertical bar
  ctx.restore();
}

function showNextE() {
  const table = document.getElementById("interpretationTable");

  if (currentStep >= sizeSteps.length) {
    const estimate = visualAcuityMap[currentStep - 1] || '20/20';
    document.getElementById('result').textContent = `✅ ${selectedEye} Passed! Estimated Vision: ${estimate} or better.`;
    document.getElementById('status').textContent = '';
    table.style.display = "block";
    testInProgress = false;
    saveTestResult(`${selectedEye} - Myopia`, estimate);
    return;
  }

  if (incorrectCount >= 3) {
    const estimate = visualAcuityMap[Math.min(currentStep, visualAcuityMap.length - 1)];
    document.getElementById('result').textContent = `⚠️ ${selectedEye} Test Complete. Estimated Vision: ${estimate}`;
    document.getElementById('status').textContent = '';
    table.style.display = "block";
    testInProgress = false;
    saveTestResult(`${selectedEye} - Myopia`, estimate);
    return;
  }

  currentDirection = directions[Math.floor(Math.random() * 4)];
  drawE(sizeSteps[currentStep], currentDirection);
  document.getElementById('status').textContent = `Step ${currentStep + 1} – Which direction is the E pointing?`;
}

// Keyboard support
document.addEventListener('keydown', (e) => {
  if (!testInProgress || !(e.key in keyMap)) return;
  handleDirection(keyMap[e.key]);
});

// On-screen button tap support
function handleDirection(direction) {
  if (!testInProgress) return;

  if (direction === currentDirection) {
    correctCount++;
    incorrectCount = 0;
    document.getElementById('status').textContent = '✅ Correct!';
    currentStep++;
  } else {
    incorrectCount++;
    document.getElementById('status').textContent = '❌ Incorrect. Try again!';
  }

  setTimeout(showNextE, 1000);
}

function startTest(eye) {
  selectedEye = eye;
  currentStep = 0;
  correctCount = 0;
  incorrectCount = 0;
  testInProgress = true;
  document.getElementById('result').textContent = '';
  document.getElementById('status').textContent = `🧿 Cover your ${eye === 'Left Eye' ? 'Right' : 'Left'} eye. Test starting...`;

  setTimeout(showNextE, 2000);
}

function saveTestResult(testType, result) {
  fetch('save_test_results.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      test_type: testType,
      result: result,
      notes: `Tested on ${selectedEye}`
    })
  })
  .then(response => response.json())
  .then(data => {
    console.log('Save response:', data);
    if (data.status !== 'success') {
      alert('❌ Failed to save result: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Fetch error:', error);
    alert('❌ Network error or invalid API call.');
  });
}
</script>

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

</body>
</html>