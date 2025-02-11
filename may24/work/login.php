<?php
include ("db_connect.php");

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

        try {

            $stmt = $conn->prepare("SELECT email, password FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($email == $user['email'] && password_verify($password, $user['password'])) {
                echo "hello";
                echo "Login successful! <a href='home.php'>Go here</a>";
            }
            else{
                echo"smelly";}
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>