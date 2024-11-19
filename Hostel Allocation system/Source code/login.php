<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required']);
        exit;
    }

    $users = file_exists('users.txt') ? file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    
    foreach ($users as $user) {
        list($existingUsername, $hashedPassword) = explode('|', $user);
        if ($existingUsername === $username && password_verify($password, $hashedPassword)) {
            $_SESSION['user'] = $username;
            echo json_encode(['success' => true]);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
}
?>