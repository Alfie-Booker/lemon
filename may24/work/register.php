<?php
include ("db_connect.php");

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $user_type_id = intval($_POST["user_type_id"]); // Assuming it's a dropdown selection

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($user_type_id)) {
        echo "All fields are required!";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT email FROM user WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                echo "Email already exists. Please use a different email.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user into database
                $stmt = $pdo->prepare("INSERT INTO user (first_name, last_name, email, password, user_type_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $hashed_password, $user_type_id]);

                echo "Registration successful! <a href='login.php'>Login here</a>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        <label>First Name:</label>
        <input type="text" name="first_name" required><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>User Type:</label>
        <select name="user_type_id" required>
            <option value="1">Regular User</option>
            <option value="2">Admin</option>
        </select><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>