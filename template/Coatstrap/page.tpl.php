<?php
// public / static pages from login__pages (login, recover, ...)
$pTitle = trim(strip_tags(html_entity_decode((string)($page['title'] ?? ''))));
?>
<?php if ($pTitle !== '') { ?><h1 class="h3 mb-3"><?= $page['title'] ?></h1><?php } ?>
<div><?= $page['content'] ?? '' ?></div>
