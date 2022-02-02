<?php

require __DIR__ . '/vendor/autoload.php';

include("scripts/auth.php");
include("scripts/helpers.php");

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

session_start();

$URL = $_SERVER['REQUEST_URI'];
$SERVER_ADDRESS = "http://{$_SERVER['HTTP_HOST']}";

$PARSED_URL = parse_url($URL, PHP_URL_PATH);

$TITLE = "Endlicht Bestellungen";

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="default-src 'none'; base-uri 'none'; child-src 'self'; form-action 'self'; frame-src 'self'; font-src 'self'; connect-src 'self'; img-src 'self'; manifest-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'"
          http-equiv="Content-Security-Policy">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <style>
        body {
            text-align: left;
        }

        nav {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: large;
        }

        thead {
            background-color: #a0aaaa;
        }

        tr, td {
            border: thin solid black;
        }

        .product-name {
            font-weight: bold;
        }

        .button {
            background-color: #a0aaaa;
            border: thin solid black;
            color: black;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: larger;
            font-weight: bold;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1><?php echo $TITLE; ?></h1>
<nav class="navigation">
    <a href="<?php echo $SERVER_ADDRESS; ?>" class="button">Aktualisieren</a>
    <!-- <a href="<?php echo $SERVER_ADDRESS . '/token'; ?>">Token</a> -->
</nav>

<?php

if ($PARSED_URL === '/auth' || ($PARSED_URL !== '/granted' && /* check if tokens are set */
        (!isset($_SESSION['grantAccessToken'], $_SESSION['accountToken'])))) {
    $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], $SERVER_ADDRESS . '/granted');
    $_SESSION['grantAccessToken'] = $grantAccessResponse['grantAccessToken'];

    /* Redirect to ready2order authorization page */
    header('Location: ' . $grantAccessResponse['grantAccessUri'], true, 301);
} else if ($PARSED_URL === '/token') {
    ?>
    <ul>
        <li>DEVELOPER TOKEN: <code><?php echo $_ENV['DEVELOPER_TOKEN'] ?></code></li>
        <li>GRANT ACCESS TOKEN: <code><?php echo $_SESSION['grantAccessToken'] ?></code></li>
        <li>ACCOUNT TOKEN: <code><?php echo $_SESSION['accountToken'] ?></code></li>
    </ul>
    <?php
} else if ($PARSED_URL === '/granted') {
    /* Get status and grantAccessToken from ready2order */
    $status = get_value('status');
    $grantAccessToken = get_value('grantAccessToken');
    if ($status !== 'approved' /* check status */ || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
        echo 'FEHLER! Nicht autorisiert!';
        exit;
    }

    /* Get accountToken from ready2order and save as session token */
    $accountToken = get_value('accountToken');
    $_SESSION['accountToken'] = $accountToken;

    /* Redirect to index.php */
    header('Location: ' . $SERVER_ADDRESS, true, 301);
} else {
    include("template/orders.php");
}
?>
</body>
</html>
