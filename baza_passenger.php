<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column; 
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

        #logoutButton {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #logoutButton:hover {
            background-color: #d32f2f;
        }

        #addUserButton {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #addUserButton:hover {
            background-color: #0b7dda;
        }
    </style>
    <title>Список водителей</title>
</head>
<body>

<?php
    $servername = "134.90.167.42:10306";
    $username = "Shlyakhin";
    $password = "WzIwnY";
    $dbname = "project_Shlyakhin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запрос для получения данных только с ролью Driver
$sql = "SELECT `id`, `Role`, `Name`, `Pass` FROM `Users` WHERE `Role` = 'Passanger'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод данных в таблицу
    echo '<table>';
    echo '<thead><tr><th>ID</th><th>Роль</th><th>Логин</th><th>Пароль</th></tr></thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['Role'] . '</td>';
        echo '<td>' . $row['Name'] . '</td>';
        echo '<td>' . $row['Pass'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    echo "<p>Нет результатов для роли 'Driver'</p>";
}

$conn->close();
?>

<!-- Кнопка добавления пользователей -->
<button id="addUserButton" onclick="window.location.href = 'baza_DP.php';">Добавление пользователей</button>

<!-- Кнопка выхода -->
<button id="logoutButton" onclick="logout()">Выйти</button>

<script>
function logout() {
    window.location.href = 'dispatcher_dashboard.html'; // Укажите ваш путь к странице выхода
}
</script>

</body>
</html>