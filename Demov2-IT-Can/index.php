<?php
session_start(); // Начало сессии
$link = mysqli_connect('localhost', 'root', '', 'IT-Can'); // Соединение с базой данных
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IT-Can</title>
</head>
<body>
    <header></header>
    <main>
        <!-- Форма входа -->
        <form method="POST">
            <label>Введите логин</label><br>
            <input type="text" name="login"><br><br>
            <label>Введите пароль</label><br>
            <input type="password" name="password"><br><br>
            <button type="submit">Войти</button>
        </form>
    </main>

<?php
// Проверка введенных данных
if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']); // Хэширование пароля

    // Запрос к базе данных для проверки логина и пароля
    $rr = mysqli_query($link, "SELECT * FROM user WHERE login = '$login' AND password = '$password'");
    $rrr = mysqli_fetch_assoc($rr);

    if (!empty($rrr)) {
        // Если пользователь найден, устанавливаем сессии
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $rrr['login'];
        $role = $rrr['role'];

        // Перенаправление в зависимости от роли
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
