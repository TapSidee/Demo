<?php
// Настройки базы данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка формы регистрации
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $full_name = $_POST['full_name'];

    // Проверка на уникальность email
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email уже зарегистрирован.";
    } else {
        // Вставка данных в базу
        $sql = "INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $user_name, $email, $password, $full_name);

        if ($stmt->execute()) {
            echo "Регистрация прошла успешно!";
        } else {
            echo "Ошибка: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация пользователей</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form method="POST" action="">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="full_name">Полное имя:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <input type="submit" value="Регистрация">
    </form>
</body>
</html>
