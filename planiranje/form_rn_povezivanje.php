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

<div class="modal-dialog" style="width:1020px;">
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
                        <label for="datum_od" class="control-label">Period</label>
                        <input type="text" name="datum_od" class="form-control input-sm text-center" id="datum_od" placeholder="Datum" value="<?= $datum_od; ?>" readonly="readonly">
                    </div>

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <label for="datum_do" class="control-label">&nbsp;</label>
                        <input type="text" name="datum_do" class="form-control input-sm text-center" id="datum_do" placeholder="Datum" value="<?= $datum_do; ?>" readonly="readonly">
                    </div>

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <label for="broj" class="control-label">Broj</label>
                        <input type="text" name="broj" class="form-control input-sm text-center" id="broj" placeholder="Broj naloga" value="<?= $broj; ?>">
                    </div>

                    <div class="" style="width: 200px; padding-left: 15px; float: left;">
                        <label for="artikal" class="control-label">Artikal</label>
                        <select id="artikal" name="artikal" class="form-control input-sm" style="padding: 3px 1px;">
                            <option value="0">Izbor artikla</option>
                            <?php
                            foreach ($arrArtikal as $key => $val) {
                                $sel = $artikal == $key ? "selected='selected'" : "";
                                echo '<option value="' . $key . '" ' . $sel . '>' . $key . ' - ' . $val . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <button class="btn btn-xs btn-mini btn-default btnRnPretraga" style="margin-top: 23px;"><i class="icon-filter2"></i></button>
                    </div>

                </div>

            </form>

            <form class="form-horizontal" role="form" name="frm" id="frmRnUvoz">
                <div class="form-group" style="width: 1010px;">

                    <div id="frmContent" style="height: 478px; width: 400px; overflow-x: hidden; overflow-y: scroll; float:left; margin-left: 15px;">

                        <div class="bs-callout bs-callout-info" style="margin: 0px 2px 0px 2px;">
                            Pronadjite željene naloge
                        </div>
                    </div>

                    <div id="frmRnContent" style="height: 478px; width: 584px; overflow-x: hidden; overflow-y: scroll; float:left;">

                        <div class="bs-callout bs-callout-info" style="margin: 0px 2px 0px 2px;">
                            Potrebno je da izaberete nalog
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

        $("#grupa").select2();

        $.datepicker.setDefaults($.datepicker.regional['rs']);

        var startDateTextBox = $('#datum_od');
        var endDateTextBox = $('#datum_do');

        startDateTextBox.datepicker({
            changeMonth: true,
            changeYear: true,
            "option": $.datepicker.regional['rs'],
            onClose: function (selectedDate) {
                endDateTextBox.datepicker("option", "minDate", selectedDate);
            }
        });

        endDateTextBox.datepicker({
            changeMonth: true,
            changeYear: true,
            "option": $.datepicker.regional['rs'],
            onClose: function (selectedDate) {
                startDateTextBox.datepicker("option", "maxDate", selectedDate);
            }
        });

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
                $("#closeForm").show();
                $("#saveForm").show();

                if (!status) {
                    // $('#frmAlert').html(data).fadeIn(100);
                    $.pnotify({title: 'Uvoz radnog naloga', text: data, type: "error", icon: true, opacity: .8});
                    return;
                }
                $('*[data-nalog="<?= $nalogId; ?>"]').click();
                // $("#closeForm").click();
            });


        });

    });

    function contentLoader() {
        var o = $("#frmContent");
        var args = {nalog: '<?= $nalogSifra; ?>', proces: <?= $proces; ?>, datum_od: $("#datum_od").val(), datum_do: $("#datum_do").val(), broj: $("#broj").val(), artikal: $("#artikal").val()};
        //var b = $("#blenda");
        // b.show();
        urlContent(o, "<?= $proplaniranje_url; ?>/xRadniNalozi", args, function () {
            // b.hide();
        });
    }

    function contentRnLoader(nalog, planNalog, proces) {
        var o = $("#frmRnContent");

        /*
         var nalozi = [];
         $('.chNalogList:checked', $("#frmContent")).each(function () {
         nalozi.push($(this).data('row'));
         });
         * 
         */


        var args = {plan_nalog: planNalog, nalog: nalog, proces: proces}; //  {nalozi: nalozi.join(",")};
        //var b = $("#blenda");
        // b.show();
        urlContent(o, "<?= $proplaniranje_url; ?>/xRadniNalogArtikli", args, function () {
            // b.hide();
        });
    }


</script>
