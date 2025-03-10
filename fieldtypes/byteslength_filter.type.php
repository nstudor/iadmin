<input name="<?php echo $k ?>" type="hidden" class="form-control" value="" />
<input name="fv" type="hidden" class="form-control" value="" />
<div class="row">
    <div class="col-5">
        <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=3;document.ff.submit()"> <i class="fas fa-file"></i> Necompletat</button>
    </div>
    <div class="col-5">
        <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=4;document.ff.submit()"> <i class="fas fa-file-alt"></i> Completat</button>
    </div>
    <div class="col-2">
        <button class="btn btn-danger col mb-2" type="button" onclick="document.ff.fv.value=5;document.ff.submit()"> <i class="fas fa-times"></i></button>
    </div>
</div>