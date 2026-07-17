
<link href="<?= $public_url; ?>/css/mjsFlexPool.css" rel="stylesheet">
<style>
    .mFlexBox {
        min-width: 320px;
        max-width: 320px;
    }

    .mSideBar {
        position: fixed;
        /*overflow: auto;*/
        top: 57px;
        width: 640px;
        right: -640px;
        /* overflow: auto; */
        height: 100%;
        z-index: 1000;
        background-color: #fff;
        /* border-left: 3px solid #c1c1c1; */
        -webkit-transition: all 350ms cubic-bezier(0.6, 0.05, 0.28, 0.91);
        transition: all 350ms cubic-bezier(0.6, 0.05, 0.28, 0.91);

        -moz-box-shadow: 0 0 8px 4px rgba(0, 0, 0, 0.15);
        -o-box-shadow: 0 0 8px 4px rgba(0, 0, 0, 0.15);
        -webkit-box-shadow: 0 0 8px 4px rgba(0, 0, 0, 0.15);
        box-shadow: 0 0 8px 4px rgba(0, 0, 0, 0.15);
        padding: 4px;
        border-top-left-radius: 8px;
    }
    .mSideBar.active {
        right: 0px;
        opacity: 1;
    }
</style>

<div class="mSideBar" style="">
    <div id="sideBarClose" class="btn btn-xs btn-default btn-mini pull-right" style="margin-right:4px;">X</div>
    <div style="width:100%;border: 1px solid #ddd;padding: 1px;">Naslov</div>
</div>

<div id="blenda" class="blenda" style="display: none;">
    <img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader3.gif">
</div>

<div class="mContentHeader">
    <ol class="breadcrumb mjsBreadcrumb">
        <li><a href="<?= $pro20_url; ?>">Pro20</a></li>
        <li><a href="<?= $proplaniranje_url; ?>">Planiranje</a></li>
        <li class="active"><span id="periodInfo"><?= Datum::stamp2date($start) . " - " . Datum::stamp2date($kraj); ?></span></li>
        <li class="active">Planiranje procesa</li>
        <li class="pull-right">
            <button type="button" id="btnFilterForm" class="btn btn-info btn-xs" style="padding: 4px 10px;margin-top: -5px; margin-right: -12px;"><span class="glyphicon glyphicon-search"></span> Filter</button>
        </li>
    </ol>
</div>

