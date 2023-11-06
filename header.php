    <?php
        if(isset($_POST["log_out"]))
        {
            unset($_SESSION["logged_in"]);
            unset($_SESSION["logged_in_name"]);
            unset($_SESSION["curr_pfp"]);
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
            <a  href="#"><img  src="https://i.ibb.co/pLWXZv4/logodoan.jpg" alt="logodoan" border="0" /></a>
            <p>GAMERS ALLIANCE</p>
           

            <div id="navbar">
                <ul>
                    <li><a href="#"><input type="text" style="width: 300px; height: 35px; border: none; border-radius: 5px; " placeholder="Search..."></a></li>
                    <li>  <a href="index.php"> <i class="fa-solid fa-house"></i> Home</a></li>
                    <li><a href="#"><i class="fa-solid fa-circle-info"></i> Projects</a></li>
                    <li><a href="#"> <i class="fa-solid fa-users"></i> About me</a></li>
                    <?php
                        if(!isset($_SESSION["logged_in"]))
                        {
                            echo "<li><a href='Login.php'><i class='fa-solid fa-right-to-bracket'></i>Login</a> </li>";
                        }
                        else
                        {
                            $name = $_SESSION["logged_in_name"];
                            $pfp = $_SESSION["curr_pfp"];
                            echo "<li><img style='border-radius: 100%' width='50px' height='50px' src='User_Images/$pfp'>";
                            echo "<a href='ThongtinCaNhan.php'>$name</a></li>";
                            echo '<li><form method="post"><input type="submit" class="link" value="Log out" name="log_out"></form></li>';
                        }
                    ?>
                   <li><a href="#"><i class="fa-brands fa-buromobelexperte"></i> Excerise</a></li>
                </ul>
            </div>
        </div>
    </header>
