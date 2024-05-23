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
    <header>
        <!-- Ссылки для навигации -->
        <a class="aa" href="user-dashboard.php">Создать заявку</a>
        <a class="aa" href="user-requests.php">Посмотреть заявки</a>
        <a class="aa" href="logout.php">Выйти из системы</a>
    </header>
    <br>
    <main>
        <!-- Форма для создания заявки -->
        <form method="POST">
            <label>Вид авто</label><br>
            <input type="text" name="car_type"><br><br>
            <label>Модель авто</label><br>
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
// Проверка метода запроса
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_type = mysqli_real_escape_string($link, $_POST['car_type']); // Экранирование типа авто
    $model = mysqli_real_escape_string($link, $_POST['model']); // Экранирование модели авто
    $problem_description = mysqli_real_escape_string($link, $_POST['problem_description']); // Экранирование описания проблемы
    $client_name = mysqli_real_escape_string($link, $_POST['client_name']); // Экранирование имени клиента
    $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']); // Экранирование номера телефона

    // Проверка заполненности всех полей
    if (!empty($car_type) && !empty($model) && !empty($problem_description) && !empty($client_name) && !empty($phone_number)) {
        // Запрос на добавление новой заявки
        $query = "INSERT INTO request (car_type, model, problem_description, client_name, phone_number) VALUES ('$car_type', '$model', '$problem_description', '$client_name', '$phone_number')";
        $result = mysqli_query($link, $query);

        // Проверка успешности запроса
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
