<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'db.php'; // adjust this to your actual DB connection file path

$sql = "SELECT w.id, s.first_name AS student_name, s.last_name AS student_lastname, p.title AS project_title, w.created_at
        FROM student_project_wishlist w
        JOIN students s ON w.student_id = s.id
        JOIN projects p ON w.project_id = p.id
        ORDER BY w.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$wishlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Student Project Wish Lists</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 900px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <h1>Student Project Wish Lists</h1>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Project Title</th>
                <th>Requested On</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($wishlists)): ?>
                <?php foreach ($wishlists as $wish): ?>
                    <tr>
                        <td><?= htmlspecialchars($wish['student_name'] . ' ' . $wish['student_lastname']) ?></td>
                        <td><?= htmlspecialchars($wish['project_title']) ?></td>
                        <td><?= htmlspecialchars($wish['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No wish lists found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>