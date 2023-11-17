<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Gamer Alliance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        header {
            background-color: #ff3333;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        #navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ff3333;
            color: white;
            margin-bottom: 10px; /* Thêm margin-bottom để giảm kẻ hở bên dưới */
        }

        #navbar h3 {
            margin: 0;
        }

        #navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
            margin-right: 20px; /* Thay đổi margin-right để giảm kẻ hở bên phải */
        }

        #navbar li {
            margin-right: 20px;
        }

        .logout {
            margin-left: auto;
        }

        .link {
            background: none!important;
            border: none;
            padding: 0!important;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h3>Admin Panel</h3>
    </header>
    <div id="navbar">
        <ul>
            <li><a href="games.php" class="link">Quản lý game</a></li>
            <li><a href="#" class="link">Quản lý dev team</a></li>
            <li><a href="#" class="link">Quản lý thể loại</a></li>
            <li><a href="#" class="link">Quản lý khiếu nại</a></li>
        </ul>
        <div class="logout">
            <span style="color: #fff;">Tài khoản: <?php echo $_SESSION["admin_name"]; ?></span>
            <form method="post"><input type="submit" class="link" value="Log out" name="log_out"></form>
        </div>
    </div>
</body>
</html>
