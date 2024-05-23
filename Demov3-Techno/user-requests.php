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
        <h3>Поиск заявки</h3>
        <!-- Форма для поиска заявки -->
        <form method="POST">
            <label>Введите номер заявки или параметры</label>
            <input type="text" name="search_param">
            <button type="submit">Найти</button>
        </form>

        <?php
        // Проверка, заполнено ли поле поиска
        if (!empty($_POST['search_param'])) {
            $search_param = mysqli_real_escape_string($link, $_POST['search_param']); // Экранирование параметра поиска
            // Запрос для поиска заявки по различным параметрам
            $search_query = "SELECT * FROM request WHERE id_request = '$search_param' OR client_name LIKE '%$search_param%' OR car_type LIKE '%$search_param%' OR model LIKE '%$search_param%' OR phone_number LIKE '%$search_param%'";
            $search_result = mysqli_query($link, $search_query);

            // Проверка, найдены ли результаты
            if ($search_result && mysqli_num_rows($search_result) > 0) {
                echo "<h2>Результаты поиска</h2>";
                echo "<table>
                        <tr>
                            <th>Номер заявки</th>
                            <th>Дата добавления</th>
                            <th>Вид авто</th>
                            <th>Модель авто</th>
                            <th>Описание проблемы</th>
                            <th>ФИО клиента</th>
                            <th>Номер телефона</th>
                            <th>Статус заявки</th>
                            <th>Автомеханик</th>
                            <th>Комментарий автомеханика</th>
                        </tr>";

                // Вывод результатов поиска
                while ($row = mysqli_fetch_assoc($search_result)) {
                    echo "<tr>
                            <td>{$row['id_request']}</td>
                            <td>{$row['date_added']}</td>
                            <td>{$row['car_type']}</td>
                            <td>{$row['model']}</td>
                            <td>{$row['problem_description']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['phone_number']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['mechanic']}</td>
                            <td>{$row['mechanic_comment']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>Заявка не найдена</p>";
            }
        }
        ?>

        <h3>Список всех заявок</h3>
        <!-- Таблица со списком всех заявок -->
        <table>
            <tr>
                <th>Номер заявки</th>
                <th>Дата добавления</th>
                <th>Вид авто</th>
                <th>Модель авто</th>
                <th>Описание проблемы</th>
                <th>ФИО клиента</th>
                <th>Номер телефона</th>
                <th>Статус заявки</th>
                <th>Автомеханик</th>
                <th>Комментарий автомеханика</th>
            </tr>

            <?php
            // Запрос на получение всех заявок
            $result = mysqli_query($link, "SELECT * FROM request");
            // Вывод всех заявок
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_request']}</td>
                        <td>{$row['date_added']}</td>
                        <td>{$row['car_type']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['problem_description']}</td>
                        <td>{$row['client_name']}</td>
                        <td>{$row['phone_number']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['mechanic']}</td>
                        <td>{$row['mechanic_comment']}</td>
                      </tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
