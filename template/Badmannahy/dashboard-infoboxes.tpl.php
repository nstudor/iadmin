<div class="row">
    <?php
    foreach ($panelData as $panel) {
    ?><div class="col">
            <div class="card card-stats mb-4 mb-xl-0 bg-<?= $panel['type'] ?>">
                <div class="card-body m-1 p-1">
                    <div class="row m-0">
                        <div class="col">
                            <span class="h2 font-weight-bold mb-0 <?= $panel['textValueClass'] ?>"><?= $panel['textValue'] ?></span>
                            <h5 class="card-title mb-0 <?= $panel['textLabelClass'] ?>"><?= $panel['textLabel'] ?></h5>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-shape">
                                <i class="<?= $panel['iconClass'] ?> fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-1 text-right">
                    <a class="mt-3 mb-0 text-<?= $panel['linkType'] ?> mr-2" href="<?= $panel['linkURL'] ?>">
                        <?= $panel['linkLabel'] ?> &raquo;
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>