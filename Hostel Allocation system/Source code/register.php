<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required']);
        exit;
    }

    $users = file_exists('users.txt') ? file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    
    foreach ($users as $user) {
        list($existingUsername, $existingPassword) = explode('|', $user);
        if ($existingUsername === $username) {
            echo json_encode(['success' => false, 'message' => 'Username already exists']);
            exit;
        }
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $newUser = "$username|$hashedPassword\n";
    file_put_contents('users.txt', $newUser, FILE_APPEND);

    echo json_encode(['success' => true, 'message' => 'Registration successful']);
}
?>