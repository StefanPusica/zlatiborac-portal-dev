
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
                <input type="hidden" name="nalog" value="<?= $nalog; ?>" />


                <div class="form-group">
                    <label for="artikal" class="col-sm-3 control-label">Artikal</label>
                    <div class="col-sm-3">
                        <input type="text" name="artikal" class="form-control input-sm" id="artikal" placeholder="Šifra artikla" value="<?= $artikal; ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="kolicina" class="col-sm-3 control-label">Količina</label>
                    <div class="col-sm-3">
                        <input type="text" name="kolicina" class="form-control input-sm" id="kolicina" placeholder="Količina" value="<?= $kolicina; ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="masa" id="masa" <?= $masa == 1 ? "checked" : ""; ?> value="1"> Količina ulazi u masu proizvoda
                            </label>
                        </div>
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

        $("#artikal").select().focus();
        setTimeout(function () {
            $("#artikal").select().focus()
        }, 400);

        $('#save').click(function () {
            $(this).hide();
            $('#close').hide();
            $("#loader").show();

            form2post("<?= $proplaniranje_url . "/save_sirovina"; ?>", $('#frm').serialize(), function (status, data) {
                if (!status) {
                    $('#frmAlert').html(data).fadeIn(100);
                    $('#save').show();
                    $('#close').show();
                    $("#loader").hide();
                    return;
                }
                $('*[data-nalog="<?= $nalog; ?>"]').click();
                $("#close").click();
            });
        });

    });
</script>
