<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $naslovForme; ?></h4>
        </div>
        <div class="modal-body">

            <div id="frmAlert" class="alert alert-danger" style="display: none;"></div>

            <blockquote>
                <p></p>
                <p>Generisanje PoluProizvoda na osnovu receptura planiranih artikala</p>
            </blockquote>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="close">Zatvori</button>
            <button type="button" class="btn btn-success btn-sm" id="save" style=""><span class="glyphicon icon-cogs"></span> Generiši</button>
            <img id="loader" style="display: none" width="16" src="<?= $img_url ?>/loader.gif" />
        </div>
    </div>
</div>
<script>
    $(function () {

        $('#save').click(function () {

            $("#loader").show();
            $('#close').hide();
            $('#save').hide();


            form2post("<?= $proplaniranje_url; ?>/pp_generisi", {plan: <?= $plan; ?>}, function (status, data) {
                if (!status) {
                    $("#loader").hide();
                    $('#close').show();
                    $('#save').show();
                    $('#frmAlert').html(data).fadeIn(100);
                    return;
                }
                loadPlan();
                $("#close").click();
            });
        });
    });
</script>