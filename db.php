<?php 
    $dbconn = array(
        'server' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'ovkc'
    );

    $db = new PDO("mysql:host=" .$dbconn['server']. ";dbname=" .$dbconn['db'],
        $dbconn['user'],
        $dbconn['pass']
    );

    $db->exec("set names utf8mb4");

    if($db == false){
        die('Ошибка подключение базы данных');
    }

    $ovk_token = "ovk_token";
    
    function check_marketing($id){
        $data = [
            'marketing_id' => $id
        ];

        
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('https://ovk.to/method/pay.getIdByMarketingId', false, $context);

        if ($response === FALSE) {
            return 0;
        } else {
            return (int)json_decode($response, true)['response'];
        }
    }
?>
