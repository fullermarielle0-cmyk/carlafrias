<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($username) || empty($password)) {
        header('Location: index.php?login_error=' . urlencode('Username and password are required.'));
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'exam_db');
    if ($conn->connect_error) {
        header('Location: index.php?login_error=' . urlencode('Database connection failed.'));
        exit;
    }

    // Query user
    $stmt = $conn->prepare('SELECT id, username, password, role FROM users WHERE username = ? AND password = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Create session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        header('Location: index.php');
    } else {
        header('Location: index.php?login_error=' . urlencode('Invalid username or password.'));
    }

    $conn->close();
} else {
    header('Location: index.php');
}
?>
