<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Стили остаются без изменений */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column; /* Вертикальное расположение элементов */
        }

        table {
            width: 100%;
            max-width: 600px;
            margin: 20px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* Адаптивность таблицы */
        @media (max-width: 600px) {
            th, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            th {
                text-align: center;
            }
        }

        /* Стили для кнопок */
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        button#addUserButton {
            background-color: blue;
        }

        button#addUserButton:hover {
            background-color: darkblue;
        }

        input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 20px;
        }

        input[type="submit"]:hover {
            background-color: darkred;
        }

        /* Стили для кнопки выйти */
        #logoutButton {
            margin-top: 20px;
            background-color: #f44336;
        }

        #logoutButton:hover {
            background-color: #d32f2f;
        }
    </style>
    <title>Адаптивная таблица с PHP и MySQLi</title>
</head>
<body>

<?php
// Подключение к базе данных (замените параметры на ваши)
$servername = "134.90.167.42:10306";
$username = "Shlyakhin";
$password = "WzIwnY";
$dbname = "project_Shlyakhin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка запроса на удаление пользователя
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $sql_delete = "DELETE FROM `Users` WHERE `id` = $user_id";

    if(mysqli_query($conn, $sql_delete)){
        echo "Пользователь успешно удален.";
    } else{
        echo "Ошибка при удалении пользователя: " . mysqli_error($conn);
    }
}

// SQL-запрос для получения данных
$sql = "SELECT `id`, `Role`, `Name`, `Pass` FROM `Users`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод данных в таблицу
    echo '<table>';
    echo '<thead><tr><th>ID</th><th>Роль</th><th>Логин</th><th>Пароль</th><th></th></tr></thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['Role'] . '</td>';
        echo '<td>' . $row['Name'] . '</td>';
        echo '<td>' . $row['Pass'] . '</td>';
        echo '<td>
                <form method="post" action="">
                    <input type="hidden" name="user_id" value="' . $row['id'] . '">
                    <input type="submit" name="delete_user" value="Удалить">
                </form>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    echo "0 результатов";
}

// Закрытие соединения
$conn->close();
?>

<!-- Форма для добавления нового пользователя -->
<form action="baza_DP.php" method="post"> 
    <button id="addUserButton" type="submit">Добавление пользователей</button>
</form>

<!-- Кнопка выхода -->
<button id="logoutButton" onclick="window.location.href='admin_dashboard.html'">Выйти</button>

</body>
</html>