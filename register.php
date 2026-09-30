<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    // Validation
    if (empty($username)) {
        header('Location: index.php?register_error=' . urlencode('Username is required.'));
        exit;
    }

    if (empty($password)) {
        header('Location: index.php?register_error=' . urlencode('Password is required.'));
        exit;
    }

    if (strlen($username) < 3) {
        header('Location: index.php?register_error=' . urlencode('Username must be at least 3 characters.'));
        exit;
    }

    if (strlen($password) < 3) {
        header('Location: index.php?register_error=' . urlencode('Password must be at least 3 characters.'));
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'exam_db');
    if ($conn->connect_error) {
        header('Location: index.php?register_error=' . urlencode('Database connection failed.'));
        exit;
    }

    // Check if username already exists
    $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header('Location: index.php?register_error=' . urlencode('Username already exists.'));
        $conn->close();
        exit;
    }

    // Validate role
    $userRole = ($role === 'admin') ? 'admin' : 'user';

    // Insert new user
    $insertStmt = $conn->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $insertStmt->bind_param('sss', $username, $password, $userRole);

    if ($insertStmt->execute()) {
        header('Location: index.php?register_success=' . urlencode('Registration successful! You can now login.'));
    } else {
        header('Location: index.php?register_error=' . urlencode('Registration failed. Please try again.'));
    }

    $conn->close();
} else {
    header('Location: index.php');
}
?>
