<?php 
    require_once "db.php";

    header('Content-Type: application/json');

    $id = check_marketing($_REQUEST['id']);

    $query = $db->query('SELECT * FROM users WHERE ovk_id = ' .$id);

    if($query->rowCount() != 0){
        $query = $db->query('SELECT * FROM users WHERE ovk_id = ' .$id)->fetch(PDO::FETCH_ASSOC);
        
        if((int)$query['monet'] >= 5){
            
            $checkspin = $db->query('SELECT * FROM spins WHERE ovk_id = ' .$id)->fetch(PDO::FETCH_ASSOC);
            $time = time() - (int)$checkspin['time'];
            
            if($time >= 5){
                if((int)$_REQUEST['sum'] <= (int)$query['monet']){
                    if((int)$_REQUEST['sum'] <= 200 and (int)$_REQUEST['sum'] >= 5){
                        $monet = (int)$query['monet'] - (int)$_REQUEST['sum'];
            
                        function checkNumberOccurrences(array $array, int $number, int $minOccurrences): bool {
                            $counts = array_count_values($array);
                            return isset($counts[$number]) && $counts[$number] >= $minOccurrences;
                        }
            
                        $slots = array();
                        $money = 0;
                
                        for($i=0; $i < 3; $i++){
                            $random = mt_rand(0, 99);
                        
                            if ($random >= 0 && $random <= 29) {
                                $random = 1;
                            } elseif ($random >= 30 && $random <= 59) {
                                $random = 2;
                            } elseif ($random >= 60 && $random <= 79) {
                                $random = 3;
                            } elseif ($random >= 80 && $random <= 91) {
                                $random = 4;
                            } elseif ($random >= 92 && $random <= 97) {
                                $random = 5;
                            } elseif ($random >= 98 && $random <= 99) {
                                $random = 6;
                            }
                
                            $slots[] = $random;
                            
                        }
                
                        if (checkNumberOccurrences($slots, 1, 3)) {
                            $money = $money + (5 * ((int)$_REQUEST['sum'] / 5));
                        } 
                        if (checkNumberOccurrences($slots, 2, 3)) {
                            $money = $money + (5 * ((int)$_REQUEST['sum'] / 5));
                        } 
                        if (checkNumberOccurrences($slots, 3, 2)) {
                            if (checkNumberOccurrences($slots, 3, 3)) {
                                $money = $money + (8 * ((int)$_REQUEST['sum'] / 5));
                            } else {    
                                $money = $money + (3 * ((int)$_REQUEST['sum'] / 5));
                            }
                        } 
                        
                            
                        if (checkNumberOccurrences($slots, 4, 2)) {
                            if (checkNumberOccurrences($slots, 4, 3)) {
                                $money = $money + (10 * ((int)$_REQUEST['sum'] / 5));
                            } else{
                                $money = $money + (5 * ((int)$_REQUEST['sum'] / 5));
                            }
                        } 
                        
                        if (checkNumberOccurrences($slots, 5, 1)) {
                            if (checkNumberOccurrences($slots, 5, 3)) {
                                $money = $money + (15 * ((int)$_REQUEST['sum'] / 5));
                            } elseif (checkNumberOccurrences($slots, 5, 2)) {
                                $money = $money + (10 * ((int)$_REQUEST['sum'] / 5));
                            } else {
                                $money = $money + (8 * ((int)$_REQUEST['sum'] / 5));
                            }
                        } 
                        
                        
                        if (checkNumberOccurrences($slots, 6, 1)) {
                            if (checkNumberOccurrences($slots, 6, 3)) {
                                $money = $money + (30 * ((int)$_REQUEST['sum'] / 5));
                            } else if (checkNumberOccurrences($slots, 6, 2)) {
                                $money = $money + (20 * ((int)$_REQUEST['sum'] / 5));
                            } else{
                                $money = $money + (10 * ((int)$_REQUEST['sum'] / 5));
                            }
                        } 
                
                        $query_money = $monet + $money;
                        $query_wins = (int)$query['wins'] + $money;
                        
                        $db->query("UPDATE users SET monet = " .$query_money. " WHERE ovk_id = " .$id);
                        $db->query("UPDATE users SET wins = " .$query_wins. " WHERE ovk_id = " .$id);
                        $db->query("INSERT INTO spins (ovk_id, time) VALUES (" .$id. ", ".time().")");
                
                        $response = array(
                            'slots' => $slots,
                            'wins' => $query_wins,
                            'money' => $query_money
                        );
                
                        echo(json_encode($response));
                    } else {
                        http_response_code(400);
                        echo json_encode(array(0));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array(0));
                }
            } else {
                http_response_code(400);
                echo json_encode(array(0));
            }
        } else {
            http_response_code(400);
            echo json_encode(array(0));
        }
    } else {
        http_response_code(400);
        echo json_encode(array(0));
    }
?>