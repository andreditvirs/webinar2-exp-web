<?php
class ChatController{
    function isSameUpdateId($connection, $update_id)
    {
        $query = "SELECT update_id FROM chat WHERE update_id = '".$update_id."'";
        $query_update_id = mysqli_query($connection, $query);
        $result = mysqli_fetch_assoc($query_update_id);
        if($result && array_key_exists('update_id', $result) && $result['update_id'] != NULL){
            return true;
        }else{
            return false;
        }
    }

    function storeChat($connection, $values)
    {
        $query = "INSERT INTO chat (update_id, message, from_id, date, text) VALUES (".$values['update_id'].", '".$values['message']."', '".$values['from']."', '".$values['date']."', '".$values['text']."')";
        mysqli_query($connection, $query);
    }
}
?>