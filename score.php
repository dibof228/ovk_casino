<?php 
    require_once 'db.php';

    $data = $db->query('SELECT * FROM users ORDER BY wins DESC');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVK Casino</title>
    <link rel="stylesheet" href="css.css?v=<?php echo(time()) ?>">
</head>
<body>   
    <div id="score">
        <?php $i = 1 ?>
        <?php while($list = $data->fetch(PDO::FETCH_ASSOC)): ?>
            <a href="https://ovk.to/id<?php echo($list['ovk_id']) ?>" target="_blank">
                <div class="container">
                    <div>
                        <h1><?php echo($i) ?></h1>
                    </div>
                    <div>
                        <img src="<?php echo($list['img']) ?>" height="80px">
                    </div>
                    <div class="name_container">
                        <h3><?php echo(htmlspecialchars($list['name'])) ?></h3>
                        <p><?php echo($list['wins']) ?> голосов выиграно</p>
                    </div>
                </div>
            </a><br>
            <?php $i++ ?>
        <?php endwhile; ?>
    </div>
    
    <div id="stat">
        <h3>Топ игроков в Казино</h3>
    </div>
    <div id="dep">
        <a class="button" id="problem" href="javascript:history.back()">На главную</a>
    </div>
    <script src="https://ovk.to/assets/packages/static/openvk/js/GameAPI.js"></script>
</body>
</html>