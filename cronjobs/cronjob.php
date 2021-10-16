<?php
include_once('..\db-config\conn.php');
include_once('..\variables\index.php');
require_once('..\controllers\ChatController.php');
require_once('..\controllers\KamusController.php');

$token = $var_telegram_api;
$results = send($token, '/getUpdates', '');

$chat_controller = new ChatController;
$kamus_controller = new KamusController;

// echo json_encode($results, JSON_PRETTY_PRINT);
if($results["ok"]){
    foreach($results["result"] as $result){
        if(!$chat_controller->isSameUpdateId($conn, $result["update_id"])){
            if(array_key_exists('message', $result)){ // Chat include edited and non-edited message reject when user edited message
                if(array_key_exists('text', $result["message"]) && $result["message"]["entities"][0]["type"] == 'bot_command'){ // BOT COMMAND OR ADDITIONAL QUESTION
                    if(explode(' ', $result["message"]["text"])[0] == '/arti'){
                        $word = explode(' ', $result["message"]["text"])[1];
                        $values = array("update_id" => $result["update_id"], "message" => json_encode($result["message"]), "from" => $result["message"]["from"]["id"], "date" => $result["message"]["date"], "text" => $result["message"]["text"]);
                        $chat_controller->storeChat($conn, $values);

                        $keterangan = $kamus_controller->getDefinifition($conn, $word);
                        $message_text = $keterangan;
                        send($token, "/sendMessage", "?parse_mode=HTML&chat_id=" .$result["message"]["chat"]["id"]. "&text=" .urlencode($message_text));
                    }
                }
            }
        }
    }
}

function send($token, $function, $param = '') { // function is method telegram official
    $url = "https://api.telegram.org/bot" . $token;
    $req = $url.$function.$param;
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $req,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo 'ERROR :' . $err;
    }else{
        return json_decode($result, true);
    }
}
?>