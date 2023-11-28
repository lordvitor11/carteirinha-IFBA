<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="post">
        <h2>Login</h2>
        <input type="text" name="user" placeholder="usuário"> <br>
        <input type="password" name="pass" placeholder="senha"> <br>
        <input type="submit" name="submit" value="Confirmar"> <br>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                require_once "Controller/controller.php";

                $controller = new LoginController();

                $result = $controller->processarLogin($_POST['user'], $_POST['pass']);

                echo $result;
            }
        ?>
    </form>

    
</body>
</html>