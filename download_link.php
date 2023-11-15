<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if (isset($_SESSION["logged_in"]))
    {
        if(isset($_POST["mat_hang_id"]))
        {
            $mat_hang_id = $_POST["mat_hang_id"];
            if(isset($_POST["hash"]))
            {
                $request_hash = $_POST["hash"];
                goto Start;
            }
            else
            {
                goto End;
            }
        }
        else
        {
            goto End;
        }
        Start:
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);
        $sql = "SELECT hash FROM don_hang, ctdh WHERE khach_hang_id='{$_SESSION["logged_in"]}' AND mat_hang_id = '$mat_hang_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        { 
            $row = $result->fetch_assoc();
            $actual_hash = $row["hash"];
            if(strcmp($actual_hash, $request_hash) == 0)
            {
                $sql = "SELECT file_name FROM mat_hang WHERE mat_hang_id = '$mat_hang_id'";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    $filename = 'games/' . $row["file_name"];

                    if (file_exists($filename)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($filename));
                        readfile($filename);
                        exit;
                    }
                }
                else
                {
                    $err = "Error 404!";
                }
            }
        }
        else
        {
            $err = "Error 404!";
        }
        $conn->query($sql);
        $conn->close();
        End:
    }
?>
<html>
    <head>
        <title>Downloading...</title>
    </head>
    <body>
        <h1 style="color: red"><?php if(isset($err)) {echo $err;}?></h1>
    </body>
</html>