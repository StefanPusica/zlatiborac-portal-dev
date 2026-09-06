
<ol class="breadcrumb mjsBreadcrumb">
    <li class="active"><strong><?= $artikal . " - " . $artikal_naziv; ?> </strong></li>
    <li class="pull-right">
        <button id="sideBarClose" class="btn btn-sm btn-default" style="padding: 3px 10px; margin-top: -3px; margin-right: -12px;">Zatvori</button>
    </li>
</ol>

<div class="sidebarContent" style="/*overflow-y: scroll;*/">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row row-profil">
                <div class="col-sm-3">
                    <span class="dt-info">Broj</span><br/><b><?= $broj; ?></b><br/>
                    <span class="dt-info">Datum</span><br/><b><?= Datum::stamp2date($datum); ?></b><br/>
                </div>
                <div class="col-sm-3">
                    <span class="dt-info">Master nalog</span><br/><b><?= $sifra; ?></b><br/>
                </div>
            </div>

            <div id="frmContentVirtuelniNalog" style="height: 380px; width: 100%; overflow-x: hidden;overflow-y: scroll;">

                <?
                $kolPred = 0;
                # print_r($arrPredajnica);
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
                        </thead>
                        <tbody>
                            <?
                            $n = 0;

                            foreach ($arrPredajnica as $key => $a) {
                                $o = (object) $a;
                                $n++;
                                $statusIco = "";
                                $statusColor = "";
                                ?>
                                <tr>
                                    <td width="20"><?= $n; ?>.</td>
                                    <td class=""><?= "({$o->artikal}) " . $o->artikal_naziv; ?></td>
                                    <td class="text-right"><?= kolicinaString($o->kolicina); ?></td>
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

                        <table class="table table-hover table-condensed table-striped">
                            <thead>
                            <th width="20">#</th>
                            <th width="">Artikal</th>
                            <th width="70">Količina</th>
                            </thead>
                            <tbody>
                                <?
                                $n = 0;

                                foreach ($arrTrebovanje as $key => $a) {
                                    $o = (object) $a;
                                    $n++;
                                    $statusIco = "";
                                    $statusColor = "";

                                    $lot = "";
                                    $komora = 0;

                                    #if (isset($arrKartica[$a['artikal']])) {
                                    #    $lot = trim($arrKartica[$a['artikal']]['lot']);
                                    #   $komora = $arrKartica[$a['artikal']]['komora'];
                                    #}
                                    ?>
                                    <tr class="">
                                        <td width="20"><?= $n; ?>.</td>
                                        <td class=""><?= "({$o->artikal}) " . $o->artikal; ?></td>
                                        <td class="text-right"><?= kolicinaString($o->kolicina); ?></td>
                                    </tr>
                                    <?
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>

                    <?
                }
                ?>

            </div>


        </div>
    </div>

</div>

<script>

    document.addEventListener('click', function (e) {
        var nalogRow = e.target.closest('.nalogRow');
        if (nalogRow) {
            urlLocationNewWindow("<?= "$kvalitetradninalog_url/"; ?>" + nalogRow.parentElement.dataset.row);
        }
    });

    function resizeSidebarContent() {
        var sc = document.querySelector('.sidebarContent');
        var sb = document.querySelector('.mSideBar');
        if (sc && sb) sc.style.height = (sb.clientHeight - sc.getBoundingClientRect().top + 20) + 'px';
    }

    window.addEventListener('resize', resizeSidebarContent);
    resizeSidebarContent();

</script>