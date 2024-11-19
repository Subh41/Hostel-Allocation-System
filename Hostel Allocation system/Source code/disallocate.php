<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "Please log in to access this page.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST["studentId"];
    $roomNumber = $_POST["roomNumber"];

    $allocations = file('allocations.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false;
    $newAllocations = [];

    foreach ($allocations as $allocation) {
        $data = explode('|', $allocation);
        if ($data[1] == $studentId && $data[6] == $roomNumber) {
            $found = true;
        } else {
            $newAllocations[] = $allocation;
        }
    }

    if ($found) {
        file_put_contents('allocations.txt', implode("\n", $newAllocations));
        echo "<h2>Room Disallocation Successful</h2>";
        echo "<p>Student ID: $studentId</p>";
        echo "<p>Room Number: $roomNumber</p>";
        echo "<p>The room has been successfully disallocated.</p>";
    } else {
        echo "<h2>Disallocation Failed</h2>";
        echo "<p>No matching allocation found for the provided Student ID and Room Number.</p>";
    }
} else {
    echo "Invalid request method.";
}
?>