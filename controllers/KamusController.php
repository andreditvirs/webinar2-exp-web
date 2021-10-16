<?php 

class KamusController
{
    function getDefinifition($connection, $word)
    {
        $query_text = "SELECT * FROM kamus FIRST WHERE kata = '".$word."'";
        $query = mysqli_query($connection, $query_text);
        $data = mysqli_fetch_assoc($query);
        return $data["keterangan"];
    }
}