<?php


session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['description'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title !== "" && $description !== "") {
        $insert = $conn->prepare("INSERT INTO projects (title, description) VALUES (?, ?)");
        $insert->execute([$title, $description]);

        $project_id = $conn->lastInsertId();

        $addToWishlist = $conn->prepare("INSERT INTO student_project_wishlist (student_id, project_id) VALUES (?, ?)");
        $addToWishlist->execute([$student_id, $project_id]);

        $success = "✅ Project submitted successfully and added to your wishlist!";
    } else {
        $error = "❌ Both fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($student['first_name']) ?> </h1>


    <h2>Propose Your Final-Year Project</h2>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" style="margin-bottom: 30px;">
        <label for="title">Project Title:</label><br>
        <input type="text" name="title" id="title" required style="width: 100%;"><br><br>

        <label for="description">Project Description:</label><br>
        <textarea name="description" id="description" rows="4" required style="width: 100%;"></textarea><br><br>

        <button type="submit" style="padding: 10px 20px;">Submit Project</button>
    </form>
    <script src="./scripts/dashboard.js"></script>


</body>

</html>