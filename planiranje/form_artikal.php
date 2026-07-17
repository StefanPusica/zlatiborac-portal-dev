
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $naslovForme; ?></h4>
        </div>
        <div class="modal-body">

            <div id="frmAlert" class="alert alert-danger" style="display: none;"></div>

            <form class="form-horizontal" role="form" name="frm" id="frm">
                <input type="hidden" name="row" value="<?= $rowId; ?>" />
                <input type="hidden" name="plan" value="<?= $plan; ?>" />

                <div class="form-group">
                    <label for="artikal" class="col-sm-3 control-label">Artikal</label>
                    <div class="col-sm-4">
                        <input type="text" name="artikal" class="form-control input-sm" id="artikal" placeholder="Artikal" value="<?= $artikal; ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="kolicina" class="col-sm-3 control-label">Količina</label>
                    <div class="col-sm-4">
                        <input type="text" name="kolicina" class="form-control input-sm" id="kolicina" placeholder="Planirana količina" value="<?= $kolicina; ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="recept" class="col-sm-3 control-label">Recept</label>
                    <div class="col-sm-8">
                        <select id="recept" name="recept" class="form-control input-sm" >
                            <option value='0'>Unesite šifru artikla</option>
                        </select>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="close">Zatvori</button>
            <button type="button" class="btn btn-success btn-sm" id="save">Snimi</button>
            <img id="loader" style="display: none" width="16" src="<?= $img_url ?>/loader.gif" />
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    $(function () {

        $("#artikal").focus();
        setTimeout(function () {
            $("#artikal").select().focus()
        }, 400);

        $("#artikal").change(function () {

            $.post("<?= $proplaniranje_url . "/xRecept"; ?>", {artikal: $(this).val()}, function (data) {

                var _rcpt = $("#recept");
                _rcpt.empty();

                var arr = $.parseJSON(data);
                var count = 0;
                $.each(arr, function (i, o) {
                    count++;
                    var text = o.artikal_naziv.trim() + " v" + o.verzija + (o.podrazumevano == 1 ? " (podrazumevan)" : "");
                    var value = o.id;
                    _rcpt.append($('<option />').text(text).val(value));
                });

            });
        });


        $('#save').click(function () {
            $(this).hide();
            $('#close').hide();
            $("#loader").show();

            form2post("<?= $proplaniranje_url . "/save_artikal"; ?>", $('#frm').serialize(), function (status, data) {
                if (!status) {
                    $('#frmAlert').html(data).fadeIn(100);
                    $('#save').show();
                    $('#close').show();
                    $("#loader").hide();
                    return;
                }
                loadPlan()
                $("#close").click();
            });
        });

<?
if ($artikal > 0) {
    ?>
            $("#artikal").change();
    <?
}
?>
    });
</script>
