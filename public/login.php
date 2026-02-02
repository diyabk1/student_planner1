<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Planner</title>
    <link rel="stylesheet" href="../assets/style1.css">
</head>
<body>
    <?php
    include '../config/db.php';

    $error = '';
    $success = '';

    
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    
    if (isset($_GET['success'])) {
        $success = 'Account created successfully! Please login.';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $error = 'Invalid security token. Please try again.';
        } else {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            
            if (empty($username) || empty($password)) {
                $error = 'Please fill in all fields.';
            } else {
                $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    if (password_verify($password, $row['password'])) {
                        
                        session_regenerate_id(true);
                        
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $username;
                        
                        // Generate new CSRF token for next request
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        
                        header("Location: index.php");
                        exit();
                    } else {
                        $error = 'Invalid password. Please try again.';
                    }
                } else {
                    $error = 'Username not found. Please check your username.';
                }
            }
        }
    }
    ?>

    <div class="auth-container">
        <div class="auth-card">
            <h2> Student Login</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                
                <input type="text" name="username" placeholder="Username" required autofocus>
                <input type="password" name="password" placeholder="Password" required minlength="6">
                <button type="submit" class="btn-pink">Login</button>
            </form>
            
            <p>
                Don't have an account? 
                <a href="register.php">Create one here</a>
            </p>
        </div>
    </div>
</body>
</html>