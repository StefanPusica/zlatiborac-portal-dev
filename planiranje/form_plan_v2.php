
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
                <input type="hidden" name="pakovanje" value="<?= $pakovanje; ?>" />

                <div class="form-group">
                    <label for="datum" class="col-sm-3 control-label">Datum</label>
                    <div class="col-sm-3">
                        <input type="text" name="datum" class="form-control input-sm" id="datum" placeholder="Datum" value="<?= $datum; ?>" >
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

        $.datepicker.setDefaults($.datepicker.regional['rs']);
        var startDateTextBox = $('#datum');

        startDateTextBox.datepicker({
            changeMonth: true,
            changeYear: true,
            "option": $.datepicker.regional['rs'],
            onClose: function (selectedDate) {
            }
        });


        $('#save').click(function () {
            $(this).hide();
            $('#close').hide();
            $("#loader").show();

            form2post("<?= $proplaniranje_url . "/save_plan"; ?>", $('#frm').serialize(), function (status, data) {
                if (!status) {
                    $('#frmAlert').html(data).fadeIn(100);
                    $('#save').show();
                    $('#close').show();
                    $("#loader").hide();
                    return;
                }
<?
if ($ref == 'pakovanje') {
    ?>
                    urlLocation('<?= "$proplaniranje_url/pakovanje/"; ?>' + data);
<? } else { ?>
                    urlLocation('<?= "$proplaniranje_url/planiranje/"; ?>' + data);
<? } ?>
                $("#close").click();
            });
        });

    });
</script>
