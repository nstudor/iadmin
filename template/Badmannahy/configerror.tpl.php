<div role="main" class="container theme-showcase" style="margin-top:100px;">
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle float-start" style="font-size: 3rem; padding: 15px;"></i>
        <h3>Configuration error !</h3>
        <h5>Module <tt><?= htmlspecialchars($pag) ?></tt> is not configured correctly:</h5>
        <ul class="mb-0">
            <?php foreach ($configErrors ?? [] as $err) { ?>
                <li><?= $err ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
