<?php 
    require_once "db.php";

    header('Content-Type: application/json');

    $id = check_marketing($_REQUEST['id']);

    if($id != 0){
        $query = $db->query("SELECT * FROM users WHERE ovk_id = " .$id);

        if($query->rowCount() == 0){
            $db->query("INSERT INTO users (ovk_id, name, img) VALUES (" .$id. ", " .$db->quote($_REQUEST['name']). ", " .$db->quote($_REQUEST['ava']). ")");
        } else {
            $db->query("UPDATE users SET name = " .$db->quote($_REQUEST['name']). ", img = " .$db->quote($_REQUEST['ava']). " WHERE ovk_id = " .$id); 
        }

        $query = $db->query('SELECT * FROM users WHERE ovk_id = ' .$id)->fetch(PDO::FETCH_ASSOC);

        echo json_encode(array('money' => $query['monet'], 'wins' => $query['wins']));
    } else {
        http_response_code(400);
        echo json_encode(array(0));
    }
?>