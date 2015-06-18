<?php
function successMessage($text) {
    ?>
        <br>
        <div class="col-md-3"></div>
        <div class="col-md-6 alert alert-success" role="alert">
            <?=$text?>
        </div>
        <div class="col-md-3"></div>
    <?php
}

function warningMessage($text) {
    ?>
    <br>
    <div class="col-md-3"></div>
    <div class="col-md-6 alert alert-warning" role="alert">
        <?=$text?>
    </div>
    <div class="col-md-3"></div>
<?php
}