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
        <form method="POST">
            <label>Тип двери</label><br>
            <td><select name = "type_crash">
                <option value = "межкомнатная">межкомнатная</option>
                <option value = "входная">входная</option>
                </select>
            </td><br><br>
            <label>Описание проблемы</label><br>
            <input type="text" name="text_crash"><br><br>
            <label>ФИО клиента</label><br>
            <input type="text" name="client_name"><br><br>
            <label>Номер телефона</label><br>
            <input type="number" name="phone_number"><br><br>
            <label>Адрес</label><br>
            <input type="text" name="address"><br><br>
            <button>Подать заявку</button>
    </main>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $type_crash = mysqli_real_escape_string($link, $_POST['type_crash']);
        $text_crash = mysqli_real_escape_string($link, $_POST['text_crash']);
        $client_name = mysqli_real_escape_string($link, $_POST['client_name']);
        $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']);
        $address = mysqli_real_escape_string($link, $_POST['address']);

        if (!empty($type_crash) && !empty($text_crash) && !empty($client_name) && !empty($phone_number) && !empty($address)) {
            $tt = "INSERT INTO request (type_crash, text_crash, client_name, phone_number, address) VALUES ('$type_crash', '$text_crash', '$client_name', '$phone_number', '$address')";
            $ttt = mysqli_query($link, $tt);

            if ($ttt) {
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