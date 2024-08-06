<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "root";
$db_name = "data";
$db_port = "8889";

$conn = new mysqli($db_server, $db_user, $db_pass, $db_name, $db_port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete statement
    $sql = "DELETE FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Record deleted successfully
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

// Redirect back to the main page
header("Location: expense.php");
exit();
?>
