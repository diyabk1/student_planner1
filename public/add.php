<?php
include '../includes/functions.php';
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    }
}

include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2 class="text-center"> Add New Task</h2>
        
        <form method="POST">
            <label>Task Title:</label>
            <input type="text" name="title" placeholder="Enter task name" required>
            
            <label>Description:</label>
            <textarea name="description" rows="4" placeholder="Enter task details..."></textarea>
            
            <label>Due Date:</label>
            <input type="date" name="due_date" required>
            
            <button type="submit" class="btn-pink mt-10"> Create Task</button>
            <a href="index.php" class="btn-pink mt-10" style="background: linear-gradient(135deg, #9E9E9E, #757575); display: block; text-align: center; text-decoration: none;">❌ Cancel</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>