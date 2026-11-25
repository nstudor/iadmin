<!DOCTYPE html>
<html lang="ro">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?php echo $APP_NAME ?></title>
  <link rel="icon" type="image/gif" href="favicon.gif" />
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/all.min.css" />
  <link rel="stylesheet" href="./css/v4-shims.min.css" />
  <link rel="stylesheet" href="./css/compat-bs4.css" />
  <link rel="stylesheet" href="./css/colors.css" />
  <link href="./css/bootstrap-colorpicker.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./template/Badmannahy/style.css" />
  <link rel="stylesheet" href="./css/BsMultiSelect.min.css" />
  <link rel="stylesheet" href="./css/tempus-dominus.css" />
  <meta name="csrf-token" content="<?= isset($_SESSION['userid']) ? csrf_token() : '' ?>" />
  <script src="./js/jquery.min.js"></script>
  <script src="./js/csrf.js"></script>
  <script src="./js/fieldtypes.js"></script>
  <script src="./js/compat-bs4.js"></script>
  <script src="./js/popper.min.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="./js/tempus-dominus.js"></script>
  <script src="./js/jQuery-provider.js"></script>
  <script src="./js/ckeditor/ckeditor.js"></script>
  <script src="./js/bootstrap-colorpicker.js"></script>
  <script src="./js/BsMultiSelect.min.js"></script>


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Truculenta:opsz,wght@12..72,100..900&display=swap" rel="stylesheet">
  <?php
  if (file_exists('template/' . $APP_TEMPLATE . '/' . $scriptPage . '.head.php')) {
    include('template/' . $APP_TEMPLATE . '/' . $scriptPage . '.head.php');
  }
  ?>
</head>

<body>

  <?php if (isset($_SESSION['userid'])) { ?>
    <nav class="navbar navbar-expand-sm navbar-light <?= $tmpBackground ?> fixed-top">
      <div class="container-fluid">
      <a class="navbar-brand <?= $tmpText ?>" href="./"><i class="fas fa-home"></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav">
          <?php
          $menu1 = $menu;
          $menu2 = $menu;
          $menu3 = $menu;
          foreach ($menu1 as $k1 => $m1)
            if ((($m1['link'] ?? '') == '') && (($m1['id_tata'] ?? 0) == 0) && (($m1['id'] ?? '') != '')) {
              $n = 0;
              foreach ($menu2 as $m2) if (($m2['id_tata'] ?? null) == $m1['id']) $n++;
              if ($n == 0) { ?>
              <li class="nav-item">
                <a class="nav-link <?= $tmpText ?>" href="<?= $m1['link'] ?>"><?= $m1['denum'] ?></a>
              </li>
            <?php } else { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= $tmpText ?>" href="#" id="dropdown<?= $k1 ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $m1['denum'] ?></a>
                <ul class="dropdown-menu <?= $tmpBackground ?>">
                  <?php foreach ($menu2 as $k2 => $m2) if (($m2['id_tata'] ?? null) == $m1['id'])
                    if ($m2['denum'] == '-') { ?>
                    <li class="dropdown-item dropdown-submenu m-0 p-0"><hr class="dropdown-divider"></li>
                  <?php } else 
    if ($m2['link'] != '') {    ?>
                    <li class="dropdown-item dropdown-submenu m-0 p-0"><a class="dropdown-item <?= $tmpText ?>" href="<?php echo $m2['link'] ?>.htm"><?php echo $m2['denum'] ?></a></li>
                    <?php } else {
                      $n = 0;
                      foreach ($menu3 as $m3) if (($m3['id_tata'] ?? null) == $m2['id']) $n++;
                      if ($n != 0) {
                    ?>
                      <li class="dropdown-item dropdown-submenu m-0 p-0">
                        <a href="#" class="dropdown-toggle dropdown-item <?= $tmpText ?>"><?php echo $m2['denum'] ?></a>
                        <ul class="dropdown-menu <?= $tmpBackground ?>">
                          <?php foreach ($menu3 as $k3 => $m3) if (($m3['id_tata'] ?? null) == $m2['id'])
                            if ($m3['denum'] == '-') { ?>
                            <li class="dropdown-item m-0 p-0"><hr class="dropdown-divider"></li>
                          <?php } else { ?>
                            <li class="dropdown-item m-0 p-0"><a class="dropdown-item <?= $tmpText ?>" href="<?php echo $m3['link'] ?>.htm"><?php echo $m3['denum'] ?></a></li>
                          <?php } ?>
                        </ul>
                      </li>
                  <?php }
                    } ?>
                </ul>
              </li>
          <?php }
            } ?>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item active">
            <a class="navbar-brand aqua" href="logout.htm"><i class="fas fa-power-off"></i></a>
          </li>
        </ul>
      </div>
      </div>
    </nav>
    <div class="row m-0">&nbsp;</div>
    <div class="row m-0">&nbsp;</div>
  <?php } ?>
  <?php
  if (file_exists('template/' . $APP_TEMPLATE . '/' . $scriptPage . '.tpl.php')) {
    include('template/' . $APP_TEMPLATE . '/' . $scriptPage . '.tpl.php');
  } else {
    if (file_exists($scriptPage)) {
      include($scriptPage);
    }
  }
  ?>
  <?php if (isset($_SESSION['userid'])) { ?>
    <br /><br />
    <nav class="navbar fixed-bottom navbar-expand-sm navbar-light <?= $tmpBackground ?>">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item dropup">
            <a class="nav-link dropdown-toggle <?= $tmpText ?>" href="#" id="dds1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
            <div class="dropdown-menu <?= $tmpBackground ?>" aria-labelledby="dds1">
              <a class="dropdown-item <?= $tmpText ?>" href="./utilizatori-key-id-<?= (int)$_SESSION['userid'] ?>.htm">Change password</a>
              <a class="dropdown-item <?= $tmpText ?>" href="#">Settings</a>
              <a class="dropdown-item <?= $tmpText ?>" href="./logout.htm">Logout</a>
            </div>
          </li>
          <?php if ($ruser['role'] == 1) { ?>
            <li class="nav-item dropup">
              <a class="nav-link dropdown-toggle <?= $tmpText ?>" href="#" id="dds2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Developer</a>
              <div class="dropdown-menu <?= $tmpBackground ?>" aria-labelledby="dds2">
                <a class="dropdown-item <?= $tmpText ?>" href="loginmenu.htm">Menu</a>
              </div>
            </li>
          <?php } ?>
        </ul>
        <ul class="navbar-nav my-2 my-md-0">
          <li class="nav-item <?= $tmpText ?>" id="clock">-</li>
        </ul>
      </div>
    </nav>
    <script>
      function clock() {
        $.ajax({
          url: "ajax/time.php",
        }).done(function(msg) {
          $("#clock").html(msg);
        });
      }
      clock();
      setInterval("clock()", 15000);
      $('.dropdown-submenu > a').on("click", function(e) {
        var submenu = $(this);
        $('.dropdown-submenu .dropdown-menu').removeClass('show');
        submenu.next('.dropdown-menu').addClass('show');
        e.stopPropagation();
      });
      $('.dropdown').on("hidden.bs.dropdown", function() {
        // hide any open menus when parent closes
        $('.dropdown-menu.show').removeClass('show');
      });
      $('.color-selector').colorpicker();
    </script>
  <?php } ?>
</body>

</html>