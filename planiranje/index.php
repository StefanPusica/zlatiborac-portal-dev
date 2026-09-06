<style>
    .planHolder {
        padding: 0px;
        overflow: hidden;
        position: relative;
    }

    .topHolder {

        overflow-x: auto;
        overflow-y: auto;
        /* width: 283px; */
        top: 0px;
        height: 200px;
        border-left: 1px solid rgb(221, 221, 221);
    }

    .commandHolder {

        /* width: 1176px; */
        top: 0px;
        height: 0px;
        /* height: 100%; */
        overflow-x: hidden;
        overflow-y: hidden;
        border-left: 1px solid rgb(221, 221, 221);

        /*background-color: #ddd;*/
    }

    .pageHolder {
        /*background-color: #ddd;*/
        display: flex;
        flex-direction: row;
        /*height: 400px; */
    }


    .mPageSpliter {
        position: relative;
        height: 5px;
        /* background-color: rgba(170, 170, 170, .2); */
        cursor: ns-resize;
        text-align: center;
        color: white;
        box-shadow: 0 0 3px rgba(0, 0, 0, .4);
        background: rgba(170, 170, 170, .2) url(/public/img/splitter_dots_horizontal.png) no-repeat center center;
        z-index: 11;
        /*padding-top: 20px;*/
        /* left: 283px; */
    }

    .mPageSpliter:hover {
        background-color: rgba(170, 170, 170, .5);
        box-shadow: 0 0 5px rgba(0, 0, 0, .5);
    }

    .unselectable {
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -o-user-select: none;
        user-select: none;
    }

    .leftBar {
        width: 280px;
        height: 0px;
        float: left;

        -webkit-transition: all 350ms cubic-bezier(0.6, 0.05, 0.28, 0.91);
        transition: all 350ms cubic-bezier(0.6, 0.05, 0.28, 0.91);

        -webkit-box-shadow: inset 0px 0px 0px 1px #ddd;
        -moz-box-shadow: inset 0px 0px 0px 1px #ddd;
        box-shadow: inset 0px 0px 0px 1px #ddd;

        overflow-x: hidden;
        font-size: 10px !important;
    }

    .choosePlanHolder {
        height: 30px;
    }

    .eSirovina {
        font-size: 10px !important;
    }

    .ePlanArtikal {
        font-size: 10px !important;
    }

    .proizvodSelector {}

    .proizvodSelector:hover {
        background-color: #b8deff;
        cursor: pointer;
    }

    .proizvodSelector:active {
        background-color: #43a4f9 !important;
        color: #fff;
    }

    .proizvodSelector.active {
        background-color: #43a4f9 !important;
        color: #fff;
    }

    .btnLeftLink {
        width: 20px;
        position: fixed;
        left: 6px;
        top: 103px;
        height: 148px;
        background-color: #f2f5f7;
        writing-mode: vertical-rl;
        text-orientation: mixed;
        /* direction: rtl; */
        text-align: center;
        transform: rotate(-180deg);
        -webkit-transform: rotate(-180deg);
        -moz-transform: rotate(-180deg);
        -ms-transform: rotate(-180deg);
        -o-transform: rotate(-180deg);
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: pointer;
        border: 1px solid #efeded;
        /*border-left: 0px;*/
    }

    .btnLeftLink.active {
        background-color: #acd2ff !important;
    }
</style>

<ol class="breadcrumb mjsBreadcrumb">
    <li><a href="<?= $pro20_url; ?>">Pro20</a></li>
    <li><a href="<?= $proplaniranje_url; ?>">Planiranje</a></li>
    <li>Planiranje po danima</li>
    <li class="pull-right">
        <?
        #if (isSessionUserAdmin()) {
        ?>
        <button type="button" id="btnExcel" class="btn btn-default btn-sm" style="margin-top: -5px; display:none;"><span class="glyphicon icon-file-excel-o"></span> Preuzmi excel</button>
        <?
        #}
        ?>
    </li>
