<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Planner</title>
    <link rel="stylesheet" href="../assets/style1.css">
</head>
<body>
    <?php
    include '../config/db.php';

    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        
        if (strlen($username) < 3) {
            $error = 'Username must be at least 3 characters long.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters long.';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $error = 'Password must contain at least one uppercase letter.';
        } elseif (!preg_match('/[a-z]/', $password)) {
            $error = 'Password must contain at least one lowercase letter.';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $error = 'Password must contain at least one number.';
        } else {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = 'Username already taken. Please choose another.';
            }
        }
    }
    ?>

    <div class="auth-container">
        <div class="auth-card">
            <h2>Join the Planner</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="text" name="username" placeholder="Choose Username (min 3 chars)" required autofocus>
                <input type="password" name="password" placeholder="Password (6+ chars, 1 uppercase, 1 number)" required minlength="6" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}">
                <small style="display: block; color: #666; margin-top: -5px; margin-bottom: 10px; font-size: 12px;">
                    Password must contain: uppercase, lowercase, and number
                </small>
                <button type="submit" class="btn-pink">Create Account</button>
            </form>
            
            <p>
                Already have an account? 
                <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>