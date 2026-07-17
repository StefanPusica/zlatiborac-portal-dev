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
                <p>Brisanje označenih artikala: <b id="infoBrojOznacenihZaBrisanje"></b></p>
            </blockquote>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="close">Zatvori</button>
            <button type="button" class="btn btn-danger btn-sm" id="save" style=""><span class="glyphicon glyphicon-remove-circle"></span> Da</button>
            <img id="loader" style="display: none" width="16" src="<?= $img_url ?>/loader.gif" />
        </div>
    </div>
</div>
<script>
    $(function () {

        var artikli = [];
        $('.chArtList:checked', $(".planItemHolder")).each(function () {
            artikli.push($(this).data('row'));
        });

        if (artikli.length == 0)
            $("#save").hide();
        else
            $("#save").show();

        $("#infoBrojOznacenihZaBrisanje").html(artikli.length)

        $('#save').click(function () {

            $("#loader").show();
            $('#close').hide();
            $('#save').hide();


            var arr = artikli.join(",");

            form2post("<?= $proplaniranje_url; ?>/delete_artikli", {plan: <?= $plan; ?>, artikli: arr}, function (status, data) {
                if (!status) {
                    $("#loader").hide();
                    $('#close').show();
                    $('#save').show();
                    $('#frmAlert').html(data).fadeIn(100);
                    return;
                }
                loadPlan();
                loadProizvod();
                loadSirovine();
                $("#close").click();
            });
        });
    });
</script>