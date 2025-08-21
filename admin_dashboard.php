<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
$username = htmlspecialchars($_SESSION['first_name']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - <?= $first_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            display: flex;
            min-height: 100vh;
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
            background-color: #495057;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">Admin Panel</h4>
        <a href="create_announcement.php">Create Announcements</a>
        <a href="manage_projects.php">Manage Final-Year Projects</a>
        <a href="view_wishlist.php">View Student Wish Lists</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, <?= $first_name ?>!</h2>
        <p>Use the sidebar to navigate the admin dashboard.</p>

        <!-- Optional: Dashboard stats or summary here -->
    </div>

</body>

</html>