/**
 * Coatstrap template script (behaviour only: every look comes from Bootstrap classes).
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
    var spinner = '<div class="text-center py-3"><div class="spinner-border text-secondary" role="status"><span class="visually-hidden">' + (L.loading || 'Loading...') + '</span></div></div>';
    var page = function () { return document.body.getAttribute('data-pag') || ''; };

    /* ---------------- theme (light / dark, Bootstrap data-bs-theme) ---------------- */
    function currentTheme() { return document.documentElement.getAttribute('data-bs-theme') || 'light'; }
    function setTheme(t) {
        document.documentElement.setAttribute('data-bs-theme', t);
        store.set('cs-theme', t);
        $('[data-cs-theme-toggle] i').attr('class', t === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon');
    }

    /* ---------------- toasts ---------------- */
    var TOAST_ICONS = { success: 'circle-check', info: 'circle-info', warning: 'triangle-exclamation', danger: 'circle-exclamation' };
    window.appToast = function (msg, type, delay) {
        type = type || 'success';
        var box = document.getElementById('csToasts');
        if (!box || !msg) return;
        var dark = type === 'warning' || type === 'info' || type === 'light';
        var el = document.createElement('div');
        el.className = 'toast align-items-center border-0 shadow text-bg-' + type;
        el.setAttribute('role', 'status');
        el.setAttribute('aria-live', 'polite');
        el.innerHTML = '<div class="d-flex"><div class="toast-body"><i class="fa-solid fa-' + (TOAST_ICONS[type] || 'circle-info') +
            ' me-2"></i><span></span></div><button type="button" class="btn-close' + (dark ? '' : ' btn-close-white') +
            ' me-2 m-auto" data-bs-dismiss="toast" aria-label="' + (L.close || 'Close') + '"></button></div>';
        el.querySelector('span').textContent = msg;
        box.appendChild(el);
        var t = bootstrap.Toast.getOrCreateInstance(el, { delay: delay || 4000 });
        el.addEventListener('hidden.bs.toast', function () { el.remove(); });
        t.show();
    };
    // success / info alerts printed by the pages become toasts; errors stay inline
    function alertsToToasts(root) {
        $(root).find('.alert.alert-success, .alert.alert-info').each(function () {
            if ($(this).closest('.modal, #contextMenu, [data-cs-keep-alerts]').length) return;
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
    window.csInitWidgets = initWidgets;

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
    // #contextMenu starts with Bootstrap's d-none; after that it is shown / hidden with jQuery,
    // because fieldtypes call $('#contextMenu').hide() themselves.
    function hideContextMenu() { $('#contextMenu').hide(); }
    window.salveaza = function () {
        var sid = $('#ajaxid').val(), sfld = $('#ajaxfield').val();
        $.post('ajax/modal.php?p=mdoedit-' + page(), { id: sid, field: sfld, item: $('#ajaxitem').val() }, function (msg) {
            $('.cell[alt="' + sfld + '-' + sid + '"]').html(msg);
            hideContextMenu();
            appToast(L.saved || 'Saved', 'success', 2000);
        }).fail(function () { appToast(L.save_failed || 'Save failed', 'danger'); });
    };
    window.checkAll = function (x) { $('.chboxoper').prop('checked', x == 1 || x === true); };

    function initContextMenu() {
        $('body').on('contextmenu', '.cell', function (e) {
            var cm = $('#contextMenu');
            cm.find('.panel-info').text((L.editing_field || 'Edit') + ' ' + ($(this).attr('title') || ''));
            cm.find('.panel-data').html(spinner);
            cm.find('.panel-submit').addClass('d-none');
            // the popup follows the mouse, so its place can only be set at runtime
            var w = Math.min(420, $(window).width() * 0.92);
            var x = Math.min(e.clientX, $(window).width() - w - 10);
            var y = Math.min(e.clientY, $(window).height() - 260);
            cm.removeClass('d-none').css({ display: 'block', left: Math.max(10, x), top: Math.max(10, y), width: w });
            $.ajax({ url: 'ajax/modal.php?p=medit-' + page() + '-' + $(this).attr('alt') }).done(function (msg) {
                cm.find('.panel-submit').removeClass('d-none');
                cm.find('.panel-data').html(msg);
                initWidgets(cm);
            });
            return false;
        });
        $('#contextMenu').on('click', '[data-cs-close]', hideContextMenu);
        $(document).on('keydown', function (e) { if (e.key === 'Escape') hideContextMenu(); });
    }

    /* ---------------- sidebar ---------------- */
    function initSidebar() {
        // chevron of the open / closed submenus (only the collapse that fired, not its parents)
        $('#csSidebar').on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            if (e.target !== this) return;
            var open = e.type === 'show';
            $('[href="#' + this.id + '"] [data-cs-caret]')
                .toggleClass('fa-chevron-down', open).toggleClass('fa-chevron-right', !open);
        });
    }

    /* ---------------- clock ---------------- */
    function initClock() {
        var el = document.getElementById('clock');
        if (!el) return;
        var tick = function () { $.ajax({ url: 'ajax/time.php' }).done(function (msg) { el.innerHTML = msg; }); };
        tick();
        setInterval(tick, 15000);
    }

    $(function () {
        setTheme(currentTheme());
        $('[data-cs-theme-toggle]').on('click', function () { setTheme(currentTheme() === 'dark' ? 'light' : 'dark'); });
        initSidebar();
        initClock();
        initContextMenu();
        initWidgets(document.body);
        // images of the public pages (login__pages content) scale with the card
        $('body:not(:has(#csSidebar)) #csContent img').addClass('img-fluid');
        alertsToToasts('#csContent');
    });
})(jQuery);
