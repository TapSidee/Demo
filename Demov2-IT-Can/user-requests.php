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
        <h3>Поиск заявки</h3>
        <!-- Форма для поиска заявки -->
        <form method="POST">
            <label>Введите номер заявки или параметры</label>
            <input type="text" name="search_param">
            <button type="submit">Найти</button>
        </form>

        <?php
        // Поиск заявки
        if (!empty($_POST['search_param'])) {
            $search_param = mysqli_real_escape_string($link, $_POST['search_param']);
            $search_query = "SELECT * FROM request WHERE id_request = '$search_param' OR client_name LIKE '%$search_param%' OR equipment_type LIKE '%$search_param%' OR model LIKE '%$search_param%' OR phone_number LIKE '%$search_param%'";
            $search_result = mysqli_query($link, $search_query);

            if ($search_result && mysqli_num_rows($search_result) > 0) {
                echo "<h2>Результаты поиска</h2>";
                echo "<table>
                        <tr>
                            <th>Номер заявки</th>
                            <th>Дата добавления</th>
                            <th>Вид оргтехники</th>
                            <th>Модель</th>
                            <th>Описание проблемы</th>
                            <th>ФИО клиента</th>
                            <th>Номер телефона</th>
                            <th>Статус заявки</th>
                            <th>Мастер</th>
                            <th>Комментарий мастера</th>
                        </tr>";

                // Вывод результатов поиска
                while ($row = mysqli_fetch_assoc($search_result)) {
                    echo "<tr>
                            <td>{$row['id_request']}</td>
                            <td>{$row['date_added']}</td>
                            <td>{$row['equipment_type']}</td>
                            <td>{$row['model']}</td>
                            <td>{$row['problem_description']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['phone_number']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['master']}</td>
                            <td>{$row['master_comment']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>Заявка не найдена</p>";
            }
        }
        ?>
        
        <h3>Список всех заявок</h3>
        <table>
            <tr>
                <th>Номер заявки</th>
                <th>Дата добавления</th>
                <th>Вид оргтехники</th>
                <th>Модель</th>
                <th>Описание проблемы</th>
                <th>ФИО клиента</th>
                <th>Номер телефона</th>
                <th>Статус заявки</th>
                <th>Мастер</th>
                <th>Комментарий мастера</th>
            </tr>

            <?php
            // Вывод всех заявок
            $result = mysqli_query($link, "SELECT * FROM request");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_request']}</td>
                        <td>{$row['date_added']}</td>
                        <td>{$row['equipment_type']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['problem_description']}</td>
                        <td>{$row['client_name']}</td>
                        <td>{$row['phone_number']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['master']}</td>
                        <td>{$row['master_comment']}</td>
                      </tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
