/**
 * CSRF protection: sends the session token (from <meta name="csrf-token">)
 *  - as header X-CSRF-Token with every jQuery AJAX request
 *  - as hidden field _csrf in every POST form, including forms added later (modals)
 */
(function () {
    var meta = document.querySelector('meta[name="csrf-token"]');
    var token = meta ? meta.getAttribute('content') : '';
    if (!token) return;

    if (window.jQuery) {
        jQuery.ajaxSetup({ headers: { 'X-CSRF-Token': token } });
    }

    function tagForms() {
        var forms = document.querySelectorAll('form');
        for (var i = 0; i < forms.length; i++) {
            var f = forms[i];
            if ((f.getAttribute('method') || '').toLowerCase() !== 'post') continue;
            if (f.querySelector('input[name="_csrf"]')) continue;
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_csrf';
            input.value = token;
            f.appendChild(input);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        tagForms();
        new MutationObserver(tagForms).observe(document.body, { childList: true, subtree: true });
    });
})();
