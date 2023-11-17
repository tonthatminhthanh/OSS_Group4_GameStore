<?php
    
 session_start();
    $hostname = "localhost";
    $uname = "root";
    $passwd = "";
    $db_name = "Gamers_Alliance";

    $conn = new mysqli($hostname, $uname, $passwd, $db_name);
//    sữ lý thông tin cung cấp lấy dữ liệu từ database
    if($conn)
    {
        function get_item_info($conn, $item_id)
        {
            $info = array();
            $query = "SELECT * FROM mat_hang WHERE mat_hang_id = $item_id";
            $result_mh = $conn->query($query);
            $row_mh = $result_mh->fetch_row();
            $info["ten_mat_hang"] = $row_mh[1];
            $info["don_gia"] = $row_mh[2];
            $info["mo_ta"] = $row_mh[4];
            $info["anh"] = $row_mh[5];
            
            return $info;
        }

        if(isset($_GET["delete"]) && is_numeric($_GET["delete"]))
        {
            $index = $_GET["delete"];
            unset($_SESSION["cart"][$index]);
            header("Location: cart.php");
        }
    }
?>
<html>
    <head>
        <title>My cart</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                background: linear-gradient(#0c0a0a 25%, #e72c2c 100%) !important;
                color: white !important
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div style="margin-top: 10px;margin-bottom: 10px;">
        <div style="width: 75%;margin: auto;">
            <h1>GIỎ BÁN HÀNG CỦA BẠN</h1>
                <?php
                    $tong_tien = 0;
                    foreach($_SESSION["cart"]  as $i => $phantu)
                    { 
                        $info = get_item_info($conn,$phantu);
                        $img = $info["anh"];
                        $ten_mh = $info["ten_mat_hang"];
                        $mo_ta = $info["mo_ta"];
                        $don_gia = $info["don_gia"];
                        $tong_tien += $don_gia;
                        echo 
                        "
                            <div style='width: 50%;height:auto;min-height: 50px;margin: auto;box-shadow: 2px 1px 2px 1px;'>
                                <div style='width: 100%'>
                                    <table>
                                        <tr>
                                            <td>
                                                <img style='max-width: 100px;max-height: 100px' src='game_img/$img'>
                                            </td>
                                            <td>
                                                <h3>$ten_mh</h3>
                                                <div style='width: 95%;max-height: 100px;overflow-y:scroll;margin: auto;border-style: dashed;border-color: gray;border-width: 1px'>
                                                    $mo_ta
                                                </div>
                                                <div style='float:right;padding: 5px;'>
                                                    Đơn giá: $don_gia đ <a class='btn btn-danger' href='?delete=$i'>Xóa khỏi giỏ</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        ";
                    }
                    if(count($_SESSION["cart"]) == 0)
                    {
                        echo "Không có gì trong giỏ!";
                    }
                ?>
                <div style="float:right;position: relative;padding: 5px;font-size: 16px;">
                    Tổng tiền: <?php echo $tong_tien; ?>đ <input type="submit" name="submit" class="btn btn-success" style="font-size: 16px; !important" value="Thanh toán">
                </div>
            </div>
        </div>
        </div>
     <a href="Catalog.php">Quay lại</a> 
    </body>
</html>