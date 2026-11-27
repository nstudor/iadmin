<form method="post" action="">
    <h1 class="h4 mb-2 text-center"><?= t('sign_in_recover') ?></h1>
    <p class="text-body-secondary text-center small mb-4"><?= t('recover_text') ?></p>
    <div class="form-floating mb-3">
        <input type="email" id="recover_email" name="email" class="form-control" placeholder="email@domain.tld" required autofocus>
        <label for="recover_email"><?= t('email') ?></label>
    </div>
    <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-paper-plane me-1"></i> <?= t('recover') ?></button>
    <div class="text-center mt-3"><a href="./" class="small"><?= t('back_to_sign_in') ?></a></div>
</form>
