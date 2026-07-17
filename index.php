<ol class="breadcrumb" style="margin-bottom:5px;">
    <li><a href="<?= $pro20_url; ?>">Pro20</a></li>
    <li>Planiranje</li>
</ol>

<?
$arrPrava = [
    UserNivo::$Administrator,
    UserNivo::$ITOperationManager,
    UserNivo::$MenadzerPlaniranjaKontroleZaliha,
    UserNivo::$DirektorProizvodnje
];

$arrPrava2 = [UserNivo::$Administrator, UserNivo::$ITOperationManager, UserNivo::$DirektorProizvodnje];

$arrPrava3 = [
    UserNivo::$Administrator,
    UserNivo::$IT,
    UserNivo::$DirektorProizvodnje,
    UserNivo::$MenadzerProizvodnjePolutrajne,
    UserNivo::$MenadzerProizvodnjeTrajna,
    UserNivo::$SefOdeljenjaPakovanjaVakuumaRinfuza,
    UserNivo::$SefOdeljenjaPakovanjaTrajnihPolutrajnihProizvoda,
    UserNivo::$SefDimljenjaFermentacije,
    UserNivo::$KontrolorKvaliteta
];

$arrPrava4 = [UserNivo::$Administrator];

$arrApps = [
    ["naziv" => "Planiranje", "link" => $proplaniranje_url . "/planiranje", "icon" => "glyphicon icon-random", "objavljen" => "2025-06-06", "prava" => $arrPrava4],
    ["naziv" => "Planiranje procesa", "link" => $proplaniranje_url . "/planiranje_procesa", "icon" => "glyphicon icon-retweet", "objavljen" => "2025-06-06", "prava" => $arrPrava4],
    ["naziv" => "Plan isporuke", "link" => $root_url . "/isporuke", "icon" => "glyphicon icon-truck2", "objavljen" => "2025-06-06", "prava" => $arrPrava4],
    ["naziv" => "Planiranje pakovanja", "link" => $root_url . "/pakovanje", "icon" => "glyphicon icon-gift2", "objavljen" => "2025-06-06", "prava" => $arrPrava4],
    ["naziv" => "Mesečni plan proizvodnje", "link" => $root_url . "/mpp", "icon" => "glyphicon icon-calendar3", "objavljen" => "2025-06-06", "prava" => $arrPrava4]
];
?>
<div class="row">

    <div class="mjsList col-sm-12">
        <ul class="mjsList-list">
            <?
            foreach ($arrApps as $key => $a) {
                if (!in_array($login->getUserGroup(), $a['prava']))
                    continue;
            ?>
                <li data-link="<?= $a['link']; ?>" style="position:relative;">
                    <div class="pull-left" style="font-size: 9px;"><?= Datum::datumTekstSkraceno($a['objavljen']); ?></div>
                    <div class="pull-right" style="font-size: 9px;position: absolute; right: 2px;"><?
                                                                                                    if (Datum::diff2days($a['objavljen']) < 31) {
                                                                                                    ?>
                            <span class="badge badge-mini badge-error">novo</span>
                        <?
                                                                                                    }
                        ?>
                    </div>
                    <br>
                    <span class="glyphicon <?= $a['icon']; ?>" aria-hidden="true"></span>
                    <span class="glyphicon-class"><?= $a['naziv']; ?></span>
                </li>
            <?
            }
            ?>
        </ul>
    </div>
</div>

<script>
    (function($) {
        $("li", $(".mjsList-list")).click(function() {
            window.location = $(this).data("link");
        });
    })(jQuery);
</script>