<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация и Вход</title>
    <link rel="stylesheet" href="styles.css"> <!-- Подключение внешнего CSS -->
</head>

<body>
<div class="login-container">
    <button class="close-btn" onclick="closeForm()">×</button>
    <a href="https://belovokyzgty.ru/" class="logo">
        <img src="img/S600xU_2x.webp" alt="Логотип" width="290">
    </a>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "134.90.167.42:10306";
    $username = "Shlyakhin";
    $password = "WzIwnY";
    $dbname = "project_Shlyakhin";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['Name']);
        $pass = $_POST['Pass'];

        // Максимальная длина для логина и пароля
        $maxLoginLength = 50; // Например, 50 символов
        $maxPassLength = 255;  // Например, 255 символов

        // Проверка длины логина и пароля
        if (strlen($name) > $maxLoginLength || strlen($pass) > $maxPassLength) {
            echo "<p class='error'>Слишком длинный логин или пароль!</p>";
        } else {
            // Проверяем, существует ли пользователь
            $stmt = $conn->prepare("SELECT * FROM Users WHERE Name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<p class='error'>Пользователь уже существует!</p>";
            } else {
                // Регистрация нового пользователя
                $role = "Passanger";
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT); // Хешируем пароль
                
                $stmt = $conn->prepare("INSERT INTO Users (Name, Pass, Role) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $hashed_pass, $role);
                
                if ($stmt->execute()) {
                    header("Location: passenger_dashboard.html");
                    exit();
                } else {
                    echo "<p class='error'>Ошибка: " . $stmt->error . "</p>";
                }
            }
        }
    }
    ?>

    <form method="post" action="">
        <input type="text" name="Name" placeholder="Логин" required>
        <input type="password" name="Pass" placeholder="Пароль" required>
        <input type="submit" value="Зарегистрироваться">
    </form>

    <a href="login.php" class="register-button">Уже зарегистрированы? Войти</a>

    <audio id="audio" src="img/ORLV_-_Morning_Phonk_Remix_73323637.mp3"></audio>
    <button id="toggleSound">+</button>

    <script>
        const audio = document.getElementById('audio');
        const toggleSoundBtn = document.getElementById('toggleSound');

        toggleSoundBtn.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                toggleSoundBtn.textContent = '-';
            } else {
                audio.pause();
                toggleSoundBtn.textContent = '+';
            }
        });

        function closeForm() {
            document.querySelector('.login-container').style.display = 'none';
        }
    </script>
</div>
</body>
</html>