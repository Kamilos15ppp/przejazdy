<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Przejazdy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="/public/style.css" rel="stylesheet">
</head>
<body>

<?php if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Przejazdy - <?php echo $_SESSION['username'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Strona główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/?action=create">Dodaj przejazd</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pojazdy
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/?action=listBus">Autobusy</a></li>
                            <li><a class="dropdown-item" href="/?action=listTram">Tramwaje</a></li>
                            <li><a class="dropdown-item" href="/?action=listRelic">Zabytki</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item disabled" href="/?action=listDepot">Zajezdnie</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/?action=search">Szukaj</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/?action=ranking">Ranking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/?action=statement">Zestawienie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/?action=logout">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<?php endif; ?>

<main>
    <?php if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <?php require_once("templates/pages/$page.php"); ?>
    <?php elseif (empty($_SESSION)): ?>
        <?php if (!empty($_GET) && $_GET['action'] === 'register'): ?>
            <?php require_once("templates/pages/register.php"); ?>
        <?php else: ?>
            <?php require_once("templates/pages/login.php"); ?>
        <?php endif; ?>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>