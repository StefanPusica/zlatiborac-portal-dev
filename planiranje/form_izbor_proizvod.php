<style>
    .checkbox-inline.no_indent,
    .checkbox-inline.no_indent+.checkbox-inline.no_indent {
        margin-left: 0;
        margin-right: 10px;
    }
    .checkbox-inline.no_indent:last-child {
        margin-right: 0;
    }

</style>


<div id="blendaForm" class="blenda" style="display: none;">
    <img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader3.gif">
</div>

<div class="modal-dialog" style="">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $naslovForme; ?></h4>
        </div>
        <div class="modal-body" style="height: 540px;">

            <div id="frmAlert" class="alert alert-danger" style="display: none;"></div>

            <form class="form-horizontal" role="form" name="frmIzbor" id="frmIzbor">

                <div class="form-group" style="margin-top: -8px;">

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <label for="artikal" class="control-label">Artikal</label>
                        <input type="text" name="artikal" class="form-control input-sm text-center" id="artikal" placeholder="Šifra artikla" value="<?= $artikal; ?>">
                    </div>

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <button class="btn btn-xs btn-mini btn-default btnRnPretraga" style="margin-top: 23px;"><i class="icon-filter2"></i></button>
                    </div>

                </div>

            </form>

            <form class="form-horizontal" role="form" name="frm" id="frmRnUvoz">
                <div class="form-group" style="">
                    <div id="frmContent" style="height: 478px; overflow-x: hidden; overflow-y: scroll; float:left; margin-left: 15px;">
                        <div class="bs-callout bs-callout-info" style="margin: 0px 2px 0px 2px;">
                            Unesite šifru sirovog proizvoda
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <span class=" pull-left">
                <i class="icon-info-circle text-info"></i> Uvoz artikala biće izvršen samo gde je definisana komora!
            </span>
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="closeForm">Zatvori</button>
            <button type="button" class="btn btn-success btn-sm" id="saveForm">Snimi</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    var oBlendaForm = null;

    // $(function() {
    $(document).ready(function () {
        $("#myModal").attr('tabIndex', '');

        contentLoader();

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
            /*
             var artikli = [];
             $('.chArtList:checked', $("#frmContent")).each(function () {
             artikli.push($(this).data('row'));
             });
             
             if (artikli.length == 0) {
             $('#frmAlert').html("Morate izabrati barem jedan artikal").fadeIn(100);
             return;
             }
             */
            $("#closeForm").hide();
            $("#saveForm").hide();
            // var arr = aids.join(",");

            var args = $('#frmRnUvoz').serialize();

            form2post("<?= $proplaniranje_url; ?>/save_uvoz_rn", args, function (status, data) {
                oBlendaForm.hide();
                if (!status) {
                    // $('#frmAlert').html(data).fadeIn(100);
                    $.pnotify({title: 'Uvoz radnog naloga', text: data, type: "error", icon: true, opacity: .8});
                    $("#closeForm").show();
                    $("#saveForm").show();
                    return;
                }
                $('*[data-nalog="<?= $nalogId; ?>"]').click();
                $("#closeForm").click();
            });


        });

    });

    function contentLoader() {
        var o = $("#frmContent");

        var args = {artikal: $("#artikal").val()};
        //var b = $("#blenda");
        // b.show();
        urlContent(o, "<?= $proplaniranje_url; ?>/xIzborProizvoda", args, function () {
            // b.hide();
        });
    }


</script>
