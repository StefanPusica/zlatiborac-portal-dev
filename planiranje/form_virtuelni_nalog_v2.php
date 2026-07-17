

<div class="modal-dialog" style="">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $naslovForme; ?></h4>
        </div>
        <div class="modal-body" style="height: 440px;">

            <div id="blendaForm" class="blenda" style="display: none;">
                <img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader3.gif">
            </div>

            <div id="frmAlert" class="bs-callout bs-callout-danger" style="display: none; margin-top: 0px;"></div>

            <form class="form-horizontal" role="form" name="frmIzbor" id="frmVirtuelniNalog">

                <div class="form-group" style="margin-top: -8px;">

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <label for="broj" class="control-label">Broj naloga</label>
                        <input type="text" name="broj" class="form-control input-sm text-center" id="broj" placeholder="Broj naloga" value="<?= $broj; ?>">
                    </div>

                    <div class="" style="width: 100px; padding-left: 15px; float: left;">
                        <label for="datum" class="control-label">Datum</label>
                        <input type="text" name="datum" class="form-control input-sm text-center" id="datum" placeholder="Datum" value="<?= $datum; ?>" readonly="readonly">
                    </div>

                    <?
                    #if (isSessionUserAdmin()) {
                    ?>

                    <div class="" style="width: 180px; padding-left: 15px; float: left;">
                        <label for="datum" class="control-label">Izradio</label>

                        <select id="izradio_radnik" name="izradio_radnik" class="form-control input-sm" >
                            <?
                            if (count($arrIzradio) == 0) {
                                ?>
                                <option value='0'>Izbor zaposlenog</option>
                                <?
                            }
                            #
                            foreach ($arrIzradio as $key => $a) {
                                ?>
                                <option value='<?= $a['radnik']; ?>'><?= $a['radnik_naziv']; ?></option>
                                <?
                            }
                            ?>
                        </select>

                    </div>

                    <?
                    #}
                    ?>

                </div>

                <div class="form-group" style="">
                    <div id="frmContentVirtuelniNalog" style="height: 380px; width: 95%; overflow-x: hidden;overflow-y: scroll;float: left;margin-left: 15px;margin-right: 15px;">

                        <input type="hidden" name="nalog" value="<?= $nalog; ?>" />
                        <input type="hidden" name="plan_nalog" value="<?= $plan_nalog; ?>" />
                        <input type="hidden" name="proces" value="<?= $proces; ?>" />

                        <?
                        $kolPred = 0;
                        if (count($arrPredajnica) > 0) {
                            ?>

                            <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px; margin-top: 5px;">
                                <i class="glyphicon icon-cube"></i> Proizvod
                            </div>

                            <table class="table table-hover table-condensed table-striped">
                                <thead>
                                <th width="20">#</th>
                                <th width="">Artikal</th>
                                <th width="90">Količina</th>
                                <th width="60">Komora</th>
                                <th width="80">Lot</th>
                                </thead>
                                <tbody>
                                    <?
                                    $n = 0;

                                    foreach ($arrPredajnica as $key => $a) {
                                        $n++;
                                        $statusIco = "";
                                        $statusColor = "";
                                        $kolPred = $a['kolicina'];
                                        ?>
                                        <tr>
                                            <td width="20"><?= $n; ?>.</td>
                                            <td class=""><?= "({$a['artikal']}) " . $a['artikal_naziv']; ?></td>
                                            <td class="text-right">
                                                <input type="text" name="kolicinaPred[]" class="form-control input-sm kolPredChanger" data-artikal="<?= $a['artikal']; ?>" style="height: 20px !important;font-size: 11px !important;" value="<?= ($a['kolicina']); ?>" >
                                            </td>
                                            <td>

                                                <input type="hidden" name="artikalPred[]" value="<?= $a['artikal']; ?>" />
                                                <input type="hidden" name="artikalNazivPred[]" value="<?= $a['artikal_naziv']; ?>" />
                                                <input type="hidden" name="nusproizvodPred[]" value="<?= $a['nusproizvod']; ?>" />
                                                <input type="hidden" name="jmDecPred[]" value="<?= $a['jm_dec']; ?>" />
                                                <input type="hidden" name="artikalTezinaPred[]" value="<?= $a['artikal_tezina']; ?>" />

                                                <select id="komoraPred_<?= $a['artikal']; ?>" name="komoraPred[]" class="" style="width:50px;" >
                                                    <option value='0'>Izbor komore</option>
                                                    <?
                                                    foreach ($arrKomora as $key => $oKom) {
                                                        $sel = ''; // $o->komora == $oKom->sifra ? "selected='selected'" : "";
                                                        echo "<option value='{$oKom->sifra}' $sel >{$oKom->sifra} - {$oKom->naziv}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="lotPred[]" class="form-control input-sm lotChangerPred" data-artikal="<?= $a['artikal']; ?>" style="height: 20px !important;font-size: 11px !important;" value="<? ?>" >
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <?
                        }
                        ?>

                        <?
                        if (count($arrTrebovanje) > 0) {
                            ?>

                            <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px; margin-top: 5px; margin-top: 10px;">
                                <i class="glyphicon icon-cart-arrow-down"></i> Trebovanje
                            </div>

                            <div class="trebHolder">


                            </div>

                            <?
                        }
                        ?>

                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">

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

        ucitavanjeSirovina(<?= $kolPred; ?>);

        $.datepicker.setDefaults($.datepicker.regional['rs']);

        var startDateTextBox = $('#datum');

        startDateTextBox.datepicker({
            changeMonth: true,
            changeYear: true,
            "option": $.datepicker.regional['rs'],
            onClose: function (selectedDate) {
                // endDateTextBox.datepicker("option", "minDate", selectedDate);
            }
        });

        $("#broj").change(function () {

            var b = $(this).val();
            // if ($(".lotChangerPred").val().length == 0) {
            $(".lotChangerPred").val("<?= $proces_skraceno; ?>/" + b).change();
            // }
        });
        $("#broj").change();

        $(".kolPredChanger").change(function () {
            var a = $(this).data("artikal");
            var k = $(this).val();
            ucitavanjeSirovina(k);
        });

        $(".lotChanger").change(function () {
            var v = $(this).val();
            var a = $(this).data("artikal");

            form2post("<?= $proplaniranje_url; ?>/xKomora", {artikal: a, lot: v}, function (status, data) {
                if (!status)
                    return;
                $("#komoraTreb_" + a).val(data);
            });
        });

        $(".lotChangerPred").change(function () {
            var v = $(this).val();
            var a = $(this).data("artikal");

            form2post("<?= $proplaniranje_url; ?>/xKomora", {artikal: a, lot: v}, function (status, data) {
                if (!status)
                    return;
                $("#komoraPred_" + a).val(data);
            });
        });

        $("#saveForm").click(function () {

            oBlendaForm = $("#blendaForm");
            oBlendaForm.show();

            $("#closeForm").hide();
            $("#saveForm").hide();

            var args = $('#frmVirtuelniNalog').serialize();

            form2post("<?= $proplaniranje_url; ?>/save_virtuelni_nalog", args, function (status, data) {
                oBlendaForm.hide();
                if (!status) {
                    $('#frmAlert').html(data).fadeIn(100);
                    $("#closeForm").show();
                    $("#saveForm").show();
                    return;
                }

                $('*[data-nalog="<?= $nalog; ?>"]').click();
                $("#closeForm").click();
            });


        });

    });

    function ucitavanjeSirovina(k) {
        var o = $(".trebHolder");

        var oBlenda = $("#blenda");
        oBlenda.show();
        // $("#selTip").val(vrsPregled);
        urlContent(o, "<?= "$proplaniranje_url/virtuelni_nalog_trebovanje"; ?>", {sifra: '<?= $plan_nalog; ?>', kolicina: k}, function () {
            oBlenda.hide();
        });
    }


</script>
