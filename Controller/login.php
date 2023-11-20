<?php session_start(); include_once 'connect.php' 
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, hashed_password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $stmt->bind_result($user_id, $db_username, $db_hashed_password);

    if ($stmt->fetch() && password_verify(MD5($password), $db_hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        header("location: dashboard.php");
    } else {
        echo "Usuário ou senha inválidos";
    }

    $stmt->close();
    $conn->close();
?>