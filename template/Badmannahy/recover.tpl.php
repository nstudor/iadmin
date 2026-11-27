<form class="form-signin text-center" method="post" action="">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h1 class="h3 mb-3 fw-normal"><?= t('sign_in_recover') ?></h1>
            <label for="log_user" class="visually-hidden"><?= t('email') ?></label>
            <input type="text" id="log_user" name="email" class="form-control" placeholder="email@domain.tld" required
                autofocus>
            <button class="btn btn-primary m-3 float-end" type="submit"><?= t('recover') ?></button>
        </div>
    </div>
</form>