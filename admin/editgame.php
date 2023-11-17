<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="..//css/addgame.css">
        <link rel="stylesheet" href="..//css/footer.css">
        <link href="https://fonts.cdnfonts.com/css/dec-terminal-modern" rel="stylesheet">
        <link rel="stylesheet" href="..//css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>
    <?php
        /*ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);

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

        if(empty($_GET["id"]))
        {
            header("Location: games.php");
        }
        else
        {
            $sql = "SELECT * FROM mat_hang WHERE mat_hang_id = '{$_GET["id"]}'";
            $result = $conn->query($sql);
            if($result->num_rows <= 0)
            {
                header("Location: games.php");
            }
            $row = $result->fetch_assoc();
            $gamename = $row["ten_mat_hang"];
            $price = $row["don_gia"];
            $menugame = $row["the_loai"];
            $menudev = $row["dev_team_id"];
            $motagame = $row["mo_ta"];
            $name_game = $row["file_name"];
            $name_image = $row["anh"];
        }

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
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
                if($price == 0){
                    $msg2 = "Đơn giá không thể bằng 0";
                }
                else{
                    $msg2 = "Đơn giá không thể âm";
                }
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
                if(!empty($_FILES["image"]["name"])) {
                    $new_name = str_replace(" ", "_", $gamename.uniqid());
                    $_FILES['image']['name'] = $new_name. '.png';
                    $size = $_FILES['image']['size'];
                    $type = $_FILES['image']['type'];
                    $name_image = $_FILES['image']['name']; 
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $file_path = '..//game_img' . '/' . $name_image;
                    move_uploaded_file($tmp_name, $file_path);
                    
                }
                if(!empty($_FILES["game"]["name"])) {
                    $new_name = str_replace(" ", "_", $gamename.uniqid());
                    $_FILES['game']['name'] = $new_name. '.zip';
                    $size = $_FILES['game']['size'];
                    $type = $_FILES['game']['type'];
                    $name_game = $_FILES['game']['name'];
                    $tmp_name = $_FILES['game']['tmp_name'];
                    $file_path = '..//games' . '/' . $name_game;
                    move_uploaded_file($tmp_name, $file_path);
                    
                    
                }
                $motagame = '"' . $motagame . '"';
                $sql = "UPDATE mat_hang SET ten_mat_hang = '$gamename', don_gia = '$price', the_loai = '$menugame', mo_ta = $motagame, anh = '$name_image', dev_team_id = '$menudev', file_name = '$name_game' WHERE mat_hang_id = '{$_GET["id"]}'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        echo "<script>alert('Sửa game thành công'); window.location.href='games.php';</script>";
                        $conn->close();
                        header("Location: games.php");
                    }
            }
        }
    ?>
    <body>
        <?php
            include("..//admin/admin_panel.php");
        ?>
        <main>
            <form method="post" enctype="multipart/form-data">
                    <table class="addgame">
                        <tr>
                            <th >Tên Game</th>
                            <td>
                                <input type="text" name="gamename" id="gamename" value="<?php if(isset($gamename)) {echo $gamename;} ?>" required placeholder="Nhập tên game">
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg1)) {echo $msg1;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Đơn Giá</th>
                            <td>
                                <input type="number" name="price" id="price" value="<?php if(isset ($price)) {echo $price;} ?>"placeholder="Nhập giá" required> (vnđ)
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg2)) {echo $msg2;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Thể Loại</th>
                            <td>
                                <select id="menugame" name="menugame">
                                <option value="">Chọn thể loại</option>
                                <?php
                                    $sql = "SELECT * FROM the_loai";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        for ($i = 0; $i < $result->num_rows; $i++) {
                                            $row = $result->fetch_assoc();
                                            $the_loai_id = $row["the_loai_id"];
                                            $ten_the_loai = $row["ten_the_loai"];
                                            $selected = ($menugame == $the_loai_id) ? "selected" : "";
                                            echo "<option value='$the_loai_id' $selected>$ten_the_loai</option>";
                                        }
                                        } else {
                                            echo "Không có Thể loại nào được tìm thấy.";
                                        }
                                    ?>
                                </select>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg3)) {echo $msg3;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Mô Tả</th>
                            <td>
                                <textarea name="motagame" id="motagame" cols="30" rows="5" placeholder="Nhập mô tả game"><?php echo isset($motagame) ? $motagame : ''; ?></textarea>
                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg4)) {echo $msg4;} ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Hình ảnh</th>
                            <td>
                                <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg" >
                            </td>
                        </tr>
                        <tr>
                            <th>File game</th>
                            <td>
                                <input type="file" name="game" id="image" accept=".zip">
                            </td>
                        </tr>
                        <tr>
                            <th>Dev Team</th>
                            <td>
                                <select id="menudev" name="menudev">
                                    <option value="">Chọn Dev team</option>
                                    <?php
                                    $sql = "SELECT * FROM dev_team";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $dev_id = $row["dev_id"];
                                            $dev_name = $row["dev_name"];
                                            $selected = ($menudev == $dev_id) ? "selected" : "";
                                            echo "<option value='$dev_id' $selected>$dev_name</option>";
                                        }
                                    } else {
                                        echo "Không có Dev team nào được tìm thấy.";
                                    }
                                    ?>
                                </select>

                                <div style="color: red; font-size: 16px; font-weight: bold;"><?php if(isset($msg5)) {echo $msg5;} ?></div>
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