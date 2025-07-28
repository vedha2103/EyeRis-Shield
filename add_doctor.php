<?php
session_start();
require_once 'config/db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$message = "";

// ✅ Handle deletion BEFORE anything else
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);

    // Delete image if it exists
    $imageResult = $conn->query("SELECT profile_image FROM doctors WHERE doctor_id = $idToDelete");
    if ($imageRow = $imageResult->fetch_assoc()) {
        if (file_exists($imageRow['profile_image'])) {
            unlink($imageRow['profile_image']);
        }
    }

    // Delete the exercise
    $deleteStmt = $conn->prepare("DELETE FROM doctors WHERE doctor_id = ?");
    $deleteStmt->bind_param("i", $idToDelete);

    if ($deleteStmt->execute()) {
        echo "<script>alert('Tip deleted successfully'); window.location.href='add_doctor.php';</script>";
        exit();
    } else {
        echo "Delete error: " . $deleteStmt->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = isset($_POST["doctor_id"]) ? intval($_POST["doctor_id"]) : 0;
    $username = $_POST["username"];
    $password = !empty($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;
    $full_name = $_POST["full_name"];
    $qualifications = $_POST["qualifications"];
    $languages = $_POST["languages"];

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

    if (empty($message)) {
        if ($doctor_id > 0) {
            // ✅ UPDATE
            if ($profile_image !== "") {
                if ($password) {
                    $stmt = $conn->prepare("UPDATE doctors SET username=?, password=?, full_name=?, qualifications=?, languages=?, profile_image=? WHERE doctor_id=?");
                    $stmt->bind_param("ssssssi", $username, $password, $full_name, $qualifications, $languages, $profile_image, $doctor_id);
                } else {
                    $stmt = $conn->prepare("UPDATE doctors SET username=?, full_name=?, qualifications=?, languages=?, profile_image=? WHERE doctor_id=?");
                    $stmt->bind_param("sssssi", $username, $full_name, $qualifications, $languages, $profile_image, $doctor_id);
                }
            } else {
                if ($password) {
                    $stmt = $conn->prepare("UPDATE doctors SET username=?, password=?, full_name=?, qualifications=?, languages=? WHERE doctor_id=?");
                    $stmt->bind_param("sssssi", $username, $password, $full_name, $qualifications, $languages, $doctor_id);
                } else {
                    $stmt = $conn->prepare("UPDATE doctors SET username=?, full_name=?, qualifications=?, languages=? WHERE doctor_id=?");
                    $stmt->bind_param("ssssi", $username, $full_name, $qualifications, $languages, $doctor_id);
                }
            }

            if ($stmt->execute()) {
                $message = "Doctor updated successfully!";
            } else {
                $message = "Error updating doctor: " . $stmt->error;
            }

        } else {
            // ✅ INSERT
            $stmt = $conn->prepare("INSERT INTO doctors (username, password, full_name, qualifications, languages, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $full_name, $qualifications, $languages, $profile_image);

            if ($stmt->execute()) {
                $message = "Doctor added successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Doctor</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #000428, #004e92);
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

       form { 
            margin-bottom: 80px;
            margin-left: 100px;
            margin-right: 100px;
            background-color:rgb(141, 221, 255); 
            padding: 20px; 
            border-radius: 8px; 
            width: 80%;
            padding: 60px 100px; /* <-- Adds space on left and right */
        }

        input, textarea { 
            width: 90%; 
            margin-bottom: 10px; 
            padding: 8px; 
        }

        button { 
            padding: 10px 20px; 
            margin-top: 10px; 
            margin-right: 10px; 
            background: #28a745; 
            color: #fff; 
            border: none; 
        }

        .message { 
            color: green; 
        }
        
        table { width: 95%; margin-top: 30px; margin-left: 80px; margin-bottom: 80px; border-collapse: collapse; background: #ffffff; }

        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }

        img { max-width: 100px; }

        a.edit-btn { background: #28a745; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; }

        a.delete-btn { background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; }

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
        <a href="adminhomepage.php">Dashboard</a>
        <a href="add_doctor.php">Add Doctor</a>
        <a href="update_exercises.php">Update Exercises</a>
        <a href="update_tips.php">Update Tips</a>
        <a href="logout.php" style="display: inline-block; padding: 10px 25px; background:red; color: white; text-decoration: none; border: none;">Log Out</a>
    </nav>
</header>

<h1 style="color:white; margin-left: 100px; margin-top: 50px; margin-bottom: 50px; text-align: center; font-size: 40px; ">Add New Doctor</h1>

    <form method="POST" enctype="multipart/form-data">
    <h2>New Doctor Details</h2>
    <?php if ($message): ?><p class="message"><?= $message ?></p><?php endif; ?>

    <input type="hidden" name="doctor_id" id="doctor_id">

    <input type="text" name="full_name" id="full_name" placeholder="Full Name" required>
    <input type="text" name="qualifications" id="qualifications" placeholder="Qualifications" required>
    <input type="text" name="languages" id="languages" placeholder="Languages" required>
    <input type="text" name="username" id="username" placeholder="Doctor Username" required>
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="file" name="profile_image" id="profile_image" accept="images/*"><br>

    <button type="submit">Save Doctor</button>
</form>


    <h2 style="color:white; margin-left: 100px;">Existing Doctors</h2>

<?php
// Fetch all doctors from the database
$result = $conn->query("SELECT * FROM doctors");

if (!$result) {
    echo "<p style='color:red;'>Error retrieving doctors: " . $conn->error . "</p>";
}
?>

<table>
    <tr>
        <th>Full Name</th>
        <th>Qualifications</th>
        <th>Languages</th>
        <th>Username</th>
        <th>Password (Hashed)</th>
        <th>Profile Image</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['qualifications']) ?></td>
            <td><?= htmlspecialchars($row['languages']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['password']) ?></td>
            <td><img src="<?= htmlspecialchars($row['profile_image']) ?>" alt="Profile Image" width="100"></td>
            <td>
                <a href="#" class="edit-btn" onclick='editDoctor(<?= json_encode($row) ?>)'>Edit</a>
                <a href="add_doctor.php?delete=<?= htmlspecialchars($row['doctor_id']) ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<footer>
    &copy; 2025 EyeRis Shield | <a href="#" style="color: #f4a261;">Privacy Policy</a>
    <div class="social-links">
        <a href="https://facebook.com">Facebook</a>
        <a href="https://instagram.com">Instagram</a>
        <a href="https://wa.link/2zestt">Contact Us</a>
    </div>
</footer>

<script>
function editDoctor(data) {
    document.getElementById('doctor_id').value = data.doctor_id;
    document.getElementById('full_name').value = data.full_name;
    document.getElementById('qualifications').value = data.qualifications;
    document.getElementById('languages').value = data.languages;
    document.getElementById('username').value = data.username;
    document.getElementById('password').value = ""; // leave blank for security
}

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
