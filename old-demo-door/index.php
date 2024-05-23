<?php
    session_start();
    $link = mysqli_connect('localhost', 'root', '', 'demo-door');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Demo_door</title>
</head>
<body>
    <header>

    </header>

    <main>
        <form method="POST">
            <label>Введите логин</label><br>
            <input type="text" name="login"><br><br>
            <label>Введите пароль</label><br>
            <input type="password" name="password"><br><br>
            <button>Войти</button>
    </main>

<?php
    if(!empty($_POST['login']) && !empty($_POST['password'])) {
        $login = $_POST['login'];
        $password = md5($_POST['password']);

        $rr = mysqli_query($link, "SELECT * FROM user where login = '$login' and password = '$password'");
        $rrr = mysqli_fetch_assoc($rr);

        if(!empty($rrr)) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $rrr['login'];
            $role = $rrr['role'];

            if($role == 0) {
                $_SESSION['role'] = 0;
                header("Location: user-crash.php");
                exit();
            } elseif ($role == 1) {
                $_SESSION['role'] = 1;
                header("Location: admin-index.php");
                exit();
            }
        } else {
            echo '<p class="error">Неверный логин и/или пароль</p>';
        }
    }
?>


</body>
</html>