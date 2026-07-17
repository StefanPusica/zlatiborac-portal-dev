
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

                <div class="form-group">
                    <label for="godina" class="col-sm-3 control-label">Godina</label>
                    <div class="col-sm-6">
                        <input type="text" name="godina" class="form-control input-sm" id="godina" placeholder="godina" value="<?= $godina; ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="nedelja" class="col-sm-3 control-label">Nedelja</label>
                    <div class="col-sm-6">
                        <select id="nedelja" name="nedelja" class="form-control input-sm" >
                            <?
                            for ($index = $nedelja; $index <= 52; $index++) {
                                $sel = '';
                                $aPeriod = Datum::nedeljaPeriod($godina, $index);

                                $poc = Datum::stamp2date($aPeriod['prvi']);
                                $kraj = Datum::stamp2date($aPeriod['poslednji']);

                                echo "<option value='$index' $sel ># $index $poc - $kraj</option>";
                            }
                            ?>
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
                urlLocation('<?= "$proplaniranje_url/planiranje/"; ?>' + data);
                $("#close").click();
            });
        });

    });
</script>
