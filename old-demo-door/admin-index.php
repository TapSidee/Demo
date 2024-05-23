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
        <a class="aa" href="logout.php">Выйти из системы</a>
    </header>
        <br><br>
    <main>
            <h3>Поиск заявки</h3>
            <form method="POST">
                <label>Введите ФИО клиента</label>
                <input type="text" name="client_name">
                <button>Найти</button>
            </form>
            
            <?php
                if (!empty($_POST['client_name'])) {
                    $client_name = mysqli_real_escape_string($link, $_POST['client_name']);
                    $search = mysqli_query($link, "SELECT * FROM request WHERE client_name = '$client_name'");

                    if (!$search) {
                        echo "<p class='error'>Ошибка базы данных: " . mysqli_error($link) . "</p>";
                    } else {
                        if (mysqli_num_rows($search) > 0) {
                            echo "<h2>Результаты поиска</h2>";
                            echo "<table>
                                        <tr>
                                            <th>Номер заявки</th>
                                            <th>Дата добавления</th>
                                            <th>Дата окончания</th>
                                            <th>Тип двери</th>
                                            <th>Описание проблемы</th>
                                            <th>ФИО клиента</th>
                                            <th>Номер телефона</th>
                                            <th>Адрес</th>
                                            <th>Статус заявки</th>
                                            <th>Исполнитель</th>
                                            <th>Коммент</th>
                                        </tr>";

                            while ($row = mysqli_fetch_assoc($search)) {
                                echo "<tr>
                                        <td>{$row['id_request']}</td>
                                        <td>{$row['date_start']}</td>
                                        <td>{$row['date_finish']}</td>
                                        <td>{$row['type_crash']}</td>
                                        <td>{$row['text_crash']}</td>
                                        <td>{$row['client_name']}</td>
                                        <td>{$row['phone_number']}</td>
                                        <td>{$row['address']}</td>
                                        <td>{$row['status']}</td>
                                        <td>{$row['worker']}</td>
                                        <td>{$row['worker_comment']}</td>
                                    </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p class='error'>Заявка не найдена</p>";
                        }
                    }
                } elseif (isset($_POST['client_name']) && empty($_POST['client_name'])) {
                    echo "<p class='error'>Пожалуйста, введите ФИО клиента для поиска</p>";
                }
            ?>

            <br><br><h3>Список заявок</h3>
            <table>
                <tr>
                    <th>Номер заявки</th>
                    <th>Дата добавления</th>
                    <th>Дата окончания</th>
                    <th>Тип двери</th>
                    <th>Описание проблемы</th>
                    <th>ФИО клиента</th>
                    <th>Номер телефона</th>
                    <th>Адрес</th>
                    <th>Статус заявки</th>
                    <th>Исполнитель</th>
                    <th>Коммент</th>
                </tr>

                <?php
                    $result = mysqli_query($link, "SELECT * FROM request");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id_request']}</td>
                                <td>{$row['date_start']}</td>
                                <td>{$row['date_finish']}</td>
                                <td>{$row['type_crash']}</td>
                                <td>{$row['text_crash']}</td>
                                <td>{$row['client_name']}</td>
                                <td>{$row['phone_number']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['worker']}</td>
                                <td>{$row['worker_comment']}</td>
                            </tr>";
                    }
                ?>
            </table>



            <h3>Изменение заявки</h3>
            <form method="POST">
                <label>Введите номер заявки</label>
                <input type="number" name="id_request">
                <label>Новый исполнитель</label>
                <input type="text" name="worker">
                <button type="submit">Изменить</button>
            </form>

            <?php
                if (!empty($_POST['id_request']) && !empty($_POST['worker'])) {
                    $id_request = mysqli_real_escape_string($link, $_POST['id_request']);
                    $worker = mysqli_real_escape_string($link, $_POST['worker']);

                    $max_id_query = mysqli_query($link, "SELECT MAX(id_request) AS max_id FROM request");
                    $max_id = mysqli_fetch_assoc($max_id_query)['max_id'];

                    if ($id_request > $max_id) {
                        echo "<p class='error'>Ошибка: Введенный ID заказа не существует.</p>";
                    } else {
                        if (mysqli_query($link, "UPDATE request SET worker = '$worker' WHERE id_request = '$id_request'")) {
                            echo "<p class='conf'>Рабочий успешно изменен.</p>";
                        } else {
                            echo "<p class='error'>Ошибка при изменении рабочего: " . mysqli_error($link) . "</p>";
                        }
                    }
                }
            ?>

            <br><form method="POST">
                <label>Введите номер заявки</label>
                <input type="number" name="id_request">
                <label>Новый коментарий</label>
                <input type="text" name="worker_comment">
                <button type="submit">Изменить</button>
            </form>

            <?php
                if (!empty($_POST['id_request']) && !empty($_POST['worker_comment'])) {
                    $id_request = mysqli_real_escape_string($link, $_POST['id_request']);
                    $worker_comment = mysqli_real_escape_string($link, $_POST['worker_comment']);

                    $max_id_query = mysqli_query($link, "SELECT MAX(id_request) AS max_id FROM request");
                    $max_id = mysqli_fetch_assoc($max_id_query)['max_id'];

                    if ($id_request > $max_id) {
                        echo "<p class='error'>Ошибка: Введенный ID заказа не существует.</p>";
                    } else {
                        if (mysqli_query($link, "UPDATE request SET worker_comment = '$worker_comment' WHERE id_request = '$id_request'")) {
                            echo "<p class='conf'>Коментарий успешно изменен.</p>";
                        } else {
                            echo "<p class='error'>Ошибка при изменении коментария: " . mysqli_error($link) . "</p>";
                        }
                    }
                }
            ?>

            <br><form method="POST">
                <label>Введите номер заявки</label>
                <input type="number" name="id_request">
                <label>Новый статус</label>
                <td><select name = "status">
                    <option value = "в ожидании">в ожидании</option>
                    <option value = "в работе">в работе</option>
                    <option value = "выполнено">выполнено</option>
                    </select></td>
                <button type="submit">Изменить</button>
            </form>

            <?php
                if (!empty($_POST['id_request']) && !empty($_POST['status'])) {
                $id_request = mysqli_real_escape_string($link, $_POST['id_request']);
                $status = mysqli_real_escape_string($link, $_POST['status']);
                $max_id_query = mysqli_query($link, "SELECT MAX(id_request) AS max_id FROM request");
                $max_id = mysqli_fetch_assoc($max_id_query)['max_id'];

                if ($id_request > $max_id) {
                    echo "<p class='error'>Ошибка: Введенный ID заказа не существует.</p>";
                    exit();
                } elseif ($status === "выполнено") {
                    $update_query = "UPDATE request SET status = '$status', date_finish = NOW() WHERE id_request = '$id_request'";
                } else {
                    $update_query = "UPDATE request SET Status = '$status', date_finish = NULL WHERE id_request = '$id_request'";
                }

                $yy = mysqli_query($link, $update_query);
                    if ($yy) {
                        echo "<p class='conf'>Статус успешно изменен. </p>";
                    } else {
                        echo "<p class='error'>Ошибка при изменении статуса: </p>" . mysqli_error($link);
                    }}
                // } else {
                //     echo "<p class='error'>Пожалуйста, заполните номер заявки и выберите новый статус.</p>";
                // }
            ?>


<br><br><br>
            <h3>Информация о заявках</h3>
            <?php
                $count_query = "SELECT COUNT(*) AS total_request FROM request";
                $count_result = mysqli_query($link, $count_query);
                $total_request = mysqli_fetch_assoc($count_result)['total_request'];

                echo "<p>Всего заявок: $total_request</p>";
            ?>

            <?php
                $total_time_query = "SELECT SUM(TIMESTAMPDIFF(SECOND, Date_start, Date_finish)) AS total_time FROM request WHERE status = 'выполнено'";
                $total_time_result = mysqli_query($link, $total_time_query);
                $total_time_seconds = (int) mysqli_fetch_assoc($total_time_result)['total_time'];

                $count_query = "SELECT COUNT(*) AS total_request FROM request WHERE status = 'выполнено'";
                $total_request = (int) mysqli_fetch_assoc(mysqli_query($link, $count_query))['total_request'];

                if ($total_request > 0) {
                    $average_time = gmdate("H:i:s", round($total_time_seconds / $total_request));
                    echo "<p>Среднее время выполнения заявки: $average_time</p>";
                } else {
                    echo "<p>Нет выполненных заявок в базе данных.</p>";
                }
            ?>

    </main>
</body>
</html>