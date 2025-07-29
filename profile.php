<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Буртовый B.A.</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Custom font-size for the text */
        h2, p {
            font-size: 14px; /* Reduce the size of the main text */
        }

        /* Style for the additional information block */
        .additional-info {
            margin-top: 20px;
            max-width: 600px; /* Limit the width to the left side */
            font-size: 12px; /* Smaller text for the additional info */
            color: aqua;
        }

        /* Author block style */
        .author-block {
            margin-top: 30px;
            font-size: 14px;
            text-align: left;
            font-weight: bold;
            color: rgb(20, 23, 0);
        }

        /* Custom styles for the alert */
        .custom-alert {
            background-color: black; /* Black background */
            color: white; /* White text */
        }
    </style>
</head>
<body>
    <!-- Demo version block -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert custom-alert text-center">
                    Рубрика: Говорим о том, о ком говорим
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="container nav_bar">
        <div class="row">
            <div class="row">
                <div class="col-3 nav_logo"></div>
                <div class="col-3">
                    <div class="nav_text">Краткая сводка</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2>Буртовый Владимир - начинающий специалист по информационной безопасности с базовыми знаниями 
                в области защиты компьютерных систем и сетей. Любимые фразы: "Инновация начинается с кода."
                "Каждая строка кода — это возможность изменить мир." "IT - это искусство сделать невозможное возможным."
                </h2>

                <!-- Additional information block -->
                <div class="additional-info">
                    <h3>Дополнительная информация:</h3>
                    <p>Я стремлюсь развиваться в области информационной безопасности, особенно в защите от кибератак и управлении безопасностью сетей. В ближайшее время планирую освоить такие технологии, как SIEM и SOC, для мониторинга и реагирования на инциденты безопасности.</p>
                </div>

                <!-- Author block -->
                <div class="author-block">
                    Автор: Буртовый В.А.
                </div>

                <!-- Button -->
                <div class="text-center">
                    <button id="myButton" class="btn btn-primary">Попробуй нажать</button>
                    <p id="demo"></p>
                </div>
            </div>
            <div class="col-4">
                <div class="row my_photo"></div>
                <div class="row"><p class="title_photo">Буртовый В.А.</p></div>
            </div>
        </div>
    </div>
        <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="hello">
                    Привет, <?php echo $_COOKIE['User']; ?>
                </h1>
            </div>
            <div class="col-12">
                <form method="POST" action="profile.php" enctype="multipart/form-data" name="upload">
                    <input type="text" class="form" type="text" name="title" placeholder="Заголовок вашего поста">
                    <textarea name="text" cols="30" rows="10" placeholder="Введите текст вашего поста....."></textarea>
                    <input type="file" name="file" /><br>
                    <button type="submit" class="btn_red" name="submit">Сохранить пост!</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/button.js"></script>
</body>
</html>


<?php
require_once('db.php');
$link = mysqli_connect('db', 'root', 'kali', 'first');

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $main_text = mysqli_real_escape_string($link, $_POST['text']);

    if (!$title || !$main_text) {
        die("Заполните все поля");
    }

    $image_path = '';

    if (!empty($_FILES["file"]["name"])) {
        $file_type = $_FILES["file"]["type"];
        $file_size = $_FILES["file"]["size"];
        $allowed_types = [
            "image/gif", "image/jpeg", "image/jpg",
            "image/pjpeg", "image/x-png", "image/png"
        ];

        if (in_array($file_type, $allowed_types) && $file_size < 10240000) {
            // Убедимся, что папка существует
            $upload_dir = 'upload/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = time() . "_" . basename($_FILES["file"]["name"]);
            $targetPath = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                echo "Файл загружен успешно.<br>";
                $image_path = $targetPath;
            } else {
                echo "Ошибка: Загрузка не удалась. Проверьте права на запись в папку 'upload/'.<br>";
            }
        } else {
            echo "Неверный формат файла или превышен размер (макс. 10 МБ).<br>";
        }
    } else {
        echo "Файл не загружен, пост будет сохранен без изображения.<br>";
    }
    
    $sql = "INSERT INTO posts (title, main_text, image_path) VALUES ('$title', '$main_text', '$image_path')";
    if (!mysqli_query($link, $sql)) {
        die("Не удалось добавить пост");
    }
}

mysqli_close($link);
?>
