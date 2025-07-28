<?php
session_start();
$_SESSION['login_time'] = time(); // Unix timestamp
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EyeRis Shield - Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #0a0f44, #5a9bd6);
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

        .section1 {
            padding: 50px 20px;
            text-align: center;
            background-color: #1cbbff;
            color: white;
        }

        .section1 h2 {
            font-size: 32px;
        }

        .section1 p {
            font-size: 20px;
            color: #e6e9f0;
            line-height: 1.8;
            margin: 0 auto 30px auto;
            max-width: 80%;
            text-align: center;
        }

        #timer-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            position: relative;
            width: 220px;
            height: 220px;
            margin: 0 auto;
        }

        #timer {
            font-size: 48px;
            font-weight: bold;
            color: #ffffff;
            background-color: #004e89;
            border-radius: 50%;
            width: 200px;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            transition: all 0.3s ease-in-out;
        }

        #progress-ring {
            transform: rotate(+90deg) scale(-1, 1); /* Rotate and flip for counterclockwise */
            transition: stroke-dashoffset 1s linear;
        }

        #timer-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 28px;
            font-weight: bold;
            color: white;
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

<script>
    const LOGIN_TIME = <?php echo isset($_SESSION['login_time']) ? $_SESSION['login_time'] * 1000 : 'Date.now()'; ?>;
</script>

</head>
<body>

<header>
    <div class="header-title">
        <img src="images/logo.jpg" alt="Logo">
        <h1>EyeRis Shield</h1>
        <img src="images/pantai_hosp.jpeg" alt="PHLogo" style="margin-left: 30px; height: 70px; width: 190px;">
    </div>
    <nav class="nav-links">
        <a href="adminhomepage.php">Dashboard</a>
        <a href="add_doctor.php">Add Doctor</a>
        <a href="update_exercises.php">Update Exercises</a>
        <a href="update_tips.php">Update Tips</a>
        <a href="logout.php" style="display: inline-block; padding: 10px 25px; background:red; color: white; text-decoration: none; border: none;">Log Out</a>
    </nav>
</header>

<div class="hero">
    <h2 style="text-align: center;">EyeRis Shield Admin Dashboard</h2>
    <p style="text-align: center; margin: 0 auto; max-width: 800px;">Your go-to resource for staying informed, connected, and productive. Here, you’ll find everything you need to make your workday smoother and more efficient.</p>
</div>

<section class="section1">
    <h1 style='color: #fff; font-size: 55px;'>Welcome, Admin!</h1>
    <h2>20-20-20 Eye Strain Reminder</h2>
    <p>This timer will remind you to take a 20-second eye break by looking at something 20 feet away every 20 minutes.</p>
    <div id="timer-container">
    <svg id="progress-ring" width="220" height="220">
        <circle r="100" cx="110" cy="110" fill="none" stroke="#ffffff33" stroke-width="12" />
        <circle id="progress-ring-circle" r="100" cx="110" cy="110" fill="none" stroke="#ffffff" stroke-width="12" stroke-linecap="round" />
    </svg>
    <div id="timer-label">20:00</div>
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

  const ring = document.getElementById('progress-ring-circle');
  const label = document.getElementById('timer-label');
  const RADIUS = ring.r.baseVal.value;
  const CIRCUMFERENCE = 2 * Math.PI * RADIUS;

  const TIMER_DURATION = 20 * 60 * 1000; // 20 minutes in ms
  const STORAGE_KEY = 'eyeris_timer_start';

  ring.style.strokeDasharray = `${CIRCUMFERENCE} ${CIRCUMFERENCE}`;
  ring.style.strokeDashoffset = `${CIRCUMFERENCE}`;

  function setProgress(percent) {
    const offset = CIRCUMFERENCE - percent * CIRCUMFERENCE;
    ring.style.strokeDashoffset = offset;
  }

  function formatTime(ms) {
    const totalSeconds = Math.max(0, Math.floor(ms / 1000));
    const minutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
    const seconds = (totalSeconds % 60).toString().padStart(2, '0');
    return `${minutes}:${seconds}`;
  }

  function startTimer() {
    const now = Date.now();
    localStorage.setItem(STORAGE_KEY, now.toString());
    updateTimer();
  }

  function updateTimer() {
  const now = Date.now();
 const elapsed = now - LOGIN_TIME;
  const currentCycle = Math.floor(elapsed / TIMER_DURATION);
  const timerStart = LOGIN_TIME + currentCycle * TIMER_DURATION;
  const timeLeft = TIMER_DURATION - elapsed;

  if (timeLeft <= 0) {
    // Play alarm and show alert only once per cycle
    const alarm = document.getElementById('alarm-sound');
    
    // Try to play alarm
    alarm.play().then(() => {
      // Show alert after alarm starts
      alert("💡 20-20-20 Rule Reminder:\n\nPlease take a 20-second break and look at something 20 feet away.");
    }).catch(error => {
      // Fallback if autoplay is blocked
      alert("💡 20-20-20 Rule Reminder:\n\nPlease take a 20-second break and look at something 20 feet away.");
      console.warn("Alarm audio playback failed:", error);
    });

    startTimer(); // Reset timer
  } else {
    label.textContent = formatTime(timeLeft);
    setProgress(1 - (timeLeft / TIMER_DURATION));
  }
}


  // Start if not started before
  if (!localStorage.getItem(STORAGE_KEY)) {
    startTimer();
  }

  setInterval(updateTimer, 1000);

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


<audio id="alarm-sound" src="sounds/alarm.mp3" preload="auto"></audio>

</body>
</html>