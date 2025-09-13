<?php
include('database.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $message = "<p class='error'>Username and Password are required!</p>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user, password) VALUES ('$username', '$hashed_password')";

        try {
            mysqli_query($conn, $sql);
            $message = "<p class='success'>You are now registered!</p>";
        } catch (mysqli_sql_exception $e) {
            $message = "<p class='error'>Username is already taken!</p>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FakeBook!</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="registration-form">
        <h1>FakeBook!</h1>

        <?php if (!empty($message)) echo $message; ?>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required /> <br>

        <input type="submit" name="submit" value="Register" />
    </form>

</body>
</html>




