<?php
include '../includes/functions.php';
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header("Location: index.php");
    exit();
}


$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$task = $stmt->get_result()->fetch_assoc();

if (!$task) {
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $updateStmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=?, status=? WHERE id=? AND user_id=?");
    $updateStmt->bind_param("ssssii", $title, $description, $due_date, $status, $task_id, $user_id);
    
    if ($updateStmt->execute()) {
        header("Location: index.php");
        exit();
    }
}

include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2 class="text-center"> Edit Task</h2>
        
        <form method="POST">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            
            <label>Description:</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
            
            <label>Due Date:</label>
            <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            
            <label>Status:</label>
            <select name="status">
                <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
            </select>
            
            <button type="submit" class="btn-pink mt-10"> Update Task</button>
            <a href="index.php" class="btn-pink mt-10" style="background: linear-gradient(135deg, #9E9E9E, #757575); display: block; text-align: center; text-decoration: none;">Cancel</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>