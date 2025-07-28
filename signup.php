<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "eyeris");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$username = $email = '';
$error = '';
$success = '';

// Generate CSRF token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!hash_equals($_SESSION['token'], $_POST['token'] ?? '')) {
        $error = "Invalid CSRF token!";
    } else {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate input
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $error = "All fields are required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format!";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $error = "Password must be at least 8 characters and include an uppercase letter and a number!";
        } else {
            // Check for existing user using prepared statement
            $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=? OR email=?");
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $error = "Username or email already taken!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $hashed_password);
                if (mysqli_stmt_execute($insert_stmt)) {
                    $success = "Signup successful! You can now log in.";
                    // Clear form fields
                    $username = $email = '';
                } else {
                    $error = "Signup failed. Try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EyeRis Shield - Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body {
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #000428, #004e92);
        }
        .container {
            display: flex; width: 1200px; height: 670px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px; overflow: hidden; background-color: #fff;
        }

        .form-section { flex: 0.8; padding: 30px; }

        .image-section {
            flex: 1;
            background: url('images/sign_up.jpg');
            background-size: cover;
            background-position: center;
        }
        .logo { text-align: center; margin-bottom: 5px; }
        .logo img { width: 100px; height: auto; }
        h1 { text-align: center; margin-bottom: 20px; font-size: 24px; }
        .error, .success {
            font-size: 12px; padding: 8px; margin-bottom: 10px;
            border-radius: 4px; display: block;
        }
        .error {
            color: red; border: 1px solid red; background-color: #ffe6e6;
        }
        .success {
            color: green; border: 1px solid green; background-color: #e6ffe6;
        }
        form { display: flex; flex-direction: column; gap: 25px; }
        input, select {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;
        }
        .password-container {
            position: relative; display: flex; align-items: center;
        }
        .password-container input { width: 100%; padding-right: 30px; }
        .password-container .toggle-password {
            position: absolute; right: 10px; cursor: pointer;
            font-size: 13px; color: #888;
        }
        .btn {
            width: 100%; padding: 10px; margin-top: 10px;
            background-color: #007bff; color: white; border: none;
            border-radius: 4px; cursor: pointer;
        }
        .btn:hover { background-color: #0056b3; }
        .footer {
            text-align: center; margin-top: 20px; font-size: 14px;
        }
        .footer a {
            color: #0000EE; text-decoration: none;
        }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-section">
        <div class="logo">
            <img src="images/logo.jpg" alt="Logo">
            <img src="images/pantai_hosp.jpeg" alt="PHLogo" style="margin-left: 30px; height: 80px; width: 200px;">
        </div><br>
        
        <h1>Register Form</h1>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>

            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
                <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="Toggle password visibility" tabindex="0"></i>
            </div>

            <div class="password-container">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('confirm_password', this)" aria-label="Toggle confirm password visibility" tabindex="0"></i>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <div class="footer">
            Already have an account? <a href="login.php">Login</a><br>
            <a href="index.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background:rgb(4, 125, 255); color: white; text-decoration: none; border: none;">Back to Home</a>
        </div>
    </div>

    <div class="image-section"></div>
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
