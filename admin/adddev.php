<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="..//css/adddev.css">
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
            $devname = $_POST["devname"];
            $devaddress = $_POST["devaddress"];
            
            if(is_numeric($devname)) {
                $msg1 = "Vui lòng nhập tên Dev Team";
            }
            elseif(empty($devaddress)) {
                $msg2 = "Vui lòng nhập địa chỉ";
            }
            else{
                    $sql = "SELECT *
                    FROM dev_team
                    WHERE dev_name = '$devname';";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $msg1 = "Trùng tên";
                    }else {         
                        if(empty($_FILES["image"]["name"])) {
                            echo "<script>alert('Không có ảnh');</script>";           
                        }
                        else{
                            $new_name = str_replace(" ", "_", $devname.uniqid());
                            $_FILES['image']['name'] = $devname. '.png';
                            $size = $_FILES['image']['size'];
                            $type = $_FILES['image']['type'];
                            $name_image = $_FILES['image']['name']; 
                            $tmp_name = $_FILES['image']['tmp_name'];
                            $file_path = '..//dev_img' . '/' . $name_image;
                            move_uploaded_file($tmp_name, $file_path);
                            $sql = "INSERT INTO dev_team (dev_name, address, anh) VALUES ('$devname', '$devaddress','$name_image')";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo "<script>alert('Thêm Dev Team thành công'); window.location.href='games.php';</script>";
                                $conn->close();
                            } 
                            
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
            <form action="adddev.php" method="post" enctype="multipart/form-data">
                    <table class="adddev">
                        <tr>
                            <th >Tên Dev Team</th>
                            <td>
                                <input type="text" name="devname" id="devname" value="<?php if(isset($devname)) {echo $devname;} ?>" required placeholder="Nhập tên Dev Team">
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg1)) {echo $msg1;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td>
                                <textarea name="devaddress" id="devaddress" cols="30" rows="5" placeholder="Nhập địa chỉ Dev Team"><?php echo isset($devaddress) ? $devaddress : ''; ?></textarea>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg2)) {echo $msg2;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Hình ảnh</th>
                            <td>
                                <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg" >
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