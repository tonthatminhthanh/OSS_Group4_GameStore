<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["logged_in"]))
    {
        $id = $_SESSION["logged_in"];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);
        $sql = "SELECT *
			FROM khach_hang
			WHERE khach_hang_id = '$id';";
			$result = $conn->query($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row["ten_khach_hang"];
            $og_dob = $row["ngay_sinh"];
            $dob = date("d/m/Y", strtotime($row["ngay_sinh"]));
            $og_gender = $row["gioi_tinh"];
            if($row["gioi_tinh"] == 1)
            {
                $gender = "Nam";
            }
            else
            {
                $gender = "Nữ";
            }
            $pfp = $row["anh_dai_dien"];
        }

        if(isset($_POST["submit"]))
        {
            $new_name = $_POST["name"];
            if(!preg_match("/^[A-Za-z0-9_ ]{4,100}$/", $new_name))
            {
                $err = "Tên không được có kí tự đặc biệt!";
                goto End;
            }
            $new_dob = $_POST["dob"];
            $timeOfDateOfBirth = strtotime($new_dob);
            $currentTime = time();
            if($timeOfDateOfBirth > $currentTime){
                $err = "Ngày sinh không hợp lệ!";
                goto End;
            }
            $new_gender = $_POST["gender"];
            if($_FILES["image"]["error"] == 0)
            {
                $new_img = str_replace(" ", "_", $new_name.uniqid());
                $_FILES['image']['name'] = $new_img.'.jpg';
                $name_image = $_FILES['image']['name'];
                $size = $_FILES['image']['size'];
                $type = $_FILES['image']['type'];
    
                $dir = 'User_Images';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
    
                $tmp_name = $_FILES['image']['tmp_name'];
                $file_path = $dir . '/' . $name_image;
                move_uploaded_file($tmp_name, $file_path);
                $image_name = $_FILES['image']['name'];
                $_SESSION["curr_pfp"] = $image_name;
                $sql = "UPDATE khach_hang SET ten_khach_hang='$new_name', ngay_sinh='$new_dob', gioi_tinh='$new_gender', anh_dai_dien='$image_name' WHERE khach_hang_id='$id'";
            }
            else
            {
                $sql = "UPDATE khach_hang SET ten_khach_hang='$new_name', ngay_sinh='$new_dob', gioi_tinh='$new_gender' WHERE khach_hang_id='$id'";
            }
			$result = $conn->query($sql);
            if(!$result)
            {
                echo "<script>alert('Query failed','Thông báo từ hệ thống');</script>";
            }
            else
            {
                $_SESSION["logged_in_name"] = $new_name;
                header("Location: ThongtinCaNhan.php");
            }
        }
        End:
    }
    else
    {
        header("Location: index.php");
    }
?>
<html>
<body>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/dec-terminal-modern" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <header><?php require("header.php"); ?></header>
    <div style="padding-top: 50px;"></div>
    <main class="container">
    <h2 style="font-size: 24px"><?php if(isset($_GET["edit"])) {echo "Sửa t";} else {echo "T";} ?>hông tin người dùng</h2>
    <h3 style="color: red"><?php if(isset($err)) {echo $err;} ?></h3>
<?php
    if(!isset($_GET["edit"]))
    {
        echo "<img src='User_Images/$pfp' style='border-radius: 100%' width='150px' height='150px'>";
        echo "<p style='font-size: 20px'>Tên hiển thị: $name</p>
        <p style='font-size: 20px'>Ngày sinh: $dob</p>
        <p style='font-size: 20px'>Giới tính: $gender</p>";
        echo "<a href='?edit=1'>Sửa thông tin người dùng</a>";
    }
    else
    {
        echo "
            <form method='post' enctype='multipart/form-data'>
                <table>
                    <tr>
                        <td><p style='font-size: 20px'>Tên hiển thị:</td>
                        <td><input type='text' name='name' value='$name' required></td>
                    </tr>
                    <tr>
                        <td><p style='font-size: 20px'>Ngày sinh:</td>
                        <td><input type='date' name='dob' value='$og_dob' required></td>
                    </tr>
                    <tr>
                        <td><p style='font-size: 20px'>Giới tính: </p></td>";
                        echo "<td>";
                        if($og_gender == 1)
                        {
                            echo "Nam <input type='radio' name='gender' value='1' checked>";
                            echo "Nữ <input type='radio' name='gender' value='0'>";
                        }
                        else
                        {
                            echo "Nam <input type='radio' name='gender' value='1'>";
                            echo "Nữ <input type='radio' name='gender' value='0' checked>";
                        }
                        echo "
                        </td>
                    </tr>
                    <tr>
                        <td><p style='font-size: 20px'>Ảnh đại diện: </td><td><input type='file' name='image' accept='image/png, image/gif, image/jpeg'></p></td>
                    </tr>
                </table>
                <input type='submit' name='submit' value='Sửa'><br><a href='?'>Quay lại</a>
            </form>
        ";
    }
?>
    </main>
</body>
</html>
