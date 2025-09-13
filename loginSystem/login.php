<?php
    session_start();
    include ('database.php');

    
    $message = '';


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['Register'])) {
        header("Location: register.php");
        exit;
        }

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);


        if(empty($username) || empty($password)){
            $message = "<p class= 'error'>Username and Password is Required!";
        }
        else {
            $sql = "SELECT password FROM users WHERE user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();

                if(password_verify($password, $hashed_password)){
                    $_SESSION['username'] = $username;
                    header("Location: homepage.php");
                    exit();
                }
                else {
                    $message = "<p class='error'>Incorrect Password</p>";
                }

            }
            else {
                $message ="<p class = 'error'>Username Not Found!</p>";
            }
        }
        $stmt->close();
    }
     $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FakeBook Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post" class="registration-form">
    <h1>Login</h1>
    <?php if (!empty($message)) echo $message; ?>
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" value="Login">

    <a href="register.php" class="registerBtn">Register</a>
</form>
</body>
</html>