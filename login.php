<?php
require_once 'config/db.php';
session_start();

$error = "";
$username = ""; // Prevents undefined variable warning

// Fixed admin credentials
$fixedAdminUsername = "admin";
// Hashed version of "admin123"
$fixedAdminPasswordHash = '$2y$10$jxd/vwpjQXYl8DqVsEnke.h696widiJMFUY.cJq/IABnJALgUcWs.';
;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $error = "Username is required.";
    } elseif (empty($password)) {
        $error = "Password is required.";
    } else {
        // Admin login check
        if (
            $username === $fixedAdminUsername &&
            password_verify($password, $fixedAdminPasswordHash)
        ) {
            $_SESSION['username'] = $fixedAdminUsername;
            $_SESSION['role'] = 'admin';
            header("Location: adminhomepage.php");
            exit();
        }

        // Doctor login check
        $stmt = $conn->prepare("SELECT * FROM doctors WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultDoctor = $stmt->get_result();

        if ($resultDoctor->num_rows > 0) {
            $doctor = $resultDoctor->fetch_assoc();
            if (password_verify($password, $doctor['password'])) {
                $_SESSION['doctor_id'] = $doctor['doctor_id'];
                $_SESSION['username'] = $doctor['username'];
                $_SESSION['role'] = 'doctor';
                $_SESSION['full_name'] = $doctor['full_name'];
                $_SESSION['profile_image'] = $doctor['profile_image'];
                header("Location: doctorhomepage.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            // Patient login check (users table)
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $resultUser = $stmt->get_result();

            if ($resultUser->num_rows > 0) {
                $user = $resultUser->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['user_id']; // Corrected to your column name
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = 'patient';

                    // Redirect to dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Incorrect password.";
                }
            } else {
                $error = "Invalid username or password.";
            }

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <title>EyeRis Shield - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #000428, #004e92);
        }

        .container {
            display: flex;
            width: 1200px;
            height: 650px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }

        .form-section {
            flex: 0.8;
            padding: 30px;
        }

        .image-section {
            flex: 1;
            background: url('images/login.jpg') no-repeat center center;
            background-size: cover;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 100px;
            height: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .error {
            color: red;
            font-size: 12px;
            border: 1px solid red;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 4px;
            background-color: #ffe6e6;
            display: block;
        }

        .error.hidden {
            display: none;
        }

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container input {
            width: 100%;
            padding-right: 30px; 
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            font-size: 13px;
            color: #888;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer a {
            color: #0000EE;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="image-section"></div>

    <div class="form-section">
        <div class="logo">
            <img src="images/logo.jpg" style="margin-top: 50px;" alt="Logo" />
            <img src="images/pantai_hosp.jpeg" alt="PHLogo" style="margin-left: 30px; height: 80px; width: 200px;">
        </div><br>

        <h1>Login Form</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="error <?php echo empty($error) ? 'hidden' : ''; ?>">
                <?php echo htmlspecialchars($error); ?>
            </div>

            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" />
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" required />
                <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="footer">
            <a href="password.php">Forgot Password?</a><br /><br />
            Don't have an account? <a href="signup.php">Register</a><br>
            <a href="index.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;">Back to Home</a>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, iconElement) {
    const passwordField = document.getElementById(inputId);
    const isPassword = passwordField.getAttribute("type") === "password";

    passwordField.setAttribute("type", isPassword ? "text" : "password");

    iconElement.classList.toggle("fa-eye");
    iconElement.classList.toggle("fa-eye-slash");
}
</script>

</body>
</html>
