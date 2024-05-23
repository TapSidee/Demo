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
    <header>
        <!-- Навигация пользователя -->
        <a class="aa" href="user-dashboard.php">Создать заявку</a>
        <a class="aa" href="user-requests.php">Посмотреть заявки</a>
        <a class="aa" href="logout.php">Выйти из системы</a>
    </header>
    <br>
    <main>
        <!-- Форма для создания заявки -->
        <form method="POST">
            <label>Вид оргтехники</label><br>
            <input type="text" name="equipment_type"><br><br>
            <label>Модель</label><br>
            <input type="text" name="model"><br><br>
            <label>Описание проблемы</label><br>
            <input type="text" name="problem_description"><br><br>
            <label>ФИО клиента</label><br>
            <input type="text" name="client_name"><br><br>
            <label>Номер телефона</label><br>
            <input type="text" name="phone_number"><br><br>
            <button type="submit">Подать заявку</button>
        </form>
    </main>

<?php
// Проверка и добавление заявки
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_type = mysqli_real_escape_string($link, $_POST['equipment_type']);
    $model = mysqli_real_escape_string($link, $_POST['model']);
    $problem_description = mysqli_real_escape_string($link, $_POST['problem_description']);
    $client_name = mysqli_real_escape_string($link, $_POST['client_name']);
    $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']);

    // Проверка заполненности полей
    if (!empty($equipment_type) && !empty($model) && !empty($problem_description) && !empty($client_name) && !empty($phone_number)) {
        // Запрос на добавление новой заявки
        $query = "INSERT INTO request (equipment_type, model, problem_description, client_name, phone_number) VALUES ('$equipment_type', '$model', '$problem_description', '$client_name', '$phone_number')";
        $result = mysqli_query($link, $query);

        if ($result) {
            echo '<p class="conf">Заявка успешно зарегистрирована</p>';
        } else {
            echo '<p class="error">Ошибка базы данных: ' . mysqli_error($link) . '</p>';
        }
    } else {
        echo '<p class="error">Поля заполнены неверно или не заполнены</p>';
    }
}
?>
</body>
</html>
