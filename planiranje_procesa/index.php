
<link href="<?= $public_url; ?>/css/mjsFlexPool.css" rel="stylesheet">
<style>
    .mFlexBox {
        min-width: 320px;
        max-width: 320px;
    }

    .mSideBar {
        position: fixed;
        top: 57px;
        width: 640px;
        right: -640px;
        height: 100%;
        z-index: 1000;
        background-color: #fff;
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

    .boxTitle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 8px;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        user-select: none;
        letter-spacing: 0.01em;
    }

    .btnLock {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.22);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 5px;
        cursor: pointer;
        width: 24px;
        height: 22px;
        font-size: 12px;
        line-height: 1;
        transition: background 0.15s, border-color 0.15s;
        flex-shrink: 0;
    }

    .btnLock:hover {
        background: rgba(0, 0, 0, 0.38);
        border-color: rgba(255, 255, 255, 0.35);
    }

    .mFlexBox.locked .ico-lock {
        color: #fbbf24;
        display: inline-block;
    }

    .mFlexBox.locked .ico-unlock {
        display: none;
    }

    .mFlexBox:not(.locked) .ico-lock {
        display: none;
    }

    .mFlexBox:not(.locked) .ico-unlock {
        color: rgba(255, 255, 255, 0.85);
        display: inline-block;
    }

    .mFlexBox.locked .processItem {
        pointer-events: none;
        opacity: 0.78;
    }

    .mFlexBox.locked .boxList {
        cursor: not-allowed;
    }

    ul.mUl {
        list-style: none;
        display: flex;
        justify-content: space-around;
        margin: 0px;
        padding: 0px;
    }

    ul.mUl > li {
        list-style-type: none;
        font-size: small;
    }

    ul.mUl > li:before {
        margin-right: 0.5em;
        width: 0.7em;
        height: 0.7em;
        display: inline-block;
        vertical-align: middle;
        border-radius: 50%;
        background-color: orange;
        content: ' ';
    }

    .boxList {
        overflow-y: auto;
        position: relative;
        background-color: #eef1f6;
    }

    .timeSlotRow {
        display: flex;
        align-items: stretch;
        min-height: 56px;
        border-bottom: 1px solid #e2e8f2;
        cursor: pointer;
        background-color: #f7f9fc;
    }

    .timeSlotRow:hover {
        background-color: #edf3ff;
    }

    .timeSlotHour {
        border-bottom: 2px solid #b8c8dc;
    }

    .timeLabel {
        width: 36px;
        flex-shrink: 0;
        font-size: 11px;
        font-weight: 600;
        color: #8fa8c4;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        line-height: 1;
    }

    .timeContent {
        flex: 1;
        min-height: 56px;
        border-left: 1px solid #e2e8f2;
        padding: 1px 2px;
    }

    .timeContent.drop-hover {
        background-color: #ecfdf5;
        border-left-color: #22c55e;
    }

    .processItem {
        position: absolute;
        left: 36px;
        right: 0;
        background: #ffffff;
        z-index: 10;
        overflow: hidden;
        box-sizing: border-box;
        border-left: 3px solid #1d6af5;
        border-radius: 4px;
        font-size: 11px;
        display: flex;
        align-items: center;
        color: #1e293b;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .processItem:hover {
        background: #f0f6ff;
        box-shadow: 0 2px 8px rgba(29, 106, 245, 0.15);
    }

    .resizeHandleTop,
    .resizeHandleBottom {
        position: absolute;
        left: 0;
        right: 0;
        height: 6px;
        cursor: ns-resize;
        z-index: 2;
        background: transparent;
    }

    .resizeHandleTop {
        top: 0;
    }

    .resizeHandleBottom {
        bottom: 0;
    }

    .processItem.resizing {
        background: #e8f0fe;
        box-shadow: 0 2px 12px rgba(29, 106, 245, 0.25);
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

    // select2, mjsSearch, datepicker ostaju jQuery — zahtijevaju plugin
    $("#proizvodSel").select2();
    $("#kreirao").select2();
    $("#proces").select2();

    $('#btnFilterForm').mjsSearch({
        divForm: $("#filterForm"),
        btnClose: $("#btnFilterClose"),
        btnFind: $("#btnFilter"),
        onFind: function (e) { loader(); }
    });

    $('#start').datepicker({
        changeMonth: true,
        changeYear: true,
        "option": $.datepicker.regional['rs'],
        onClose: function (selectedDate) {
            $('#kraj').datepicker("option", "minDate", selectedDate);
        }
    });

    $('#kraj').datepicker({
        changeMonth: true,
        changeYear: true,
        "option": $.datepicker.regional['rs'],
        onClose: function (selectedDate) {
            $('#start').datepicker("option", "maxDate", selectedDate);
        }
    });

    loader();
    homeRowResize();
    window.addEventListener('resize', homeRowResize);

    document.addEventListener('click', function (e) {
        if (e.target.closest('#sideBarClose')) {
            document.querySelector('.mSideBar').classList.remove('active');
        }

        var btnStatus = e.target.closest('.btnArtikalStatus');
        if (btnStatus) {
            $("#myModal").modal({ remote: '<?= "$proplaniranje_url/status/"; ?>' + btnStatus.dataset.row, backdrop: "static" });
        }

        var btnInfo = e.target.closest('.btnArtikalInfo');
        if (btnInfo) {
            ucitajSideBar(btnInfo.dataset.row);
        }

        var btnLock = e.target.closest('.btnLock');
        if (btnLock) {
            e.stopPropagation();
            btnLock.closest('.mFlexBox').classList.toggle('locked');
        }

        var slot = e.target.closest('.timeSlotRow');
        if (slot) {
            var ts = parseInt(slot.dataset.timestamp, 10);
            var d = new Date(ts * 1000);
            console.log('Dan: ' + String(d.getDate()).padStart(2, '0') + ' | Sat: ' + String(d.getHours()).padStart(2, '0') + ' | Minut: ' + String(d.getMinutes()).padStart(2, '0'));
        }
    });

    function loader() {
        document.getElementById('periodInfo').innerHTML =
            document.getElementById('start').value + " - " + document.getElementById('kraj').value;

        var args = new URLSearchParams(new FormData(document.getElementById('frmFilter'))).toString();
        var b = document.getElementById('blenda');
        b.style.display = 'block';
        urlContent($('.mContentBody'), "<?= "$proplaniranje_url/planiranje_procesa_pregled/"; ?>", args, function () {
            homeRowResize();
            initDragDrop();
            initResize();
            b.style.display = 'none';
        });
    }

    function ucitajDan(datum) {
        var o = document.querySelector('[data-datum="' + datum + '"]');
        var formData = new FormData(document.getElementById('frmFilter'));
        formData.set('start', datum);
        formData.set('kraj', datum);
        var args = new URLSearchParams(formData).toString();

        var b = document.getElementById('blenda');
        b.style.display = 'block';
        urlContent($(o), "<?= "$proplaniranje_url/nadzor_pregled_dan/"; ?>", args, function () {
            b.style.display = 'none';
        });
    }

    function ucitajSideBar(rowId) {
        document.getElementById('btnFilterClose').click();
        var sidebar = document.querySelector('.mSideBar');
        sidebar.classList.add('active');
        sidebar.innerHTML = '<div id="blendaBar" class="blenda" style="display: block;"><img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader4.gif"></div>';

        fetch("<?= $proplaniranje_url; ?>/planiranje_procesa_nalog/" + rowId, { method: 'POST' })
            .then(function (r) { return r.text(); })
            .then(function (data) { sidebar.innerHTML = data; });
    }

    function homeRowResize() {
        var wrapper = document.querySelector('.mFlexWrapper');
        if (wrapper) {
            wrapper.style.height = (window.innerHeight - wrapper.getBoundingClientRect().top - 20) + 'px';
        }

        var firstBoxList = document.querySelector('.boxList');
        var boxOffsetTop = firstBoxList ? firstBoxList.getBoundingClientRect().top : 0;
        var vh = window.innerHeight - (boxOffsetTop + 38);
        document.querySelectorAll('.boxList').forEach(function (el) {
            el.style.height = vh + 'px';
        });

        var contentBody = document.querySelector('.mContentBody');
        var sidebar = document.querySelector('.mSideBar');
        if (contentBody && sidebar) {
            sidebar.style.height = (window.innerHeight - contentBody.getBoundingClientRect().top - 20 + 80) + 'px';
        }
    }

    function initDragDrop() {
        $(".processItem").draggable({
            cancel: ".resizeHandleTop, .resizeHandleBottom",
            helper: "clone",
            revert: "invalid",
            zIndex: 1000,
            scroll: false,
            opacity: 0.75
        });

        $(".timeContent").droppable({
            accept: ".processItem",
            hoverClass: "drop-hover",
            drop: function (event, ui) {
                var item = ui.draggable.detach();
                item.css({ top: '', left: '', position: '' });
                $(this).append(item);
            }
        });
    }

    function buildSlotMap(list) {
        var map = [];
        list.querySelectorAll('.timeSlotRow').forEach(function (row) {
            map.push({ top: row.offsetTop, ts: parseInt(row.dataset.timestamp, 10) });
        });
        return map;
    }

    function pxToTimestamp(px, map) {
        for (var i = map.length - 1; i >= 0; i--) {
            if (px >= map[i].top) return map[i].ts;
        }
        return map.length ? map[0].ts : 0;
    }

    function updateItemTimes(item, map) {
        var top = parseInt(item.style.top, 10);
        item.setAttribute('data-start-time', pxToTimestamp(top, map));
        item.setAttribute('data-end-time', pxToTimestamp(top + item.offsetHeight, map));
    }

    var _resizeBottomHandler = null;
    var _resizeTopHandler = null;

    function initResize() {
        var slotH = 20;
        var slotVH = 56;

        if (!document.getElementById('ppSchedulerStyle')) {
            var styleEl = document.createElement('style');
            styleEl.id = 'ppSchedulerStyle';
            styleEl.textContent =
                '.timeSlotRow { min-height: ' + slotVH + 'px !important; height: ' + slotVH + 'px !important; }' +
                '.timeContent { min-height: ' + slotVH + 'px !important; height: ' + slotVH + 'px !important; }';
            document.head.appendChild(styleEl);
        }

        document.querySelectorAll('.boxList').forEach(function (list) {
            var cursor = 0;
            var map = buildSlotMap(list);

            list.querySelectorAll('.processItem').forEach(function (item) {
                if (item.dataset.resizeInit) {
                    cursor = parseInt(item.style.top, 10) + item.offsetHeight;
                    return;
                }

                var naturalH = item.offsetHeight;
                var h = Math.max(slotVH, Math.ceil(naturalH / slotH) * slotH);

                item.style.position = 'absolute';
                item.style.top = cursor + 'px';
                item.style.height = h + 'px';
                item.style.left = '36px';
                item.style.right = '0';
                item.style.width = '';

                item.insertAdjacentHTML('afterbegin', '<div class="resizeHandleTop"></div>');
                item.insertAdjacentHTML('beforeend', '<div class="resizeHandleBottom"></div>');
                item.dataset.resizeInit = '1';
                updateItemTimes(item, map);

                cursor += h;
            });
        });

        if (_resizeBottomHandler) document.removeEventListener('mousedown', _resizeBottomHandler);
        if (_resizeTopHandler) document.removeEventListener('mousedown', _resizeTopHandler);

        _resizeBottomHandler = function (e) {
            var handle = e.target.closest('.resizeHandleBottom');
            if (!handle) return;
            e.preventDefault();
            e.stopPropagation();

            var item = handle.closest('.processItem');
            var list = item.closest('.boxList');
            var startY = e.pageY;
            var startH = item.offsetHeight;
            var startTop = parseInt(item.style.top, 10);

            var maxBottom = list.scrollHeight;
            Array.from(list.querySelectorAll('.processItem')).forEach(function (other) {
                if (other === item) return;
                var t = parseInt(other.style.top, 10);
                if (t > startTop) maxBottom = Math.min(maxBottom, t);
            });
            var limit = maxBottom - startTop;

            item.classList.add('resizing');

            function onMoveBottom(e) {
                var dy = e.pageY - startY;
                var newH = Math.round(Math.max(slotH, startH + dy) / slotH) * slotH;
                item.style.height = Math.min(newH, limit) + 'px';
            }

            function onUpBottom() {
                document.removeEventListener('mousemove', onMoveBottom);
                document.removeEventListener('mouseup', onUpBottom);
                item.classList.remove('resizing');
                updateItemTimes(item, buildSlotMap(list));
            }

            document.addEventListener('mousemove', onMoveBottom);
            document.addEventListener('mouseup', onUpBottom);
        };

        _resizeTopHandler = function (e) {
            var handle = e.target.closest('.resizeHandleTop');
            if (!handle) return;
            e.preventDefault();
            e.stopPropagation();

            var item = handle.closest('.processItem');
            var list = item.closest('.boxList');
            var startY = e.pageY;
            var startTop = parseInt(item.style.top, 10);
            var startH = item.offsetHeight;
            var bottom = startTop + startH;

            var minTop = 0;
            Array.from(list.querySelectorAll('.processItem')).forEach(function (other) {
                if (other === item) return;
                var t = parseInt(other.style.top, 10);
                if (t < startTop) minTop = Math.max(minTop, t + other.offsetHeight);
            });

            item.classList.add('resizing');

            function onMoveTop(e) {
                var dy = e.pageY - startY;
                var rawH = bottom - (startTop + dy);
                var newH = Math.round(Math.max(slotH, rawH) / slotH) * slotH;
                var newTop = bottom - newH;

                if (newTop < minTop) {
                    newH = Math.floor((bottom - minTop) / slotH) * slotH;
                    if (newH < slotH) newH = slotH;
                    newTop = bottom - newH;
                }

                item.style.top = newTop + 'px';
                item.style.height = newH + 'px';
            }

            function onUpTop() {
                document.removeEventListener('mousemove', onMoveTop);
                document.removeEventListener('mouseup', onUpTop);
                item.classList.remove('resizing');
                updateItemTimes(item, buildSlotMap(list));
            }

            document.addEventListener('mousemove', onMoveTop);
            document.addEventListener('mouseup', onUpTop);
        };

        document.addEventListener('mousedown', _resizeBottomHandler);
        document.addEventListener('mousedown', _resizeTopHandler);
    }

</script>
