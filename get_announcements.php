<?php
include 'db.php';

$department = $_GET['department'] ?? 'general';

try {
    $stmt = $conn->prepare("SELECT * FROM announcements WHERE display = :department ORDER BY datetime DESC");
    $stmt->bindParam(':department', $department);
    $stmt->execute();

    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="vertical-carousel">';

    foreach ($announcements as $row) {
        echo '<div class="carousel-card">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['content']) . '</p>';
        echo '<small>' . date("F j, Y, g:i a", strtotime($row['datetime'])) . '</small>';
        echo '</div>';
    }

    echo '</div>';
} catch (PDOException $e) {
    echo "Error fetching announcements: " . $e->getMessage();
}
