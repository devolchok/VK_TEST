<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Система заказов<?php if ($title) echo ' | '.$title ?></title>
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
<div id="page" class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Система заказов</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <?php if (isAuthorized()) : ?>
                    <li><a><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $user['login']; ?></a></li>
                    <li><a href="/auth/logout?logout_hash=<?php echo $user['logout_hash']; ?>">Выход</a></li>
                <?php else : ?>
                    <li><a href="/registration/">Регистрация</a></li>
                    <li><a href="/login/">Вход</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>

    <div class="container-fluid" id="page-content">
        <?php echo $content; ?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/scripts.js"></script>
</body>
</html>