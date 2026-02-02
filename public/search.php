<?php
include '../includes/functions.php';
include '../config/db.php';

$q = isset($_GET['q']) ? $_GET['q'] : '';
$u_id = $_SESSION['user_id'];
$search = "%$q%";


$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND title LIKE ?");
$stmt->bind_param("is", $u_id, $search);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='task-card'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['status']) . "</p>";
        echo "</div>";
    }
} else {
    echo "No results.";
}
?>