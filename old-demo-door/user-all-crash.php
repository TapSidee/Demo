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
        <a class="aa" href="user-crash.php">Создать заявку</a>
        <a class="aa" href="user-all-crash.php">Посмотреть список заявок</a>
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
    </main>
</body>
</html>