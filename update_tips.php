<?php
$conn = new mysqli("localhost", "root", "", "eyeris");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Handle deletion BEFORE anything else
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);

    // Delete image if it exists
    $imageResult = $conn->query("SELECT image_path FROM tips WHERE tip_id = $idToDelete");
    if ($imageRow = $imageResult->fetch_assoc()) {
        if (file_exists($imageRow['tip_image_path'])) {
            unlink($imageRow['tip_image_path']);
        }
    }

    // Delete the exercise
    $deleteStmt = $conn->prepare("DELETE FROM tips WHERE tip_id = ?");
    $deleteStmt->bind_param("i", $idToDelete);

    if ($deleteStmt->execute()) {
        echo "<script>alert('Tip deleted successfully'); window.location.href='update_tips.php';</script>";
        exit();
    } else {
        echo "Delete error: " . $deleteStmt->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['tip_id'] ?? null;
    $title = $_POST['tip_title'];
    $content = $_POST['tip_content'];

    // Image handling
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/";
        $image_path = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    } else {
        $image_path = $_POST['tip_image_path'] ?? '';
    }

    if ($id) {
        // Update
        $stmt = $conn->prepare("UPDATE tips SET tip_title=?, tip_content=?, tip_image_path=? WHERE tip_id=?");
        $stmt->bind_param("sssi", $title, $content, $image_path, $id);
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO tips (tip_title, tip_content, tip_image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image_path);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Tip saved successfully'); window.location.href='update_tips.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$result = $conn->query("SELECT * FROM tips");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Tips</title>
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
            margin-left: 80px;
            margin-right: 80px;
            background-color:rgb(141, 221, 255); 
            padding: 60px 100px; 
            border-radius: 8px; 
            width: 80%;
        }

        label { 
            display: block; 
            margin-top: 10px; 
            font-weight: bold; 
        }

        input[type="text"], textarea { 
            width: 90%; 
            padding: 8px; 
        }

        input[type="file"] { margin-top: 5px; }

        input[type="submit"] { 
            margin-top: 15px; 
            padding: 10px 20px; 
            background: #00274d; 
            color: white; 
            border: none; 
        }

        table { 
            width: 90%; 
            margin-top: 30px; 
            margin-left: 80px; 
            margin-bottom: 80px;
            border-collapse: collapse; 
            background: #ffffff; 
        }

        th, td { 
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: left; 
        }

        img { max-width: 100px; }

        a.edit-btn { 
            background: #28a745; 
            color: white; 
            padding: 5px 10px; 
            text-decoration: none; 
            margin-right: 5px; 
        }

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

<h1 style="color:white; margin-left: 100px; margin-top: 50px; margin-bottom: 50px; text-align: center; font-size: 40px; ">Add / Update Tips</h1>

<form action="update_tips.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="tip_id">
    
    <label>Title:</label>
    <input type="text" name="tip_title" id="tip_title" required>

    <label>Content (Tips):</label>
    <textarea name="tip_content" id="tip_content" required></textarea>

    <label>Image:</label>
    <input type="file" name="image" id="image">
    <input type="hidden" name="tip_image_path" id="tip_image_path">

    <input type="submit" value="Save Tip">
</form>

<h2 style="color:white; margin-left: 100px;">Existing Tips</h2>

<table>
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['tip_title']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['tip_content'])) ?></td>
            <td><img src="<?= htmlspecialchars($row['tip_image_path']) ?>" alt=""></td>
            <td>
                <a href="#" class="edit-btn" onclick='editTip(<?= json_encode($row) ?>)'>Edit</a>
                <a href="update_tips.php?delete=<?= htmlspecialchars($row['tip_id']) ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this tip?')">Delete</a>
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
function editTip(data) {
    document.getElementById('tip_id').value = data.tip_id;
    document.getElementById('tip_title').value = data.tip_title;
    document.getElementById('tip_content').value = data.tip_content;
    document.getElementById('tip_image_path').value = data.tip_image_path;
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
