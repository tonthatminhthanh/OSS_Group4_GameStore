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
    if(isset($_GET["submit"]))
    {
        if(isset($_GET["search"]))
        {
            $search = $_GET["search"];
        }
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
    $num_entries = 2;
    // Lấy số trang
    $pages = $total_rows / $num_entries;

    // Lấy trang hiện tại
    $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;

    // Lấy offset
    $offset = ($current_page - 1) * 2;

    // Lấy dữ liệu phân trang
    $sql = "SELECT mat_hang.mat_hang_id, mat_hang.mo_ta,mat_hang.ten_mat_hang, mat_hang.don_gia, the_loai.ten_the_loai, dev_team.dev_name, mat_hang.anh
    FROM mat_hang
    JOIN dev_team ON mat_hang.dev_team_id = dev_team.dev_id
    JOIN the_loai ON mat_hang.the_loai = the_loai.the_loai_id WHERE ten_mat_hang LIKE '%$search%' LIMIT $offset, $num_entries";
    $result = $conn->query($sql);

    if(isset($_POST['confirm_delete'])) {
        $itemId = $_POST["delete_id"];

        // Thực hiện hành động xóa thông qua PHP
        $sql = "DELETE FROM mat_hang WHERE mat_hang_id = $itemId";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: games.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://fonts.cdnfonts.com/css/dec-terminal-modern" rel="stylesheet">
        <link rel="stylesheet" href="..//css/games.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            table, th, td {
                border: 1px solid;
            }
        </style>
    </head>
    <body>
        <?php require("admin_panel.php"); ?>
        <button onclick="window.location.href='addgame.php'" id="add">Thêm game</button>
        <button onclick="window.location.href='adddev.php'" id="add">Thêm Dev</button>
        <button onclick="window.location.href='addtheloai.php'" id="add">Thêm thể loại</button>
        <form method="get" id="search">
            <input type="text" name="search" value="<?php if(isset($_GET["search"])) {echo $_GET["search"];} ?>">
            <input type="submit" name="submit" value="Tìm kiếm">
        </form>
        <table >
            <tr>
                <th>ID</th>
                <th>Tên mặt hàng</th>
                <th>Đơn giá</th>
                <th>Thể loại</th>
                <th>Mô tả</th>
                <th>Ảnh</th>
                <th>Dev</th>
                <th colspan="2">Action</th>
            </tr>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $substr = substr($row['mo_ta'], 0, 100). "...";
                        echo "<tr>";
                        echo "<td>{$row["mat_hang_id"]}</td>";
                        echo "<td>{$row["ten_mat_hang"]}</td>";
                        echo "<td>{$row["don_gia"]}</td>";
                        echo "<td>{$row["ten_the_loai"]}</td>";
                        echo "<td>{$substr}</td>";
                        echo "<td><img src='../game_img/{$row["anh"]}' width=50px height=50px></td>";
                        echo "<td>{$row["dev_name"]}</td>";
                        echo "<td><button style='border: none; background-color: transparent; cursor: pointer;' onclick='location.href=\"editgame.php?id={$row["mat_hang_id"]}\"'>Sửa</button></td>";
                        echo "<td>
                        <form method='post' onsubmit='return confirm(\"Bạn xác nhận muốn xóa?\")'>
                        <input type='hidden' name='delete_id' value='{$row["mat_hang_id"]}'>
                        <button type='submit' name='confirm_delete' style='border: none; background-color: transparent; cursor: pointer; padding-top: 44%;'>Xóa</button>
                    </form>
                          </td>";
                        echo "</tr>";
                    }
                }

                echo "<div class='pagination'>";
                for ($i = 1; $i <= $pages; $i++) {
                    echo "<a href='?page=$i' class='page-item'>";
                    echo "<span class='page-link'>$i</span>";
                    echo "</a>";
                }
                echo "</div>";
            ?>
        </table>
    </body>
</html>