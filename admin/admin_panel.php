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
?>
<html>
    <style>
        #navbar
        {
            display: block;
            width: 100%;
            margin: 0;
            background-color: #33ccff;
            color: white
        }

        #navbar ul
        {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        #navbar li
        {
            display: inline-block;
            margin-left: 20px;
            color: white;
        }

        .logout
        {
            float: right; 
        }

        .link {
            background: none!important;
            border: none;
            padding: 0!important;
            color: #069;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <header>
        <div id="navbar">
            <h3>Admin Panel</h3>
            <ul>
                <li><a href="games.php">Quản lý game</a></li>
                <li><a href="#">Quản lý dev team</a></li>
                <li><a href="#">Quản lý thể loại</a></li>
                <li><a href="#">Quản lý khiếu nại</a></li>
                <li class="logout">Tài khoản: <?php echo $_SESSION["admin_name"]; ?></li>
                <li class="logout"><form method="post"><input type="submit" class="link" value="Log out" name="log_out"></form></li>
            </ul>
        </div>
    </header>
</html>