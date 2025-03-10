<?php
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
error_reporting(0);
session_start();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>IAdmin V.3 - Setup</title>
        <link rel="icon" type="image/gif" href="favicon.gif"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <style>
            .card-body {
                display: none;
            }
        </style>
    </head>
    <body>
        <br/><br/>
        <div class="container">
            <div class="row">
                <div class="d-none d-sm-block col-sm">&nbsp;</div>
                <div class="col-sm-10 col-md-8 col-lg-6">
                    <?php if (!isset($_POST['s'])) { ?>
                        <form class="needs-validation" action="" method="post">
                            <div class="card">
                                <div class="card-header"><img src="favicon.gif" height="32" alt="i" style="float:left;"/><span
                                        style="color:#007bff; font-weight: bold">admin</span> - Setup
                                </div>
                                <div class="card-body" id="card1">
                                    <label for="progName">Application name</label>
                                    <input name="s[APP_NAME]" type="text" class="form-control" id="progName"
                                           placeholder="Ex. IAdmin example progam" value=""/>
                                    <hr/>
                                    <label for="tmpName">Template</label>
                                    <select name="s[APP_TEMPLATE]" class="form-control" id="tmpName">
                                        <?php
                                        $fileList = scandir('../template');
                                        foreach ($fileList as $fileName) {
                                            if (strpos($fileName, '.') === false) {
                                                echo '<option value="' . $fileName . '">' . $fileName . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <hr/>
                                    <label for="lngName">Language</label>
                                    <select name="s[APP_LANGUAGE]" class="form-control" id="lngName">
                                        <?php
                                        $fileList = scandir('../lang');
                                        foreach ($fileList as $fileName) {
                                            if (strpos($fileName, '.lng.') !== false) {
                                                $langName = str_replace('.lng.php', '', $fileName);
                                                echo '<option value="' . $langName . '">' . ucfirst($langName) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <a href="#" class="btn btn-primary my-2 float-right"
                                       onclick="$('#card1').slideUp();$('#card2').slideDown()">Next &raquo;</a>
                                </div>

                                <div class="card-body" id="card2">
                                    <label for="dbType">Database type</label>
                                    <select name="s[APP_DB_TYPE]" class="form-control" id="dbType">
                                        <?php
                                        $fileList = scandir('../connector');
                                        foreach ($fileList as $fileName) {
                                            if (strpos($fileName, '.con.php') !== false) {
                                                echo '<option value="' . str_replace('.con.php', '', $fileName) . '">' . str_replace('.con.php', '', $fileName) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <hr/>
                                    <label for="dbServer">Database server</label>
                                    <input name="s[APP_DB_SERVER]" type="text" class="form-control" id="dbName"
                                           value="localhost"/>
                                    <hr/>
                                    <label for="dbName">Database name (must exist)</label>
                                    <input name="s[APP_DB_NAME]" type="text" class="form-control" id="dbName"
                                           placeholder="Ex. iadmin_db" value=""/>
                                    <hr/>
                                    <label for="dbUser">Database user</label>
                                    <input name="s[APP_DB_USER]" type="text" class="form-control" id="dbUser"
                                           placeholder="Ex. root" value=""/>
                                    <hr/>
                                    <label for="dbPass">Database password</label>
                                    <input name="s[APP_DB_PASS]" type="text" class="form-control" id="dbPass" placeholder=""
                                           value=""/>
                                    <hr/>
                                    <label for="dbPass">Database port</label>
                                    <input name="s[APP_DB_PORT]" type="text" class="form-control" id="dbPass" placeholder=""
                                           value="3306"/>
                                    <a href="#" class="btn btn-primary my-2 float-left"
                                       onclick="$('#card1').slideDown();$('#card2').slideUp()">&laquo; Prev</a>
                                    <a href="#" class="btn btn-primary my-2 float-right"
                                       onclick="$('#card2').slideUp();$('#card3').slideDown()">Next &raquo;</a>
                                </div>
                                <div class="card-body" id="card3">
                                    <label for="iUser">Application admin user</label>
                                    <input name="iUser" type="text" class="form-control" id="iUser" placeholder="" value=""/>
                                    <hr/>
                                    <label for="iPass">User password</label>
                                    <input name="iPass" type="password" class="form-control" id="iPass" placeholder="" value=""/>
                                    <a href="#" class="btn btn-primary my-2 float-left"
                                       onclick="$('#card2').slideDown();$('#card3').slideUp()">&laquo; Prev</a>
                                    <button class="btn btn-primary my-2 float-right" type="submit">SET</button>
                                </div>
                            </div>
                        </form>
<?php
} else {
    $txt = '<?php' . "\r\n";
    foreach ($_POST['s'] as $k => $v) {
        $txt .= '    $' . $k . '="' . $v . '";' . "\r\n";
        $$k = $v;
    }
    $txt .= '?>';
    $fileOK = file_put_contents('../settings.ini', $txt);
    include('../connector/' . $APP_DB_TYPE . '.con.php');
    $dbOK = db_connect();
    if ($dbOK) {
        $dbOK = db_initialize();
    }
    if ($fileOK && $dbOK) {
        ?>
                            <div class="card">
                                <div class="card-header">IAdmin 3 - <?= $APP_NAME ?></div>
                                <div class="card-body" id="card1">
                                    <div class="alert alert-success" role="alert">
                                        Setup completed ! Log in as user previously set !
                                    </div>
                                    <a href="../" class="btn btn-primary my-2 float-right">OK</a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-header">IAdmin 3 - <?= $APP_NAME ?></div>
                                <div class="card-body" id="card1">
                                    <div class="alert alert-danger" role="alert">
                                        Error: <?= $MESSAGE ?> !
                                    </div>
                                    <a href="./" class="btn btn-primary my-2 float-right">RETRY</a>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                </div>
                <div class="d-none d-sm-block col-sm">&nbsp;</div>
            </div>
        </div>
        <script>
            $('#card1').slideDown();
        </script>
    </body>
</html>
