<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng ký</title>
        <link rel="stylesheet" href="https://codepen.io/gymratpacks/pen/VKzBEp#0">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="register.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
    <?php
        require("header.html");
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if(isset($_POST['register'])){
          $name = $_POST['user_name'];
          $email = $_POST['user_email'];
          $password = $_POST['user_password'];
          $password2 = $_POST['user_password2'];
          $gender = $_POST['gender'];
          $dateOfBirth = $_POST['date'];
          if(empty($name) or empty($email) or empty($password) or empty($password2) or empty($gender) or empty($dateOfBirth)){
              echo "<script>alert('không được để trống','Thông báo từ hệ thống');</script>";
          }else{
            $timeOfDateOfBirth = strtotime($dateOfBirth);
            $currentTime = time();
            if($timeOfDateOfBirth > $currentTime){
              echo "<script>alert('Ngày sinh không hợp lệ','Thông báo từ hệ thống');</script>";
            }
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
              if (preg_match("/^[A-Za-z0-9_ ]{0,100}$/", $name)) {
                $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#$%^&*()_+{}:<>?]).{8,20}$/";
                if (preg_match($pattern, $password)) {
                  if($password == $password2){
                    if (isset($_FILES['image'])) {
    
                      $new_name = str_replace(" ", "_", $name.uniqid());
                      $_FILES['image']['name'] = $new_name.'.jpg';
                      $name_image = $_FILES['image']['name'];
                      $size = $_FILES['image']['size'];
                      $type = $_FILES['image']['type'];
    
                      $dir = 'User_Images';
                      if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                      }
    
                      $tmp_name = $_FILES['image']['tmp_name'];
                     // $new_name = uniqid() . '.' . pathinfo($name_image, PATHINFO_EXTENSION);  random tên ảnh
                      $file_path = $dir . '/' . $name_image;
                      move_uploaded_file($tmp_name, $file_path);
                      $image_name = $_FILES['image']['name'];
                      $op = ['cost' => 12,];
                      $hashPass = password_hash($password,PASSWORD_DEFAULT,$op);
                      $sql = "SELECT *
                      FROM khach_hang
                      WHERE email = '$email';";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        echo "<script>alert('Email đã được sử dụng. Vui lòng nhập lại email khác.');</script>";
                      } else {
                        $sql = "INSERT INTO khach_hang (ten_khach_hang, email, password, gioi_tinh, ngay_sinh, anh_dai_dien) VALUES ('$name', '$email', '$hashPass', '$gender','$dateOfBirth', '$image_name')";
                        $result = mysqli_query($conn, $sql);
                        if($result){
                        echo "<script>alert('Thêm Người dùng thành công','Thông báo từ hệ thống');</script>";
                        } else {
                        $thongbao = "Thêm thất bại";
                        }
                        $conn->close();
                      }
                      
                    } else{
                      $thongbao = "lỗi không tìm thấy ảnh";
                    }
                    
                  }
                  else{
                    echo "<script>alert('Mật khẩu và nhập lại mật khẩu không khớp nhau','Thông báo từ hệ thống');</script>";
                  }
                } else {
                  echo "<script>alert('Mật khẩu dài từ 8-20 ký tự, có chữ cái in hoa, chữ cái in thường, ký tự đặc biệt và số','Thông báo từ hệ thống');</script>";
                }
                
              } else {
                echo "<script>alert('Tên không được chứa các ký tự đặt biệt','Thông báo từ hệ thống');</script>";
              }
              
            }
            else{
              echo "<script>alert('email không hợp lệ','Thông báo từ hệ thống');</script>";
            }
          }
          
        }
        if(isset($_POST['login'])){
          header("Location: Login.php");
        }
    ?>
        <div class="row">
        <div class="col-md-12">
        <form action="#" method="post" enctype="multipart/form-data">
        <h1> Đăng ký tài khoản </h1>
        <fieldset>
          <legend>Điền thông tin cơ bản</legend>
          <div class="inputGroup inputGroup1">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="user_name">
            <p class="helper helper1">Tên người dùng</p>
          </div>
          <div class="inputGroup inputGroup2">
            <label for="email">Email:</label>
            <input type="email" id="email" name="user_email">
            <p class="helper helper2">email@gmail.com</p>
          </div>
          <div class="inputGroup inputGroup3">
          <label for="password">Mật khẩu:</label>
          <input type="password" id="password" name="user_password"><br><br>
          <label for="password">Nhập lại mật khẩu:</label>
          <input type="password" id="password2" name="user_password2">
          </div>
          <div class="inputGroup inputGroup4">
          <label>Giới tính:</label>
          <input type="radio" name="gender" value="1"> Nam<br>
          <input type="radio" name="gender" value="0"> Nữ
          </div>
          <div class="inputGroup inputGroup5">
          <label for="date">Ngày sinh:</label>
          <input type="date" id="date" name="date">
          </div><br><br>
          <label for="date">Chọn ảnh đại diện của bạn</label>
           <input type="file" name="image" accept="image/png, image/gif, image/jpeg"/>
        </fieldset>
        <button type="submit" name="register">Đăng ký</button>
        <button type="submit" name="login">Đăng Nhập</button>
        <br>
        <?php if(isset($thongbao)){ echo $thongbao;} ?>
        </form>
        </div>
      </div>
      <script  src="js/register.js"></script>
      <?php 
        require("footer.html");
      ?>
    </body>
</html>
