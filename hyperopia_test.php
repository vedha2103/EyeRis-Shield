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
        <button class="active" onclick="window.location.href='hyperopia_test.php'">Farsight (Hyperopia)</button>
        <button onclick="window.location.href='astigmatism_test.php'">Astigmatism</button>
    </div><br>

    <div class="testbox">
    <h1>Tumbling E Visual Acuity Test</h1>
    <h2>Snellen-type Distance/Far Vision Test (Simulated for 3 feet)</h2>
    <p style="text-align: center; color:black;"><strong>Instructions:</strong> Sit at an arm's length from the screen.</p>
  <p style="text-align: center; color:black;">Select which eye to test. Cover the other eye.</p>
  <button onclick="startTest('Left Eye')">Start Left Eye</button>
  <button onclick="startTest('Right Eye')">Start Right Eye</button><br>

  <canvas id="eCanvas" width="300" height="300"></canvas><br>

  <br><p style="text-align:center; color:black;S">Press ↑ ↓ ← → to guess the direction the E is pointing</p>
  <div id="status"></div>
  <div id="result"></div>

  <div id="mobile-controls" style="margin-top: 20px;">
  <p style="color:black; font-weight: bold; text-align: center;">Tap the direction of the E:</p>
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
  <h2 style="text-align:center; color:black;">Snellen Distance/Far Vision Interpretation</h2>
  <table style="margin: 0 auto; border-collapse: collapse; width: 90%; background-color: white; color: black; font-size: 16px;">
  <thead>
    <tr style="background-color: #00274d; color: white;">
      <th style="padding: 12px; border: 1px solid #ddd;">Visual Acuity</th>
      <th style="padding: 12px; border: 1px solid #ddd;">Type of Sight</th>
      <th style="padding: 12px; border: 1px solid #ddd;">Interpretation & Recommendation</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>20/100</td>
      <td>Severe Impairment</td>
      <td>Serious difficulty. Professional evaluation is strongly recommended.</td>
    </tr>
    <tr>
      <td>20/80</td>
      <td>Very Low Vision</td>
      <td>Major difficulty in reading and driving. Eye care required.</td>
    </tr>
    <tr>
      <td>20/60</td>
      <td>Moderate Impairment</td>
      <td>Significant visual strain. Glasses or contacts recommended.</td>
    </tr>
    <tr>
      <td>20/50</td>
      <td>Reduced Vision</td>
      <td>May need correction for daily tasks like reading or driving.</td>
    </tr>
    <tr>
      <td>20/40</td>
      <td>Borderline Normal</td>
      <td>Minimum standard for driving in many regions. Correction advised.</td>
    </tr>
    <tr>
      <td>20/30</td>
      <td>Mild Blurring</td>
      <td>Mostly functional. May benefit from mild correction.</td>
    </tr>
    <tr>
      <td>20/25</td>
      <td>Slight Blur</td>
      <td>Very close to normal. Likely not noticeable without testing.</td>
    </tr>
    <tr>
      <td>20/20</td>
      <td>Normal Vision</td>
      <td>Standard visual acuity. No correction needed.</td>
    </tr>
    <tr>
      <td>20/15</td>
      <td>Better than Average</td>
      <td>Exceptional clarity. No visual aids required.</td>
    </tr>
    <tr>
      <td>20/10</td>
      <td>Exceptional Vision</td>
      <td>Outstanding eyesight. Common in athletes and pilots.</td>
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
const sizeSteps = [50, 40, 30, 25, 20, 15, 12.5, 10, 7.5, 5];
const visualAcuityMap = ['20/100', '20/80', '20/60', '20/50', '20/40', '20/30', '20/25', '20/20', '20/15', '20/10'];

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
    saveTestResult(`${selectedEye} - Hyperopia`, estimate);
    return;
  }

  if (incorrectCount >= 3) {
    const estimate = visualAcuityMap[Math.min(currentStep, visualAcuityMap.length - 1)];
    document.getElementById('result').textContent = `⚠️ ${selectedEye} Test Complete. Estimated Vision: ${estimate}`;
    document.getElementById('status').textContent = '';
    table.style.display = "block";
    testInProgress = false;
    saveTestResult(`${selectedEye} - Hyperopia`, estimate);
    return;
  }

  currentDirection = directions[Math.floor(Math.random() * 4)];
  drawE(sizeSteps[currentStep], currentDirection);
  document.getElementById('status').textContent = `Step ${currentStep + 1} – Which direction is the E pointing?`;
}

// Keyboard input support
document.addEventListener('keydown', (e) => {
  if (!testInProgress || !(e.key in keyMap)) return;
  handleDirection(keyMap[e.key]);
});

// Tap/click button support
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

// Block non-logged-in access to specific links
document.addEventListener("DOMContentLoaded", function () {
  const testingLink = document.getElementById("testing-link");
  const adviceLink = document.getElementById("advice-link");

  function showAccountAlert(e) {
    e.preventDefault();
    alert("Please create an account or log in to access this feature.");
  }

  if (testingLink && adviceLink) {
    testingLink.addEventListener("click", showAccountAlert);
    adviceLink.addEventListener("click", showAccountAlert);
  }

  const currentUrl = window.location.href;
  const navLinks = document.querySelectorAll('.nav-links a');

  navLinks.forEach(link => {
    if (currentUrl.includes(link.getAttribute('href'))) {
      link.classList.add('active');
    }
  });
});
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