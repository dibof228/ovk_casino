<?php 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

// Проверяем, является ли браузер Chrome или Firefox и получаем версию
    $is_chrome = preg_match('/Chrome\/(\d+)/', $user_agent, $chrome_matches);
    $is_firefox = preg_match('/Firefox\/(\d+)/', $user_agent, $firefox_matches);
    
    $redirect = false;
    
    if ($is_chrome && $chrome_matches[1] <= 91) {
        // Версия Chrome <= 92
        $redirect = true;
    } elseif ($is_firefox && $firefox_matches[1] <= 97) {
        // Версия Firefox <= 95
        $redirect = true;
    }
    
    if ($redirect) {
        // Перенаправляем на другую страницу
        header('Location: badbrowser.html');
        exit(); // Важно завершить выполнение скрипта после перенаправления
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVK Casino</title>
    <link rel="stylesheet" href="css.css?v=<?php echo(time()) ?>">
    <script src="casino.js?v=<?php echo(time()) ?>"></script>
    <script src="https://ovk.to/assets/packages/static/openvk/js/GameAPI.js?v=<?php echo(time()) ?>"></script>
    
</head>
<body>   
    <dialog id="share">
        <div class="inner">
            <div class="head">
                Различные действия
            </div>
            <div id="body2">
                <h3>Вывод средств</h3>
                <p>
                    Вы можете вывести от 100 до 1000 голосов в день с коммисией 10% в выводе себе на баланс.<br>
                    Тоесть, если вы решили вывести себе 100 голосов, то будет: 100 голосов - 10% = 90 голосов
                </p>
                <a href="javascript:out(document.getElementById('sum2').value)">Вывести </a>
                <!-- Если изменишь max, то ты так не сможешь меня наебать. Все проверки делаются на бекенде) -->
                <input type="number" style="width: 50px;" step="5" min="100" max="1000" id="sum2" value="100">
                <a href="javascript:out(document.getElementById('sum2').value)"> голосов</a>
                <hr>
                <h3>Реферальные ссылки</h3>
                <p>Подумаем о их добавлении</p>
            </div>
            <div class="actions">
                <a href="javascript:document.querySelector('#share').close();">Закрыть</a>
            </div>
        </div>
    </dialog>
    <div id="baraban">
        <img src="0.png" id="1">
        <img src="0.png" id="2">
        <img src="0.png" id="3">
    </div>
    <div id="stat">
        <p>Баланс: <span id="monet">Загрузка</span> голосов, <span id="wins">Загрузка</span> выиграно<br>
        На ставку <input type="number" style="width: 50px;" step="5" min="5" max="200" id="stabvka" value="5"> голсов</p>
        <a href="javascript:dep(document.getElementById('sum').value, 'Деп голосов в казик')">Депнуть </a>
        <input type="number" style="width: 50px;" step="5" min="5" id="sum" value="5">
        <a href="javascript:dep(document.getElementById('sum').value, 'Деп голосов в казик')"> голосов</a>
    </div>
    <div id="dep">
        <a href="javascript:document.querySelector('#share').showModal();" class="button"><img src="share.png?v=<?php echo(time()) ?>" height="24px"></a>
        <a href="score.php" class="button"><img src="kubok.png?v=<?php echo(time()) ?>" height="24px"></a>
        <button onclick="spin()" class="button" id="spin" style="border-radius: 29px;"><img src="spin.png?v=<?php echo(time()) ?>" width="24px"></button>
    </div>
</body>
</html>