</ol>

<div id="blenda" class="blenda" style="display: none;">
    <img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader3.gif">
</div>

<div class="btnLeftLink">Planovi</div>

<div class="leftBar" style="">
    <?
    if ($pravoUpravljanja) {
    ?>

        <div class="choosePlanHolder">

            <button class="btn btn-xs btn-mini btn-default btnAddPlan" style="padding: 2px 6px; margin: 4px 0px 0px 8px;" title="Novi nedeljni plan"><i class="icon-plus"></i> Novi plan</button>
            <?
            #if (isSessionUserAdmin()) {
            ?>

            <div style="line-height: 20px;float: right;margin-right: 4px;vertical-align: middle;">
                <label>
                    <span><input type="checkbox" name="samoMojiArtikli" id="samoMojiArtikli" value="" style="vertical-align: middle;"></span><span for="samoMojiArtikli" style="vertical-align: middle;margin-left: 2px; cursor:pointer;">Samo moji artikli</span>
                </label>
            </div>
            <?
            #}
            ?>
        </div>
    <?
    }
    ?>

    <div class="choosePlanHolder" style="padding: 2px 6px;">
        <select id="selPlan" name="plan" class="form-control input-sm">
            <?
            foreach ($arrPlan as $key => $o) {
                $sel = ''; //$_SESSION['AutoPark']['selSektor'] == trim($oSektor->sektor) ? "selected='selected'" : "";
                echo '<option value="' . $o->id . '" ' . $sel . '>' . $o->naziv . '</option>';
            }
            ?>
        </select>

    </div>
    <div class="planItemHolder">

    </div>
</div>

<div class="planHolder">
    <div class="topHolder">
        <div class="text-center">
            <img src="<?= $public_url; ?>/img/teleskop.png"><br>
            <span style="font-size: 14px; font-weight: bold">Potrebno je da izaberete proizvod</span>
        </div>
    </div>

    <div class="mPageSpliter"></div>

    <div class="commandHolder">
        <div class="text-center" style="background-image: url(<?= $public_url; ?>/img/patern-1.png);
             background-size: contain;
             height: 100%;">
        </div>
    </div>
</div>

