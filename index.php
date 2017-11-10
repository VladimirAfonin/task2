<?php
session_start();
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Url short</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h2 class="title">Короткий Url</h2>

            <div class="authform">
                <form action="short.php" method="post">
                    <input type="url" name="url" placeholder="Введите Url..." autocomplete="off">
                    <br><br>
                    <input type="text" name="shortUrl" placeholder="Введите сокращенный Url..." autocomplete="off" maxlength="12">
                    <input type="button" value="click" id="click">
                </form>
            </div>
        </div>

        <script
            src="http://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                crossorigin="anonymous"></script>
        <script src="test.js"></script>
    </body>
</html>