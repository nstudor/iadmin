/**
 * Arachnania template script.
 * Also provides the globals that shared code (fieldtypes, ajax dialogs) relies on:
 * goModal(), postModal(), salveaza(), checkAll(), #filterModal, #contextMenu.
 */
(function ($) {
    'use strict';
    var L = window.APP_LNG || {}; // texts from lang/*.lng.php (index.tpl.php)

    var store = {
        get: function (k) { try { return localStorage.getItem(k); } catch (e) { return null; } },
        set: function (k, v) { try { localStorage.setItem(k, v); } catch (e) { } }
    };
    var spinner = '<div class="text-center py-3"><i class="fa fa-spinner fa-pulse fa-2x"></i></div>';
    var page = function () { return document.body.getAttribute('data-pag') || ''; };

    /* ---------------- theme (light / dark) ---------------- */
    function currentTheme() { return document.documentElement.getAttribute('data-bs-theme') || 'light'; }
    function setTheme(t) {
        document.documentElement.setAttribute('data-bs-theme', t);
        store.set('ar-theme', t);
        $('[data-ar-theme-toggle] i').attr('class', t === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon');
    }

    /* ---------------- toasts ---------------- */
    var TOAST_ICONS = { success: 'circle-check', info: 'circle-info', warning: 'triangle-exclamation', danger: 'circle-exclamation' };
    window.appToast = function (msg, type, delay) {
        type = type || 'success';
        var box = document.getElementById('arToasts');
        if (!box || !msg) return;
        var el = document.createElement('div');
        el.className = 'toast align-items-center border-0 text-bg-' + type;
        el.setAttribute('role', 'status');
        el.setAttribute('aria-live', 'polite');
        el.innerHTML = '<div class="d-flex"><div class="toast-body"><i class="fa-solid fa-' + (TOAST_ICONS[type] || 'circle-info') +
            ' me-2"></i><span></span></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="' + (L.close || 'Close') + '"></button></div>';
        el.querySelector('span').textContent = msg;
        box.appendChild(el);
        var t = bootstrap.Toast.getOrCreateInstance(el, { delay: delay || 4000 });
        el.addEventListener('hidden.bs.toast', function () { el.remove(); });
        t.show();
    };
    // success / info alerts printed by the pages become toasts; errors stay inline
    function alertsToToasts(root) {
        $(root).find('.alert.alert-success, .alert.alert-info').each(function () {
            if ($(this).closest('.modal, #contextMenu, .ar-keep-alerts').length) return;
            var text = $.trim($(this).text());
            if (!text) return;
            appToast(text, $(this).hasClass('alert-success') ? 'success' : 'info');
            $(this).remove();
        });
    }

    /* ---------------- widgets inside loaded HTML ---------------- */
    function initWidgets(root) {
        if ($.fn.colorpicker) {
            $(root).find('.color-selector').each(function () {
                if (!$(this).data('colorpicker')) $(this).colorpicker();
            });
        }
    }
    window.arInitWidgets = initWidgets;

    /* ---------------- modal helpers used by shared code ---------------- */
    function prepareModal(t, s) {
        $('#filterModalTitle').html(t);
        var dlg = $('#filterModal .modal-dialog').removeClass('modal-lg modal-sm modal-xl');
        if (s) dlg.addClass('modal-' + s);
        $('#filterModal .modal-body').html(spinner);
    }
    function fillModal(msg) {
        var body = $('#filterModal .modal-body').html(msg);
        initWidgets(body);
    }
    window.goModal = function (l, t, s) {
        prepareModal(t, s);
        $.ajax({ url: 'ajax/modal.php?p=' + l }).done(fillModal).fail(function (x) { fillModal(x.responseText || L.error || 'Error'); });
    };
    window.postModal = function (l, t, p, s) {
        prepareModal(t, s);
        $.post('ajax/modal.php?p=' + l, p).done(fillModal).fail(function (x) { fillModal(x.responseText || L.error || 'Error'); });
    };

    /* ---------------- inline cell edit (right click) ---------------- */
    window.salveaza = function () {
        var sid = $('#ajaxid').val(), sfld = $('#ajaxfield').val();
        $.post('ajax/modal.php?p=mdoedit-' + page(), { id: sid, field: sfld, item: $('#ajaxitem').val() }, function (msg) {
            $('.cell[alt="' + sfld + '-' + sid + '"]').html(msg);
            $('#contextMenu').hide();
            appToast(L.saved || 'Saved', 'success', 2000);
        }).fail(function () { appToast(L.save_failed || 'Save failed', 'danger'); });
    };
    window.checkAll = function (x) { $('.chboxoper').prop('checked', x == 1 || x === true); };

    function initContextMenu() {
        $('body').on('contextmenu', '.cell', function (e) {
            var cm = $('#contextMenu');
            cm.find('.panel-info').text((L.editing_field || 'Edit') + ' ' + ($(this).attr('title') || ''));
            cm.find('.panel-data').html(spinner);
            cm.find('.panel-submit').hide();
            var w = Math.min(420, $(window).width() * 0.92);
            var x = Math.min(e.clientX, $(window).width() - w - 10);
            var y = Math.min(e.clientY, $(window).height() - 260);
            cm.css({ display: 'block', left: Math.max(10, x), top: Math.max(10, y), width: w });
            $.ajax({ url: 'ajax/modal.php?p=medit-' + page() + '-' + $(this).attr('alt') }).done(function (msg) {
                cm.find('.panel-submit').show();
                cm.find('.panel-data').html(msg);
                initWidgets(cm);
            });
            return false;
        });
        $('#contextMenu').on('click', '[data-ar-close]', function () { $('#contextMenu').hide(); });
        $(document).on('keydown', function (e) { if (e.key === 'Escape') $('#contextMenu').hide(); });
    }

    /* ---------------- sidebar ---------------- */
    function initSidebar() {
        var desktop = window.matchMedia('(min-width: 992px)');
        if (store.get('ar-sidebar') === 'collapsed') document.body.classList.add('ar-collapsed');
        $('[data-ar-sidebar-toggle]').on('click', function () {
            if (desktop.matches) {
                document.body.classList.toggle('ar-collapsed');
                store.set('ar-sidebar', document.body.classList.contains('ar-collapsed') ? 'collapsed' : 'open');
            } else {
                document.body.classList.toggle('ar-sidebar-open');
            }
        });
        $('.ar-backdrop').on('click', function () { document.body.classList.remove('ar-sidebar-open'); });
    }

    /* ---------------- clock ---------------- */
    function initClock() {
        var el = document.getElementById('clock');
        if (!el) return;
        var tick = function () { $.ajax({ url: 'ajax/time.php' }).done(function (msg) { el.innerHTML = msg; }); };
        tick();
        setInterval(tick, 15000);
    }

    /* ---------------- sticky 2-row list header ---------------- */
    function initStickyHeads() {
        var fix = function () {
            $('.ar-table').each(function () {
                var first = $(this).find('thead tr:first-child');
                if (first.length) this.style.setProperty('--ar-thead-h', first.outerHeight() + 'px');
            });
        };
        fix();
        $(window).on('resize', fix);
    }

    $(function () {
        setTheme(currentTheme());
        $('[data-ar-theme-toggle]').on('click', function () { setTheme(currentTheme() === 'dark' ? 'light' : 'dark'); });
        initSidebar();
        initClock();
        initContextMenu();
        initStickyHeads();
        initWidgets(document.body);
        alertsToToasts('#arContent');
    });
})(jQuery);
