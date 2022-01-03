<?php

    $db = mysqli_connect("localhost","root","","veritabanıproje");
    mysqli_set_charset($db,"UTF8");
    if(mysqli_connect_errno()>0){
        die("Hata : ".mysqli_connect_errno());
    }
    
?>