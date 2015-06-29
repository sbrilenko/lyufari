<?php
    // Определение параметров базы данных по умолчанию
    if ($_SERVER[REMOTE_ADDR]=="127.0.0.1") {   // подключение с локального компьютера - отладка на локальной машине
        define("const_dbName","lu");
        define("const_hostName","localhost");
        define("const_userName","root");
        define("const_password","");   
    } else {                                    // подключение с сервера
         define("const_dbName","lu");
        define("const_hostName","localhost");
        define("const_userName","lu");
        define("const_password","gNy9mSzq");
    }
?>