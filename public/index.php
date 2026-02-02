<?php
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
$user_id = $_SESSION['user_id'];
?>

<div class="container">
    <h2>My Student Tasks</h2>
    <div class="text-center mb-20">
        <a href="add.php" class="btn-pink" style="max-width: 300px; display: inline-block;">+ New Task</a>
    </div>
    
    
    <div class="filter-container">
        <button class="filter-btn active" data-filter="all" onclick="filterTasks('all')"> All Tasks</button>
        <button class="filter-btn" data-filter="pending" onclick="filterTasks('pending')"> Pending</button>
        <button class="filter-btn" data-filter="completed" onclick="filterTasks('completed')"> Completed</button>
    </div>
    
    <div id="taskList">
        <?php
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = (strtolower($row['status']) == 'completed') ? 'task-card completed' : 'task-card';
                echo "<div class='{$statusClass}'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<small> " . htmlspecialchars($row['due_date']) . " | <strong>" . strtoupper(htmlspecialchars($row['status'])) . "</strong></small>";
                echo "<div class='mt-10'>";
                echo "<a href='edit.php?id={$row['id']}'> Edit</a>";
                echo "<a href='delete.php?id={$row['id']}'> Delete</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='card text-center'>";
            echo "<p>No tasks yet. Create your first task!</p>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<script src="../assets/ajax.js"></script>
<?php include '../includes/footer.php'; ?>