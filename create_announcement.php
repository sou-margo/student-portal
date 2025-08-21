<?php
session_start();


if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'db.php';


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $display = $_POST['display'] ?? 'general';
    $datetime = date('Y-m-d H:i:s');

    if ($title === '' || $content === '') {
        $message = '❌ Title and content cannot be empty.';
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO announcements (title, content, display, datetime) VALUES (:title, :content, :display, :datetime)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':display', $display);
            $stmt->bindParam(':datetime', $datetime);
            $stmt->execute();

            $message = '✅ Announcement added successfully.';
        } catch (PDOException $e) {
            $message = '❌ Error inserting announcement: ' . $e->getMessage();
        }
    }
}

$username = htmlspecialchars($_SESSION['first_name'] ?? 'Admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Announcement - <?= $username ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
        }

        .sidebar a {
            color: white;
            padding: 15px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: rgb(3, 3, 3);
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        form input[type="text"],
        form textarea,
        form select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        form button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: rgb(0, 0, 0);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 4px;
        }

        form button:hover {
            background-color: rgb(34, 35, 37);
        }

        .message {
            margin-top: 15px;
            font-weight: bold;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center py-3">Admin Panel</h4>
        <a href="create_announcement.php">Create Announcements</a>
        <a href="manage_projects.php">Manage Final-Year Projects</a>
        <a href="view_wishlist.php">View Student Wish Lists</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Create New Announcement</h2>

        <?php if ($message): ?>
            <p class="message <?= strpos($message, '') === 0 ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="5" required></textarea>

            <label for="display">Department:</label>
            <select id="display" name="display" required>
                <option value="general">General</option>
                <option value="computer_science">Computer Science</option>
                <option value="physics">Physics</option>
                <option value="chemistry">Chemistry</option>
                <option value="math">Math</option>
            </select>

            <button type="submit">Add Announcement</button>
        </form>
    </div>

</body>

</html>
