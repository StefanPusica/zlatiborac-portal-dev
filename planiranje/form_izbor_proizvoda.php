
<div id="blendaForm" class="blenda" style="display: none;">
    <img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader3.gif">
</div>

<div class="modal-dialog" style="">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $naslovForme; ?></h4>
        </div>
        <div class="modal-body" style="height: 440px;">

            <div id="frmAlert" class="alert alert-danger" style="display: none;"></div>

            <form class="form-horizontal" role="form" name="frmIzbor" id="frmIzbor">

                <div class="form-group" style="margin-top: -8px;">

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <label for="artikal" class="control-label">Artikal</label>
                        <input type="text" name="artikal" class="form-control input-sm text-center" id="artikal" placeholder="Šifra artikla" value="<?= $artikal; ?>">
                    </div>

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <button class="btn btn-xs btn-mini btn-default btnProizvodPretraga" style="margin-top: 23px;"><i class="icon-filter2"></i></button>
                    </div>

                </div>

            </form>

            <form class="form-horizontal" role="form" name="frm" id="frmProizvodIzbor">
                <div class="form-group" style="">
                    <div id="frmContentProizvod" style="height: 380px; width: 95%; overflow-x: hidden;overflow-y: scroll;float: left;margin-left: 15px;margin-right: 15px;">

                        <div class="bs-callout bs-callout-info" style="margin: 0px 2px 0px 2px;">
                            Unesite šifru sirovog proizvoda
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <span class=" pull-left">
                <i class="icon-info-circle text-info"></i> Uvoz artikala biće izvršen samo gde je uneta količina!
            </span>
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="closeForm">Zatvori</button>
            <button type="button" class="btn btn-success btn-sm" id="saveForm">Snimi</button>
        </div>
    </div><!-- /.modal-content -->
</div>

<script>
    var oBlendaForm = null;

    // $(function() {
    $(document).ready(function () {
        $("#myModal").attr('tabIndex', '');

        $(document).on("change", "#checkAll", function () {
            var checked = this.checked;
            $('.chNalogList', $("#frmContent")).each(function (index) {
                $(this).prop('checked', checked);
                $(this).change();
            });
        });

        $("#saveForm").click(function () {

            oBlendaForm = $("#blendaForm");
            oBlendaForm.show();

            $("#closeForm").hide();
            $("#saveForm").hide();

            var args = $('#frmProizvodIzbor').serialize();

            form2post("<?= $proplaniranje_url; ?>/save_proizvod_artikli", args, function (status, data) {
                oBlendaForm.hide();
                if (!status) {
                    // $('#frmAlert').html(data).fadeIn(100);
                    $.pnotify({title: 'Snimanje artikala sirovog proizvoda', text: data, type: "error", icon: true, opacity: .8});
                    $("#closeForm").show();
                    $("#saveForm").show();
                    return;
                }
                loadPlan();
                $("#closeForm").click();
            });


        });

    });

    function contentProizvodLoader() {
        var o = $("#frmContentProizvod");

        var args = {plan: <?= $plan; ?>, artikal: $("#artikal").val()};
        urlContent(o, "<?= $proplaniranje_url; ?>/xIzborProizvoda", args, function () {
        });
    }


</script>
