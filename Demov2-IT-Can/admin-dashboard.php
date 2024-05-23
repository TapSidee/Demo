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
        <!-- Кнопка выхода -->
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

        <h3>Изменение заявки</h3>
        <!-- Форма для изменения мастера -->
        <form method="POST">
            <label>Введите номер заявки</label>
            <input type="number" name="id_request">
            <label>Новый мастер</label>
            <input type="text" name="master">
            <button type="submit">Изменить</button>
        </form>

        <?php
        // Обновление мастера
        if (!empty($_POST['id_request']) && !empty($_POST['master'])) {
            $id_request = mysqli_real_escape_string($link, $_POST['id_request']);
            $master = mysqli_real_escape_string($link, $_POST['master']);

            // Запрос на обновление мастера
            $update_query = "UPDATE request SET master = '$master' WHERE id_request = '$id_request'";
            if (mysqli_query($link, $update_query)) {
                echo "<p class='conf'>Мастер успешно изменен.</p>";
            } else {
                echo "<p class='error'>Ошибка при изменении мастера: " . mysqli_error($link) . '</p>';
            }
        }
        ?>

        <!-- Форма для изменения комментария мастера -->
        <form method="POST">
            <label>Введите номер заявки</label>
            <input type="number" name="id_request">
            <label>Новый комментарий</label>
            <input type="text" name="master_comment">
            <button type="submit">Изменить</button>
        </form>

        <?php
        // Обновление комментария мастера
        if (!empty($_POST['id_request']) && !empty($_POST['master_comment'])) {
            $id_request = mysqli_real_escape_string($link, $_POST['id_request']);
            $master_comment = mysqli_real_escape_string($link, $_POST['master_comment']);

            // Запрос на обновление комментария мастера
            $update_query = "UPDATE request SET master_comment = '$master_comment' WHERE id_request = '$id_request'";
            if (mysqli_query($link, $update_query)) {
                echo "<p class='conf'>Комментарий успешно изменен.</p>";
            } else {
                echo "<p class='error'>Ошибка при изменении комментария: " . mysqli_error($link) . '</p>';
            }
        }
        ?>

        <!-- Форма для изменения статуса заявки -->
        <form method="POST">
            <label>Введите номер заявки</label>
            <input type="number" name="id_request">
            <label>Новый статус</label>
            <select name="status">
                <option value="новая заявка">новая заявка</option>
                <option value="в процессе ремонта">в процессе ремонта</option>
                <option value="готова к выдаче">готова к выдаче</option>
                <option value="ожидание запчастей">ожидание запчастей</option>
                <option value="завершена">завершена</option>
            </select>
            <button type="submit">Изменить</button>
        </form>

        <?php
        // Обновление статуса заявки
        if (!empty($_POST['id_request']) && !empty($_POST['status'])) {
            $id_request = mysqli_real_escape_string($link, $_POST['id_request']);
            $status = mysqli_real_escape_string($link, $_POST['status']);

            // Запрос на обновление статуса
            if ($status == 'завершена') {
                $update_query = "UPDATE request SET status = '$status', date_finish = NOW() WHERE id_request = '$id_request'";
            } else {
                $update_query = "UPDATE request SET status = '$status', date_finish = NULL WHERE id_request = '$id_request'";
            }

            if (mysqli_query($link, $update_query)) {
                echo "<p class='conf'>Статус успешно изменен.</p>";
            } else {
                echo "<p class='error'>Ошибка при изменении статуса: " . mysqli_error($link) . '</p>';
            }
        }
        ?>

        <h3>Статистика</h3>
        <?php
        // Запрос на получение общей статистики
        $total_requests_query = "SELECT COUNT(*) AS total_requests FROM request";
        $total_requests_result = mysqli_query($link, $total_requests_query);
        $total_requests = mysqli_fetch_assoc($total_requests_result)['total_requests'];

        echo "<p>Всего заявок: $total_requests</p>";

        // Запрос на получение статистики завершенных заявок
        $completed_requests_query = "SELECT COUNT(*) AS completed_requests FROM request WHERE status = 'завершена'";
        $completed_requests_result = mysqli_query($link, $completed_requests_query);
        $completed_requests = mysqli_fetch_assoc($completed_requests_result)['completed_requests'];

        if ($completed_requests > 0) {
            // Запрос на получение времени выполнения заявок
            $total_time_query = "SELECT SUM(TIMESTAMPDIFF(SECOND, date_added, date_finish)) AS total_time FROM request WHERE status = 'завершена'";
            $total_time_result = mysqli_query($link, $total_time_query);
            $total_time_seconds = mysqli_fetch_assoc($total_time_result)['total_time'];

            // Расчет среднего времени выполнения заявки
            $average_time = gmdate("H:i:s", $total_time_seconds / $completed_requests);
            echo "<p>Среднее время выполнения заявки: $average_time</p>";
        } else {
            echo "<p>Нет выполненных заявок.</p>";
        }

        // Запрос на получение статистики по типам оргтехники
        $issue_stats_query = "SELECT equipment_type, COUNT(*) AS count FROM request GROUP BY equipment_type";
        $issue_stats_result = mysqli_query($link, $issue_stats_query);

        echo "<h4>Статистика по видам оргтехники</h4>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($issue_stats_result)) {
            echo "<li>{$row['equipment_type']}: {$row['count']} заявок</li>";
        }
        echo "</ul>";
        ?>
    </main>
</body>
</html>
