<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "Please log in to access this page.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $studentId = $_POST["studentId"];
    $gender = $_POST["gender"];
    $year = $_POST["year"];
    $course = $_POST["course"];

    // Simple hostel allocation logic
    $hostel = "";
    if ($gender == "male") {
        $hostel = "XYZ Male Hostel " . ($year % 2 + 1);
    } elseif ($gender == "female") {
        $hostel = "XYZ Female Hostel " . ($year % 2 + 1);
    } else {
        $hostel = "XYZ Mixed Hostel";
    }

    $roomNumber = rand(100, 500);

    // Store allocation data
    $allocation = "$name|$studentId|$gender|$year|$course|$hostel|$roomNumber\n";
    file_put_contents('allocations.txt', $allocation, FILE_APPEND);

    echo "<h2>Hostel Allocation Result</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Student ID:</strong> $studentId</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";
    echo "<p><strong>Year of Study:</strong> $year</p>";
    echo "<p><strong>Course:</strong> $course</p>";
    echo "<p><strong>Allocated Hostel:</strong> $hostel</p>";
    echo "<p><strong>Room Number:</strong> $roomNumber</p>";
} else {
    echo "Invalid request method.";
}
?>