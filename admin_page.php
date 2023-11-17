<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Gamers_Alliance";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST["submit"])) {
        $uname = $_POST["uname"];
        $passwd = $_POST["passwd"];

        $sql = "SELECT admin_id, password FROM admin WHERE username = '$uname';";
		$result = $conn->query($sql);
        if($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            $hash = $row["password"];
            if(password_verify($passwd, $hash)) {
                echo "<script>alert('Đăng nhập thành công');</script>";
                $_SESSION["admin_id"] = $row["admin_id"];
                $_SESSION["admin_name"] = $uname;
                header("Location: admin/games.php");
            } else {
                $err = "Sai mật khẩu!";
            }
        }
        else
        {
            $err = "Không có tài khoản!";
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="css/addgame.css">
        <link rel="stylesheet" href="css/footer.css">
        <link href="https://fonts.cdnfonts.com/css/dec-terminal-modern" rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .center_screen {
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                min-height: 100vh;
                background-color: gray;
            }
        </style>
    </head>
    <body>
        <div class="center_screen">
            <h3>Admin Panel Login</h3>
            <form method="post">
                Tên đăng nhập:<br>
                <input type="text" name="uname" required><br>
                Mật khẩu:<br>
                <input type="password" name="passwd" required><br>
                <input type="submit" name="submit" value="Đăng nhập">
                <div style="color: red"><?php if(isset($err)) {echo $err;} ?></div>
            </form>
        </div>
    </body>   
</html>