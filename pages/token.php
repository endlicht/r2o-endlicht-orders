<div>
    <ul>
        <li>DEVELOPER TOKEN: <code><?=
                get_env('DEVELOPER_TOKEN') ?></code></li>
        <li>GRANT ACCESS TOKEN: <code><?=
                $_SESSION['grantAccessToken'] ?></code></li>
        <li>ACCOUNT TOKEN: <code><?=
                $_SESSION['accountToken'] ?></code></li>
    </ul>
</div>