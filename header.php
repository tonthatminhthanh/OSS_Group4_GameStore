    <?php
        session_start();
        if(isset($_POST["log_out"]))
        {
            unset($_SESSION["logged_in"]);
            unset($_SESSION["logged_in_name"]);
            unset($_SESSION["logged_in_mail"]);
            unset($_SESSION["curr_pfp"]);
            unset($_SESSION["logged_in_mail"]);
        }

        if(isset($_SESSION["logged_in"]))
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "Gamers_Alliance";
            $conn = new mysqli($servername, $username, $password, $database);
            $sql = "SELECT so_du FROM khach_hang WHERE khach_hang_id='{$_SESSION["logged_in"]}'";
            $result = $conn->query($sql);
            if($result)
            {
                $row = $result->fetch_assoc();
                $so_du = $row["so_du"];
            }
            else
            {
                $so_du = "Undefined error";
                goto End_Money_Query;
            }
            $conn->query($sql);
            End_Money_Query:
            $conn->close();         
        }

        if(isset($_POST["send_mail"]))
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "Gamers_Alliance";
            $conn = new mysqli($servername, $username, $password, $database);
            $txt = $_POST["txt"];
            $sql = "INSERT INTO khieu_nai(khach_hang_id) VALUES('{$_SESSION["logged_in"]}')";
            $conn->query($sql);
            $sql = "SELECT khieu_nai_id FROM khieu_nai WHERE khach_hang_id='{$_SESSION["logged_in"]}'";
            $result = $conn->query($sql);
            if($result)
            {
                $row = $result->fetch_assoc();
                $kn_id = $row["khieu_nai_id"];
            }
            else
            {
                goto End;
            }
            $sql = "INSERT INTO ctkn(khieu_nai_id,mo_ta) VALUES('$kn_id','$txt')";
            $conn->query($sql);
            End:
            $conn->close();
        }
    ?>
    <header>
        <div id="header">
            <style>
                .link {
                    background: none!important;
                    border: none;
                    padding: 0!important;
                    color: #069;
                    text-decoration: underline;
                    cursor: pointer;
                }
            </style>
            <a  href="index.php"><img  src="https://i.ibb.co/pLWXZv4/logodoan.jpg" alt="logodoan" border="0" /></a>
            <p>GAMERS ALLIANCE</p>
            

            <div id="navbar">
                <ul>
                    <li><a href="#"><input type="text" id="search" style="width: 300px; height: 35px; border: none; border-radius: 5px; " placeholder="Search..." value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>"></a></li>
                    <li>  <a href="index.php"> <i class="fa-solid fa-house"></i> Home</a></li>
                    <li><a href="Catalog.php"><i class="fa-solid fa-gamepad"></i> Games</a></li>
                    <li><a href="DS.html"> <i class="fa-solid fa-users"></i> About me</a></li>
                    <li><a href="cart.php"> <i class="fa-solid fa-shopping-cart"></i></a></li>
                    <?php
                        if(!isset($_SESSION["logged_in"]))
                        {
                            echo "<li><a href='Login.php'><i class='fa-solid fa-right-to-bracket'></i> Login</a> </li>";
                        }
                        else
                        {
                            $name = $_SESSION["logged_in_name"];
                            $pfp = $_SESSION["curr_pfp"];
                            echo "<li><img style='border-radius: 100%' width='50px' height='50px' src='User_Images/$pfp'>";
                            echo "<a href='ThongtinCaNhan.php'> $name</a></li>";
                            echo "<li>Số dư: $so_du VNĐ</li>";
                            echo '<li><form method="post"><input type="submit" class="link" value="Log out" name="log_out"></form></li>';
                        }
                    ?>
                   <li><a href="practice"><i class="fa-brands fa-buromobelexperte"></i> Exercise</a></li>

                   <script>
                        var inputNode = document.getElementById("search");
                        inputNode.addEventListener("keyup", function (event)
                        {
                            if(event.key === "Enter") {
                                if(inputNode.value == null || inputNode.value == "")
                                {
                                    window.location.assign("Catalog.php?#");
                                }
                                window.location.assign("Catalog.php?search=" + inputNode.value);
                            }
                        }
                    );
            </script>
                </ul>
            </div>
        </div>
        <div id="mail_modal" style="position: fixed; bottom: 15px; right: 5px; width: 250px; height: 400px;display: none; background-color: #7eed9b">
            <form method="post">
                <h4>Khiếu nại</h4>
                <h5>Nội dung:</h5><br>
                <textarea name="txt" style="width: 250px; height: 250px;text-align:left; resize: none" required></textarea><br>
                <input type="submit" name="send_mail" value="Gửi">
                <input type="button" onclick="close_modal()" value="Đóng">
            </form>
        </div>  
        <?php if(isset($_SESSION["logged_in"]))
        {
            echo "<div id='mail_button' style='display: flex; position: fixed; border-radius: 100%; background-color: azure; bottom: 15px; right: 5px; width: 70px; height: 70px; justify-content: center; align-items: center;'>
            <a href='javascript:display_modal()' style='font-size: 50px; margin: auto 0'><i class='fa-solid fa-envelope'></i></a>
            </div>";
        }?>
        <script>
            function display_modal()
            {
                document.getElementById("mail_button").style.display = "none";
                document.getElementById("mail_modal").style.display = "block";
            }

            function close_modal()
            {
                document.getElementById("mail_button").style.display = "flex";
                document.getElementById("mail_modal").style.display = "none";
            }
        </script>
    </header>
