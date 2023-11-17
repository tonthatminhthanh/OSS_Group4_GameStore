<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="..//css/addtheloai.css">
        <link rel="stylesheet" href="..//css/footer.css">
        <link href="https://fonts.cdnfonts.com/css/dec-terminal-modern" rel="stylesheet">
        <link rel="stylesheet" href="..//css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>
    <?php
        session_start();
        if (isset($_SESSION["admin_id"]))
        {
            if(isset($_POST["log_out"]))
            {
                unset($_SESSION["admin_id"]);
                unset($_SESSION["admin_name"]);
                header("Location: ../admin_page.php");
            }
        }
        else
        {
            header("Location: ../admin_page.php");
        }
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if(isset($_POST["submit"])) {
            $theloai = $_POST["theloai"];
            if(is_numeric($theloai)) {
                $msg1 = "Vui lòng nhập tên Thể loại";
            }
            else{
                    $sql = "SELECT *
                    FROM the_loai
                    WHERE ten_the_loai = '$theloai';";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $msg1 = "Trùng thể loại";
                    }
                    else {         
                            $sql = "INSERT INTO the_loai (ten_the_loai) VALUES ('$theloai')";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo "<script>alert('Thêm Thể Loại thành công'); window.location.href='games.php';</script>";
                                $conn->close();
                            } 
                            
                        }
                    }
                
            }
    ?>
    <body>
        <?php
            include("..//admin/admin_panel.php");
        ?>
        <main>
            <form action="addtheloai.php" method="post">
                    <table class="addtheloai">
                        <tr>
                            <th >Tên Thể Loại</th>
                            <td>
                                <input type="text" name="theloai" id="theloai" value="<?php if(isset($theloai)) {echo $theloai;} ?>" required placeholder="Nhập tên Thể Loại">
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg1)) {echo $msg1;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="submit" name="submit" id="submit" value="Xác nhận">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center; padding-top: 20px;">
                                <a href="games.php" style="color: darkgreen;">quay về</a>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg6)) {echo $msg6;} ?></div>
                            </td>
                        </tr>
                    </table>
            </form>
        </main>
    </body>
</html>