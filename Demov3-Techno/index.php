<?php
session_start(); // Начало сессии
$link = mysqli_connect('localhost', 'root', '', 'techno'); // Подключение к базе данных
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>techno</title>
</head>

<body>
    <header></header>
    <main>
        <!-- Форма для входа -->
        <form method="POST">
            <label>Введите логин</label><br>
            <input type="text" name="login"><br><br>
            <label>Введите пароль</label><br>
            <input type="password" name="password"><br><br>
            <button type="submit">Войти</button>
        </form>
    </main>

<?php
// Проверка заполненности полей формы
if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']); // Хэширование пароля

    // Запрос для проверки логина и пароля в базе данных
    $rr = mysqli_query($link, "SELECT * FROM user WHERE login = '$login' AND password = '$password'");
    $rrr = mysqli_fetch_assoc($rr);

    // Проверка, найден ли пользователь
    if (!empty($rrr)) {
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $rrr['login'];
        $role = $rrr['role'];

        // Перенаправление в зависимости от роли пользователя
        if ($role == 'user') {
            $_SESSION['role'] = 'user';
            header("Location: user-dashboard.php");
            exit();
        } elseif ($role == 'admin') {
            $_SESSION['role'] = 'admin';
            header("Location: admin-dashboard.php");
            exit();
        }
    } else {
        echo '<p class="error">Неверный логин и/или пароль</p>';
    }
}
?>
</body>
</html>
