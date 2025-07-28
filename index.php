<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EyeRis Shield - Home</title>
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
            background:rgb(1, 175, 255);
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
            max-width: 80%;
            text-align: center;
        }

        .section {
            padding: 60px 20px;
            text-align: center;
            background-color: #1e3c72;
            color: white;
        }

        .section h2 {
            font-size: 32px;
            margin-bottom: 30px;
        }

        .section p {
            font-size: 20px;
            color: #e6e9f0;
            line-height: 1.8;
            margin: 0 auto 30px auto;
            max-width: 80%;
            text-align: center;
        }

        .section1 {
            padding: 60px 20px;
            text-align: center;
            background:rgb(1, 175, 255);
            color: white;
        }

        .section1 h2 {
            font-size: 32px;
            margin-bottom: 30px;
        }

        .section1 p {
            font-size: 20px;
            color: #e6e9f0;
            line-height: 1.8;
            margin: 0 auto 30px auto;
            max-width: 80%;
            text-align: center;
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

        .map-section {
            padding: 60px 20px;
            text-align: center;
            background-color: #1e3c72;
            color: white;
        }

        .map-section h2 {
            font-size: 32px;
            margin-bottom: 30px;
        }

        .map-section iframe {
            width: 100%;
            max-width: 800px;
            height: 400px;
            border: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        <a href="index.php">Home</a>
        <a href="simulator.php">Vision Simulator</a>
        <a href="testing.php" id="testing-link">Vision Testing</a>
        <a href="advice.php" id="advice-link">Vision Advice and Assistance</a>
        <a href="exercises.php">Exercises and Tips</a>
        <a href="login.php" style="display: inline-block; padding: 10px 25px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;">Log in</a>
    </nav>
</header>

<div class="banner">
    <img src="images/banner2.jpg" alt="Eye Banner">
</div>


<div class="hero">
    <h2 style="text-align: center;">Welcome to EyeRis Shield</h2>
    <p>An all-in-one platform for eye care, offering a range of vision assessment tools, eye health tips, and guidance. The platform aims to encourage proactive eye care through features like a vision simulator, which allows users to compare their current vision toa healthy baseline, helping them identify potential issues early on. It also includes tools for detecting refractive errors, fostering the adoption of healthy habits that can prevent long-term vision issues. Additionally, EyeRis Shield will provide personalized eye care tips and reminders for regular tests and screen breaks. This platform will not only enhance eye health awareness but also create a reliable record-keeping system where users can store and track their eye test history. By encouraging regular self-checks and providing valuable insights, EyeRis Shield will bridge the gap in eye care literacy and empower users to prioritize and manage their eye health effectively in their everyday lives. </p>
</div>

<section class="section">
    <h2 style="text-align: center;">What is Eye Care?</h2>
    <p>Eye care is an essential component of overall health care, as our vision plays a crucial role in our ability to carry out daily activities independently. Impaired vision can affect our quality of life, leading to a dependency on others and impacting both our families and the community around us. It’s vital to understand the importance of routine eye care and adopt proactive measures to maintain healthy eyesight. </p>
</section>

<section class="section1">
    <h2 style="text-align: center;">About Us</h2>
    <p>Pantai Hospital Ayer Keroh is located just 5 km from the Ayer Keroh toll plaza in the historic city of Melaka. This 250-bed hospital houses over 80 medical specialists and offers a comprehensive range of medical services and specialties, including dental services, a cancer centre, a cardiac catheterization lab, heart surgery, hemodialysis, and an emergency department.</p>
    <p>Pantai Hospital Ayer Keroh’s strong commitment to patient safety and holistic healing has made it a preferred choice for patients in the southern region of Malaysia, as well as for medical tourists.</p>
    <p>Pantai Hospital Ayer Keroh is one of 14 hospitals operated by Pantai Holdings Sdn Bhd (Pantai Group), which is part of Parkway Pantai Limited, a subsidiary of IHH Healthcare Berhad (IHH).</p>
</section>

<section class="map-section">
    <h2>Our Location</h2>
   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.7767837054307!2d102.28472287496788!3d2.2373564977429186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1e572c43f3e8b%3A0x81e09df4127e42e6!2sPantai%20Hospital%20Ayer%20Keroh!5e0!3m2!1sen!2smy!4v1747973405292!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <p style="font-size: 18px; color: #e6e9f0; margin-top: 60px; max-width: 80%; margin: 0 auto; text-align: center;">
        Pantai Hospital Ayer Keroh (PHAK) is a branch of Pantai Medical Centre Sdn. Bhd. Reg. No. 198101006941 (73056-D). It is an accredited hospital by the Malaysian Society for Quality in Health (MSQH), located in the historic city of Melaka and a part of IHH Healthcare, one of the largest healthcare groups in the world.
    </p>
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
    });

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