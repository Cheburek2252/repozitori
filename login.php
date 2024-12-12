<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
$servername = "134.90.167.42:10306";
$username = "Shlyakhin";
$password = "WzIwnY";
$dbname = "project_Shlyakhin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $pass = $_POST['pass'];

    // Защита от SQL-инъекций
    $name = $conn->real_escape_string($name);
    $pass = $conn->real_escape_string($pass);

    // Запрос на выборку пользователя
    $sql = "SELECT Role FROM Users WHERE Name='$name' AND Pass='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Пользователь найден, получаем роль
        $row = $result->fetch_assoc();
        $role = $row['Role'];

        // Сохранение роли в сессии (если необходимо)
        $_SESSION['role'] = $role;

        // Перенаправление в зависимости от роли
        switch ($role) {
            case 'Admin':
                header("Location: admin_dashboard.html");
                break;
            case 'Dispetcher':
                header("Location: dispatcher_dashboard.html");
                break;
            case 'Driver':
                header("Location: driver_dashboard.html");
                break;
            case 'Passanger':
                header("Location: passenger_dashboard.html");
                break;
            default:
                echo "Неизвестная роль.";
                break;
        }
        exit();
    } else {
        echo "Неправильный логин или пароль.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Типа крутой</title>
<link rel="stylesheet" href="styles.css"> <!-- Подключение внешнего CSS -->
</head>

<body>
<div class="login-container">
<button class="close-btn" onclick="closeForm()">×</button>
<a href="https://belovokyzgty.ru/" class="logo">
<img src="img/S600xU_2x.webp" alt="Логотип" width="290">
</a>
<?php if (isset($error)): ?>
<p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="POST" action="">
<input type="text" name="name" placeholder="Логин" required>
<input type="password" name="pass" placeholder="Пароль" required>
<input type="submit" value="Войти">
</form>

<!-- Кнопка для перехода на страницу регистрации -->
<a href="register.php" class="register-button">Зарегистрироваться</a>

<audio id="audio" src="img/ORLV_-_Morning_Phonk_Remix_73323637.mp3"></audio>
<button id="toggleSound">+</button>

<script>
const audio = document.getElementById('audio');
const toggleSoundBtn = document.getElementById('toggleSound');

// Добавляем обработчик события на кнопку
toggleSoundBtn.addEventListener('click', () => {
    // Проверяем, воспроизводится ли аудио
    if (audio.paused) {
        audio.play(); // Запускаем воспроизведение
        toggleSoundBtn.textContent = '-'; // Изменяем текст кнопки на паузу
    } else {
        audio.pause(); // Ставим на паузу
        toggleSoundBtn.textContent = '+'; // Изменяем текст кнопки на воспроизведение
    }
});

// Функция для скрытия формы (если необходимо)
function closeForm() {
    document.querySelector('.login-container').style.display = 'none'; // Скрываем контейнер с формой
}
</script>
</body>
</html>