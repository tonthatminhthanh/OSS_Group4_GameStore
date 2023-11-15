<?php 
    session_start();
?>
<html>
    <head>
        <title>File download test</title>
    </head>
    <body>
        test
        <form method="post" action="download_link.php">
            <input type="hidden" name="mat_hang_id" value="1">
            <input type="hidden" name="hash" value="1">
            <input type="submit" value="Download">
        </form>
    </body>
</html>