<script>
    var oBlenda = null;
    var holder = null;
    var holderHeight = 0;
    var splitter = null;
    var topRow = null;
    var bottomRow = null;
    var markers = null;

    var topColumnMinHeight = 120;
    var bottomColumnMinHeight = 80;
    var perc = 40;
    var leftBarWidth = 280;

    var selectedPlan = <?= $planId; ?>;
    var selectedPro = 0;
    var samoMojiArtikli = 0;

    (function($) {

        $("#selPlan").select2();

        oBlenda = $("#blenda");
        oBlenda.show();

        holder = $(".planHolder");
        splitter = $(".mPageSpliter");

        topRow = $(".topHolder");
        bottomRow = $(".commandHolder");

        $(window).resize(function() {
            setLayout();
        });

        initLayout();
        setLayout();
        oBlenda.hide();

        // loader();
        splitter.on("mousedown.gdf", function(e) {
            e.preventDefault();
            $("body").addClass("gdfHResizing");
            var splBar = $(this);

            $("body").on("mousemove.gdf", function(e) {
                e.preventDefault();

                if (!$("body").hasClass("gdfHResizing"))
                    return;

                var sb = splBar;
                var pos = e.pageY - sb.parent().offset().top;
                var h = sb.parent().height();


                pos = pos > bottomColumnMinHeight ? pos : bottomColumnMinHeight;
                pos = pos > holder.innerHeight() - splitter.height() - bottomColumnMinHeight ? holder.innerHeight() - splitter.height() - bottomColumnMinHeight : pos;
                topRow.height(pos);
                bottomRow.css({
                    top: pos + sb.height(),
                    height: h - pos - sb.height()
                });

                perc = (topRow.height() / holderHeight) * 100;

                zWrapperResize();
                zSirWrapperResize();

            }).on("mouseup.gdf", function() {
                $(this).off("mousemove.gdf").off("mouseup.gdf"); // .clearUnselectable();
                delete splBar;
                $("body").removeClass("gdfHResizing");
                storePosition();
            });
        });


        selectedPlan = selectedPlan > 0 ? selectedPlan : $("#selPlan").val();

        if (selectedPlan > 0)
            $("#selPlan").select2('val', selectedPlan).change()

        loadPlan();

        $(document).on("click", ".btnLeftLink", function() {
            if (parseInt($(".leftBar").width()) == 0) {
                $(".leftBar").width(leftBarWidth);
                $(this).removeClass("active")
            } else {
                $(".leftBar").width(0);
                $(this).addClass("active")
            }
        });

        $("#selPlan").change(function() {
            selectedPlan = $(this).val();
            selectedPro = 0;
            loadPlan();
            loadProizvod();
            loadSirovine()

            $("#btnExcel").hide();
        });

        $(document).on("click", ".btnAddArtikal", function() {
            // console.log("add-artikle")
            var p = $(this).data("row");
            urlModal("<?= "$proplaniranje_url/add_artikal/"; ?>" + p, "static")
        });

        $(document).on("click", ".btnAddProizvodArtikal", function() {
            var p = $(this).data("row");
            urlModal("<?= "$proplaniranje_url/izborProizvoda/"; ?>" + p, "static")
        });

        $(document).on("click", ".btnAddSirovProizvodArtikal", function() {
            var p = $(this).data("row");
            urlModal("<?= "$proplaniranje_url/izborSirovogProizvoda/"; ?>" + p, "static")
        });


        $(document).on("click", ".btnRemoveArtikle", function() {
            var p = $(this).data("row");

            urlModal("<?= "$proplaniranje_url/remove_artikli/"; ?>" + p, "static")
        });

        $(document).on("click", ".proizvodSelector", function() {

            $(".proizvodSelector").removeClass("active");
            $(this).addClass("active")

            var p = $(this).data("row");
            selectedPro = p;
            loadProizvod();
            loadSirovine();

            $("#btnExcel").show();
        });

        $(document).on("click", ".btnGenerator", function() {
            var p = $(this).data("row");
            urlModal("<?= "$proplaniranje_url/generator/"; ?>" + p, "static")
        });

        $(document).on("click", ".btnPPGenerator", function() {
            var p = $(this).data("row");
            urlModal("<?= "$proplaniranje_url/pp_generator/"; ?>" + p, "static")
        });


        $(document).on("click", ".btnGeneratorProizvod", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var p = $(this).data("row");
            var pp = $(this).data("proizvod");
            urlModal("<?= "$proplaniranje_url/generator_proizvod/"; ?>" + p + "/" + pp, "static")
        });

        $(document).on("click", ".eProizvod", function() {
            var n = $(this).data("nalog");
            var p = $(this).data("proces");
            var pr = $(this).data("proizvod");

            $('.eProizvod', $("#procesList_" + p)).removeClass("active")
            $('*[data-nalog="' + n + '"]', $("#procesList_" + p)).addClass("active")

            loadProcesSirovine(pr, p, n);
        });

        $(document).on("mouseover", ".eProizvod", function() {
            var n = $(this).data("nalog-parent");

            $('.eProizvod').removeClass("parent");
            $('*[data-nalog-broj="' + n + '"]').addClass("parent");

        });

        $(document).on("click", ".btnHideSirFilter", function() {
            var n = $(this).data("nalog");
            var p = $(this).data("proces");
            var pr = $(this).data("proizvod");

            $('*[data-nalog="' + n + '"]', $("#procesList_" + p)).removeClass("active")

            loadProcesSirovine(pr, p, 0);
        });

        $(document).on("click", ".btnConnector", function() {
            var n = $(this).data("nalog");
            var p = $(this).data("proces");

            urlModal("<?= "$proplaniranje_url/add_rn/"; ?>" + n + "/" + p, "static")
        });

        $(document).on("click", ".btnVezaNalog", function() {
            var n = $(this).data("nalog");
            var s = $(this).data("nalog-sifra");
            // urlLocationNewWindow("<?= "$kvalitetradninalog_url/"; ?>" + n);
            urlLocationNewWindow("<?= "$kvalitetradninalozi_url?master="; ?>" + s);
        });

        $(document).on("click", ".btnVirtualniNalog", function() {
            var n = $(this).data("nalog");

            urlModal("<?= "$proplaniranje_url/virtuelni_nalog/"; ?>" + n, "static")
        });

        $(document).on("click", ".btnRnPretraga", function(e) {
            e.preventDefault();
            contentLoader();
            contentRnLoader(0, 0, 0);
        });

        $(document).on("click", ".btnProizvodPretraga", function(e) {
            e.preventDefault();
            contentProizvodLoader();
        });

        $(document).on("change", ".chNalogList", function() {

        });

        $(document).on("change", "#sirovProizvodSel", function(e) {
            e.preventDefault();
            contentSirovProizvodLoader();
        });

        $(document).on("click", ".rowRn", function() {
            $(".rowRnTr").removeClass("aktivan")
            $(this).parent().addClass("aktivan")
            var n = $(this).parent().data('row')
            var pn = $(this).parent().data('plan-nalog')
            var p = $(this).parent().data('proces')
            contentRnLoader(n, pn, p);
        });

        $(document).on("click", ".btnAddPlan", function(e) {
            e.preventDefault();

            urlModal("<?= "$proplaniranje_url/add_plan"; ?>", "static")
        });

        $(document).on("click", ".ePlanArtikal", function(e) {
            e.preventDefault();

            var p = $(this).parent().data("plan")
            var a = $(this).parent().data("artikal")

            urlModal("<?= "$proplaniranje_url/change_artikal/"; ?>" + p + '/' + a, "static")
        });

        <?
        if ($pravoUpravljanja) {
        ?>
            $(document).on("click", ".eArtSirovina", function(e) {
                e.preventDefault();

                var i = $(this).parent().data("row")
                var n = $(this).parent().data("nalog")
                if (n == 0)
                    return;

                urlModal("<?= "$proplaniranje_url/change_sirovina_artikal/"; ?>" + i + '/' + n, "static")
            });
        <?
        }
        ?>
        $("#samoMojiArtikli").change(function() {
            samoMojiArtikli = this.checked ? 1 : 0;
            loadPlan();
        });

        $("#btnExcel").click(function(e) {
            window.location = "<?= "$proplaniranje_url/planiranje_excel?"; ?>" + "plan=" + selectedPlan + "&proizvod=" + selectedPro;
            e.preventDefault();
        });


    })(jQuery);

    function loadPlan() {
        var o = $(".planItemHolder");

        var oBlenda = $("#blenda");
        oBlenda.show();
        // $("#selTip").val(vrsPregled);
        urlContent(o, "<?= "$proplaniranje_url/xPlan"; ?>", {
            plan: selectedPlan,
            samoMojiArtikli: samoMojiArtikli
        }, function() {
            oBlenda.hide();
        });
    }

    function loadProizvod() {
        var o = $(".topHolder");

        var oBlenda = $("#blenda");
        oBlenda.show();
        // $("#selTip").val(vrsPregled);
        urlContent(o, "<?= "$proplaniranje_url/xProizvod"; ?>", {
            plan: selectedPlan,
            proizvod: selectedPro
        }, function() {
            scrollSync(".scrollSync")
            zWrapperResize();
            oBlenda.hide();
        });
    }

    function loadSirovine() {
        var o = $(".commandHolder");

        var oBlenda = $("#blenda");
        oBlenda.show();
        // $("#selTip").val(vrsPregled);
        urlContent(o, "<?= "$proplaniranje_url/xSirovine"; ?>", {
            plan: selectedPlan,
            proizvod: selectedPro
        }, function() {
            scrollSync(".scrollSync")
            zSirWrapperResize();
            oBlenda.hide();
        });
    }

    function loadProcesSirovine(proizvod, proces, nalog) {
        var o = $("#commandProces_" + proces);

        //var oBlenda = $("#blenda");
        // oBlenda.show();

        urlContent(o, "<?= "$proplaniranje_url/xProcesSirovine"; ?>", {
            plan: selectedPlan,
            proizvod: proizvod,
            proces: proces,
            nalog: nalog
        }, function() {
            scrollSync(".scrollSync")
            zSirWrapperResize();
            // oBlenda.hide();
        });

    }

    function setLayout() {

        var h = $(window).height() - $(".planHolder").offset().top - 16
        $(".planHolder").height(h);

        holderHeight = holder.innerHeight();
        // $(".pageHolder").height(h);
        $(".leftBar").height(h);

        var animTime = 0; // anim ? anim : 0;
        var percent = perc;
        var totalH = holder.innerHeight();
        var splHeight = splitter.height();
        var newW = totalH * percent / 100;
        newW = newW > topColumnMinHeight ? newW : topColumnMinHeight;
        newW = newW > totalH - splHeight - bottomColumnMinHeight ? totalH - splHeight - bottomColumnMinHeight : newW;

        topRow.animate({
            height: newW
        }, animTime, function() {
            // $(this).css("overflow-x", "auto")
        });
        // splitter.animate({left: newW}, animTime);
        var rHeight = parseFloat(Math.ceil(totalH - newW - splHeight)).toFixed(0)

        bottomRow.animate({
            top: newW + splitter.height(),
            height: rHeight
        }, animTime, function() {
            $(this).css("overflow", "auto")
        });

        var pihPos = $(".planItemHolder").position();
        var lmW = $(".btnLeftLink").width();
        var blLeft = parseFloat(pihPos.left) - parseFloat(lmW);
        $(".btnLeftLink").css({
            left: blLeft
        });
    }

    function initLayout() {

        loadPosition();

        holderHeight = holder.innerHeight();
        var splitterHeight = splitter.height();
        var topColHeight = holderHeight * perc / 100;
        topColHeight = topColHeight > holderHeight - splitterHeight - bottomColumnMinHeight ? holderHeight - splitterHeight - bottomColumnMinHeight : topColHeight;
        topRow.height(topColHeight); // .css({left: 0});
        splitter.css({
            top: 0
        });
        bottomRow.height(holderHeight - topColHeight - splitterHeight).css({
            top: topRow.height() + splitterHeight
        });
        jsLog("bottomHeight: " + bottomRow.height());

    }

    function storePosition() {
        saveStorage("planPercent", perc)
    }

    function loadPosition() {
        perc = parseFloat(loadStorage("planPercent"))
    }

    function saveStorage(key, value) {
        if (localStorage)
            localStorage.setItem(key, value);
    }

    function loadStorage(key) {
        if (!localStorage)
            return false;
        if (localStorage.getItem(key))
            return localStorage.getItem(key);
    }

    function jsLog(msg) {
        console.log(msg);
    }

    function scrollSync(selector) {
        let active = null;
        document.querySelectorAll(selector).forEach(function(element) {
            element.addEventListener("mouseenter", function(e) {
                active = e.target;
            });

            element.addEventListener("scroll", function(e) {
                if (e.target !== active)
                    return;

                document.querySelectorAll(selector).forEach(function(target) {
                    if (active === target)
                        return;

                    // target.scrollTop = active.scrollTop;
                    target.scrollLeft = active.scrollLeft;
                });
            });
        });
    }
</script>