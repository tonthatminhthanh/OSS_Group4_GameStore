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
        
    </head>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $menugame = "";
        $menudev = "";
        if(isset($_POST["submit"])) {
            $gamename = $_POST["gamename"];
            $price = $_POST["price"];
            $menugame = $_POST["menugame"];
            $motagame = $_POST["motagame"];
            $menudev = $_POST["menudev"];
            if(is_numeric($gamename)) {
                $msg1 = "Vui lòng nhập tên game";
            }
            elseif($price<1) {
                $msg2 = "Đơn giá không thể bé hơn 0";
            }
            elseif(empty($menugame)) {
                $msg3 = "Vui lòng chọn thể loại";
            }
            elseif(empty($motagame)) {
                $msg4 = "Vui lòng nhập mô tả";
            }
            elseif(empty($menudev)){
                $msg5 = "Vui lòng chọn Dev Team";
            }
            else{
                    $sql = "SELECT *
                      FROM mat_hang
                      WHERE ten_mat_hang = '$gamename';";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        echo "<script>alert('Trùng tên');</script>";
                }else {
                    if (isset($_FILES['image'])){
                        $new_name = str_replace(" ", "_", $gamename.uniqid());
                        $_FILES['image']['name'] = $gamename. '.png';
                        $name_image = $_FILES['image']['name'];
                        $size = $_FILES['image']['size'];
                        $type = $_FILES['image']['type'];
                        $tmp_name = $_FILES['image']['tmp_name'];
                      $file_path = 'img' . '/' . $name_image;
                      move_uploaded_file($tmp_name, $file_path);
                        $sql = "INSERT INTO mat_hang (ten_mat_hang, don_gia, the_loai, mo_ta, anh, dev_team_id) VALUES ('$gamename', '$price', '$menugame', '$motagame','$name_image', '$menudev')";
                    $result = mysqli_query($conn, $sql);
                    }else{echo "<script>alert('ko có ảnh','Thông báo từ hệ thống');</script>";}
                    
                    if ($result) {
                        echo "<script>alert('Thêm game thành công'); window.location.href='index.php';</script>";
                    }
                     else {
                        $msg6 = "Thêm thất bại";
                    }
                    $conn->close();
                  }
                }
            }
    ?>
    <body>
        <?php
            include("header.php");
        ?>
        <main>
            <form action="addgame.php" method="post" enctype="multipart/form-data">
                    <table class="addgame">
                        <tr>
                            <th >Tên Game</th>
                            <td>
                                <input type="text" name="gamename" value="<?php if(isset($gamename)) {echo $gamename;} ?>" required placeholder="Nhập tên game">
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg1)) {echo $msg1;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Đơn Giá</th>
                            <td>
                                <input type="number" name="price" value="<?php if(isset ($price)) {echo $price;} ?>" > (vnđ)
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg2)) {echo $msg2;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Thể Loại</th>
                            <td>
                                <select id="menugame" name="menugame">
                                    <option value="">Chọn thể loại</option>
                                    <option value="1" <?php if($menugame == "1") { echo "selected"; } ?>>First Person Shooter</option>
                                    <option value="3" <?php if($menugame == "3") { echo "selected"; } ?>>Real Time Strategy</option>
                                </select>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg3)) {echo $msg3;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Mô Tả</th>
                            <td>
                                <textarea name="motagame" id="motagame" cols="30" rows="5"><?php echo isset($motagame) ? $motagame : ''; ?></textarea>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg4)) {echo $msg4;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Hình ảnh</th>
                            <td>
                                <input type="file" name="image" accept="image/png, image/gif, image/jpeg">
                            </td>
                        </tr>
                        <tr>
                            <th>Dev Team</th>
                            <td>
                                <select id="menudev" name="menudev">
                                    <option value="">Chọn Dev team</option>
                                    <option value="1" <?php if($menugame == "1") { echo "selected"; } ?>>Tastyfish</option>
                                    <option value="2" <?php if($menugame == "2") { echo "selected"; } ?>>OpenRA Developers</option>
                                </select>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg5)) {echo $msg5;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="submit" name="submit" value="Xác nhận">
                                <a href="javascript:history.back()">quay về</a>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg6)) {echo $msg6;} ?></div>
                            </td>
                        </tr>
                    </table>
            </form>
        </main>
        <div>
            <?php
                include("footer.php");
            ?>
        </div>
    </body>
</html>