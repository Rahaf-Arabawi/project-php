<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "furniture_store";

    $conn = new mysqli($servername , $username , $password , $databaseName);

    if ($conn->connect_error) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error',
                text: 'Connection failed: " . $conn->connect_error . "'
            });
        </script>";
        exit();
    }


?>