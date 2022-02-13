<div class="content-header">
    <div class="content-fluid">
        <div class="col-sm-6">
            <h1 class="m-0">Tokens</h1>
        </div>
    </div>
</div>
<div class="content">
    <ul>
        <li>DEVELOPER TOKEN: <code><?php echo $_ENV['DEVELOPER_TOKEN'] ?></code></li>
        <li>GRANT ACCESS TOKEN: <code><?php echo $_SESSION['grantAccessToken'] ?></code></li>
        <li>ACCOUNT TOKEN: <code><?php echo $_SESSION['accountToken'] ?></code></li>
    </ul>
</div>