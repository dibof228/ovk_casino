<?php
    header('Content-Type: application/json');

    require_once "db.php";

    $url = 'https://ovk.to/method/account.sendVotes';

    $id = check_marketing($_REQUEST['id']);

    if($id != 0 and (int)$_REQUEST['sum'] <= 1000 and (int)$_REQUEST['sum'] >= 100){
        $query = $db->query('SELECT * FROM users WHERE ovk_id = ' .$id)->fetch(PDO::FETCH_ASSOC);
        
        if((int)$_REQUEST['sum'] <= (int)$query['monet']){
            $checkspin = $db->query('SELECT * FROM mout WHERE user_id = ' .$id)->fetch(PDO::FETCH_ASSOC);
            $time = time() - (int)$checkspin['time'];
            
            if($time >= 86400){
                $data = [
                    'receiver' => $id,
                    'value' => (int)$_REQUEST['sum'] - ((int)$_REQUEST['sum'] * 0.10),
                    'message' => 'Вывод голосов с OVK Casino',
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
                    echo json_encode(array(0, 'web error'));
                } else {
                    $new_value = (int)$query['monet'] - (int)$_REQUEST['sum'];
                    $db->query("UPDATE users SET monet = " .$new_value. " WHERE ovk_id = " .$id);
                    $db->query("INSERT INTO mout (user_id, time) VALUES (" .$id. "," .time(). ")");
                    echo json_encode(array(1));
                }
            } else {
                http_response_code(400);
                echo json_encode(array(0, 'timeout'));
            }
        } else {
            http_response_code(400);
            echo json_encode(array(0, 'no money'));
        }
    } else {
        http_response_code(400);
        echo json_encode(array(0, 'check error'));
    }
?>
