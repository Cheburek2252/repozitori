<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление Пользователя</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center; /* Центрируем текст заголовка */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto; /* Центрируем форму */
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        p {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Добавить Пользователя</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="role">Роль:</label>
        <select name="role" id="role" required>
            <option value="Admin">Администратор</option>
            <option value="Dispetcher">Диспетчер</option>
            <option value="Driver">Водитель</option>
        </select>

        <label for="name">Логин:</label>
        <input type="text" name="name" id="name" required>

        <label for="pass">Пароль:</label>
        <input type="password" name="pass" id="pass" required>

        <input type="submit" value="Добавить пользователя">
    </form>

    <?php
    // Проверка, если форма была отправлена
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "134.90.167.42:10306";
        $username = "Shlyakhin";
        $password = "WzIwnY";
        $dbname = "project_Shlyakhin";

        // Создание соединения с базой данных
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка соединения
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Проверка наличия данных из формы
        if (isset($_POST['role']) && isset($_POST['name']) && isset($_POST['pass'])) {
            $role = htmlspecialchars($_POST['role']);
            $name = htmlspecialchars($_POST['name']);
            $pass = $_POST['pass']; // Убираем хеширование

            // Подготовка SQL-запроса
            $stmt = $conn->prepare("INSERT INTO Users (Role, Name, Pass) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $role, $name, $pass);

            if ($stmt->execute()) {
                // Переход на страницу baza.php
                header("Location: baza.php");
                exit(); // Завершение скрипта после редиректа
            } else {
                echo "<p>Ошибка: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Пожалуйста, заполните все поля формы.</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
