/**
 * Client side helpers for field types (shared by all templates).
 *
 * awesomecase "toggle": a click on an icon with class .ac-toggle saves the next value through
 * ajax/modal.php?p=mdoedit-<module> (rights + CSRF checked by the server, token sent by js/csrf.js)
 * and replaces the icon with the HTML the server returns.
 */
(function ($) {
    'use strict';
    if (!$) return;

    $(document).on('click', '.ac-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var el = $(this);
        if (el.data('busy')) return;
        el.data('busy', 1).css('opacity', .5);
        $.post('ajax/modal.php?p=mdoedit-' + encodeURIComponent(el.data('pag')), {
            id: el.data('id'),
            field: el.data('field'),
            item: el.data('next')
        }).done(function (html) {
            el.replaceWith(html);
            if (typeof window.appToast === 'function') window.appToast('Saved', 'success', 1500);
        }).fail(function (xhr) {
            el.data('busy', 0).css('opacity', 1).attr('title', 'Not saved (' + (xhr.status || 'error') + ')');
            if (typeof window.appToast === 'function') window.appToast('Not saved', 'danger');
        });
    });
})(window.jQuery);
