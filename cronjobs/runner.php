<?php
# NOTE 6 HOURS cronjobs = 21600 seconds divided by 3 = 7200 BUT REAL 12 HOUR TEST
$limit = 7200;
for($i = 0; $i < $limit; $i++){
    $url = "http://localhost/webinar-integrate/cronjobs/cronjob.php";
    $req = $url;
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $req,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    sleep(3);
}

?>