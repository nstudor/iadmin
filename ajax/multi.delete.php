<div class="row">
    <div class="col">
        <H5>Sterge <?= count($ids) ?> randuri ?</H5>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <button class='btn btn-secondary col' type="button" onclick="postModal('multi-<?= $pp[1] ?>-dodelete-<?= $pp[3] ?>','...', $('#multiForm').serialize() )">
            <i class="fa fa-check text-white"></i>
        </button>
    </div>
    <div class="col-6">
        <button class='btn btn-danger col' type="button" onclick="document.location=document.location">
            <i class="fa fa-times text-white"></i>
        </button>
    </div>
</div>