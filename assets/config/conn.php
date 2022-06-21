<?php

    $conn = new mysqli($config['db']['db1']['host'], $config['db']['db1']['username'], $config['db']['db1']['password'], $config['db']['db1']['dbname']);        
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>