<?php
    include("header.php");
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
    <title>Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="css/footer.css">
        <link href="https://fonts.cdnfonts.com/css/dec-terminal-modern" rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main class="container" style="width: 55%;margin: 0 auto">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Gamers_Alliance";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if(isset($_GET["search"]))
        {
            $search = $_GET["search"];
        }
        else
        {
            $search = "";
        }

        // Lấy tổng số hàng trong bảng mat_hang
        $sql = "SELECT COUNT(*) AS total_rows FROM mat_hang WHERE ten_mat_hang LIKE '%$search%'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_rows = $row['total_rows'];

        // Lấy số trang
        $pages = $total_rows / 2;

        // Lấy trang hiện tại
        $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;

        // Lấy offset
        $offset = ($current_page - 1) * 2;

        // Lấy dữ liệu phân trang
        $sql = "SELECT mat_hang.mat_hang_id, mat_hang.mo_ta,mat_hang.ten_mat_hang, mat_hang.don_gia, the_loai.ten_the_loai, dev_team.dev_name, mat_hang.anh
        FROM mat_hang
        JOIN dev_team ON mat_hang.dev_team_id = dev_team.dev_id
        JOIN the_loai ON mat_hang.the_loai = the_loai.the_loai_id WHERE ten_mat_hang LIKE '%$search%' LIMIT $offset, 5";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div style='display: flex; width:800px; margin-bottom: 10px;'>";
                echo "<div style='width: 20%; margin-top: 20px;'>";
                echo "<img src='game_img/{$row['anh']}' width='100px'>";
                echo "</div>";
                echo "<div style='width: 80%;'>";
                echo "<div style='text-align: center;'>" . $row['ten_mat_hang'] . "</div><br>";
                echo substr($row['mo_ta'], 0, 100). "...";
                echo "</div>";
                echo "</div>";
                echo "<div style='display: flex;width:800px;'>";
                echo "<div style='width: 50%; margin-left: 160px; color: green;'>".$row['dev_name']."</div>";
                echo "<div style='width: 25%;text-align: right;margin-right: 10px; color: red;'>".$row['don_gia']."VNĐ"."</div>";
                echo "<div style='width: 25%;text-align: left;'>"."<a href='' style='color: green;'> Xem sản phẩm</a>"."</div>";
                echo "</div>";
                echo "<br>";
            }
        }
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $pages; $i++) {
            echo "<a href='?page=$i' class='page-item'>";
            echo "<span class='page-link'>$i</span>";
            echo "</a>";
        }
        echo "</div>";

        $conn->close();
    ?>
    </main>
    <div>
    <?php require("footer.php"); ?>
    </div>
</body>
</html>