<form class="form-signin text-center" method="post" action="./">
<div class="card" style="width: 18rem;">
    <div class="card-body">      
        <img class="mb-4" src="./images/logo.jpg" width="100%">      
        <h1 class="h3 mb-3 font-weight-normal"><?= t('sign_in_title') ?></h1>
        <label for="log_user" class="sr-only"><?= t('sign_in_username') ?></label>
        <input type="text" id="log_user" name="log_user" class="form-control" placeholder="<?= t('sign_in_username') ?>" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only"><?= t('sign_in_password') ?></label>
        <input type="password" id="log_pass" name="log_pass" class="form-control" placeholder="<?= t('sign_in_password') ?>" required>
        <br>
<?php
    if($MESSAGE != '') echo showMessage($MESSAGE, 'danger');
?>        
    
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?= t('sign_in_button') ?></button>
<a href="./recover.htm"><?= t('sign_in_recover') ?></a>
    </div>
</div>
</form>
