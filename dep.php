<?php
    header('Content-Type: application/json');

    require_once "db.php";

    $url = 'https://ovk.to/method/pay.verifyOrder';

    $id = check_marketing($_REQUEST['id']);

    $data = [
        'id' => $id,
        'amount' => $_REQUEST['sum'],
        'signature' => $_REQUEST['signature'],
        'app_id' => 451,
        'access_token' => $ovk_token
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);

    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        http_response_code(400);
        echo json_encode(array(0));
    } else {
        $signature = $db->query('SELECT * FROM signature WHERE signature = ' .$db->quote($_REQUEST['signature']));

        if($signature->rowCount() == 0){
            $db->query("INSERT INTO signature (signature) VALUES (" .$db->quote($_REQUEST['signature']). ")");

            $query = $db->query('SELECT monet FROM users WHERE ovk_id = ' .$id)->fetch(PDO::FETCH_ASSOC);
            $money = (int)$query['monet'];
            $new_money = $money + (int)$_REQUEST['sum'];

            $db->query("UPDATE users SET monet = " .$new_money. " WHERE ovk_id = " .$id); 
            echo json_encode(array('money' => $new_money));
        } else {
            http_response_code(400);
            echo json_encode(array(0));
        }
    }
?>