<div id='filterForm' class="mjsPopover lefttop" style="display: none; width: 240px;">
    <div id="blenda" class="blenda" style="display:none;">
        <img class="blendaLoader" width="16" src="<?= $img_url ?>/loader.gif" />
    </div>
    <form class="form-horizontal" role="form" name="frmFilter" id="frmFilter">
        <div class="arrow"></div>
        <div class="mjsPopover-content">

            <div class="row ">
                <div class="col-sm-12">Period</div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <input type="text" name="start" class="form-control input-sm text-center" id="start" placeholder="Početak" value="<?= $start; ?>" readonly="readonly">
                </div>
                <div class="col-sm-6">
                    <input type="text" name="kraj" class="form-control input-sm text-center" id="kraj" placeholder="Završetak" value="<?= $kraj; ?>" readonly="readonly">
                </div>
            </div>

            <div class="row rowDistance">
                <div class="col-sm-12">Proces</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <select id="proces" name="proces" class="form-control input-sm" >
                        <option value='0'>Izbor procesa</option>
                        <?
                        foreach ($arrProces as $key => $o) {
                            ?>
                            <option value='<?= $o->sifra; ?>' <?= $proces == $o->sifra ? "selected='selected'" : ''; ?>><?= $o->naziv; ?></option>
                            <?
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row rowDistance">
                <div class="col-sm-12">Proizvod</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <select id="proizvodSel" name="proizvod" class="form-control input-sm" >
                        <option value='-1'>Izbor proizvoda</option>
                        <?
                        foreach ($arrProizvod as $key => $o) {
                            ?>
                            <option value='<?= $o->id; ?>' <?= $proizvod == $o->id ? "selected='selected'" : ''; ?>><?= $o->naziv; ?></option>
                            <?
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row rowDistance">
                <div class="col-sm-12">Lot</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" name="lot" class="form-control input-sm" id="lot" placeholder="Pojava lota" value="<?= $lot; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" style="margin-top:10px;">
                    <button type="button" id="btnFilter" class="btn btn-primary btn-sm pull-right"><span class="glyphicon glyphicon-search"></span></button>
                    <button type="button" class="btn btn-sm pull-left" id="btnFilterClose" title="Zatvori"><span class="glyphicon glyphicon-remove"></span></button>
                </div>
            </div>

        </div>
    </form>
</div>

<div class="mContentBody">

</div>

<script>

    (function ($) {

        $("#proizvodSel").select2();
        $("#kreirao").select2();
        $("#proces").select2();

        $('#btnFilterForm').mjsSearch({
            divForm: $("#filterForm"),
            btnClose: $("#btnFilterClose"),
            btnFind: $("#btnFilter"),
            onFind: function (e) {
                loader();
            }
        });

        var startDateTextBox = $('#start');
        var endDateTextBox = $('#kraj');

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

        loader();

        $(window).resize(function () {
            homeRowResize();
        });

        homeRowResize();

        $(document).on("click", "#sideBarClose", function () {
            $(".mSideBar").removeClass("active");
        });

        $(document).on("click", ".btnArtikalStatus", function () {
            var p = $(this).data("plan")
            var a = $(this).data("artikal")
            var i = $(this).data("row")

            $("#myModal").modal({'remote': '<?= "$proplaniranje_url/status/"; ?>' + i, backdrop: "static"});

        });

        $(document).on("click", ".btnArtikalInfo", function () {
            var i = $(this).data("row")
            ucitajSideBar(i)
        });


    })(jQuery);

    function loader() {

        $("#periodInfo").html($("#start").val() + " - " + $("#kraj").val());

        var o = $('.mContentBody');
        // var args = {};// $("#frmFilter").serialize();
        var args = $("#frmFilter").serialize();
        var b = $("#blenda");
        b.show();
        urlContent(o, "<?= "$proplaniranje_url/planiranje_procesa_pregled/"; ?>", args, function () {
            homeRowResize();
            b.hide();
        });
    }

    function ucitajDan(datum) {
        var o = $('*[data-datum="' + datum + '"]');
        // var args = $("#frmFilter").serialize();

        var arr = $("#frmFilter").serializeArray();
        arr = urlFormAddArgs(arr, 'start', datum);
        arr = urlFormAddArgs(arr, 'kraj', datum);
        var args = jQuery.param(arr);

        var b = $("#blenda");
        b.show();
        urlContent(o, "<?= "$proplaniranje_url/nadzor_pregled_dan/"; ?>", args, function () {
            b.hide();
        });
    }

    function ucitajSideBar(rowId) {
        $("#btnFilterClose").click();
        $(".mSideBar").addClass("active");

        var o = $(".mSideBar");
        var ht = '<div id="blendaBar" class="blenda" style="display: block;">';
        ht += '<img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader4.gif">';
        ht += '</div>';
        o.html(ht);
        if (!$(".mSideBar").hasClass("active"))
            $(".mSideBar").addClass("active");

        $.ajax({
            url: "<?= $proplaniranje_url; ?>/planiranje_procesa_nalog/" + rowId,
            type: "POST",
            data: {},
            success: function (data, textStatus, jqXHR) {
                o.html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    function homeRowResize() {
        var ot = $(".mFlexWrapper").offset();
        var top = ot === undefined ? 0 : ot.top;
        $(".mFlexWrapper").height($(window).height() - top - 20);

        var boxOffsetTop = $(".boxList").offset() === undefined ? 0 : $(".boxList").offset().top;

        var vh = $(window).height() - (parseFloat(boxOffsetTop) + 38);
        $(".boxList").css({"height": vh})

        var h = $(window).height() - $(".mContentBody").offset().top - 20;
        $(".mSideBar").height(h + 80);
    }

    function urlFormAddArgs(arr, key, value) {
        var values, index;
        values = arr;
        for (index = 0; index < values.length; ++index) {
            if (values[index].name == key) {
                values[index].value = value;
                break;
            }
        }
        if (index >= values.length) {
            values.push({name: key, value: value});
        }

        return values;
    }
</script>
