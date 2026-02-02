<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Planner</title>
    <link rel="stylesheet" href="../assets/style1.css">
</head>
<body>
    <div class="header">
        <h1> Student Task Planner</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <nav>
                <a href="index.php">Dashboard</a>
                <a href="add.php">Add Task</a>
                <a href="logout.php">Logout</a>
            </nav>
        <?php endif; ?>
    </div>