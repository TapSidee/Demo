<?php
    session_start();
    if (empty($_SESSION['auth'])){
        header("location: index.php");
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ООО Техносервис</title>
</head>
<body>
    <header>
        <h1>ООО Техносервис</h1> 
    </header>
    <nav>
        <a href = "">Главная </a>
        <a href = "">Подать заявку </a>
        <a href = "logout.php">Выход</a>
    </nav>
    <main>
    <h2>Подать заявку</h2>
    <form class="form1" action="" method="POST">
    <table>
    <tr>
        <td>Оборудование</td>
        <td><input type="text" name="equipment"></td>
    </tr>
    <tr>
        <td>Тип неисправности </td>
        <td><input type="text" name="problem"></td>
    </tr>
    <tr>
        <td>Описание проблемы</td>
        <td><textarea name="exscription"></textarea></td>
    </tr>
    <tr>
        <td>ФИО клиента</td>
        <td><input type="text" name="full_name"></td>
    </tr>
    <tr>
        <td></td>
        <td><button>0тправить</button></td>
    </tr>
    </form>
    </table>
    </main>

<?php
    require_once("db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['equipment']) && !empty($_POST['problem']) && !empty($_POST['exscription']) && !empty($_POST['full_name'])) {
            $equipment = $_POST['equipment'];
            $problem = $_POST['problem'];
            $exscription = $_POST['exscription'];
            $full_name = $_POST['full_name'];
            $id_users = $_SESSION['id_users'];
    
            $result = mysqli_query($link, "INSERT INTO problems(equipment, problem, exscription, full_name, id_users) VALUES ('$equipment', '$problem', '$exscription', '$full_name', '$id_users')");
    
            if ($result) {
                header("Location: problems_all.php");
            } else {
                echo "<p style='color: red;'>Ошибка при добавлении информации в базу данных</p>";
            }
        } else {
            echo "<p style='color: red;'>Информация не добавлена. Все поля должны быть заполнены.</p>";
        }
    }
    
    ?>
</body>
</html>