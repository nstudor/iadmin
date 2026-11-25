/**
 * Bootstrap 4 -> 5 data attribute compatibility.
 * Shared markup (fieldtypes, ajax dialogs, settings pages) uses data-toggle / data-target /
 * data-dismiss; Bootstrap 5 only reacts to data-bs-*. Copy them before the user can click:
 * once on load and again for every element added later (modal bodies loaded by AJAX).
 */
(function () {
    var ATTRS = ['toggle', 'target', 'dismiss', 'parent', 'placement', 'content', 'trigger', 'offset', 'ride', 'slide', 'spy'];
    var SELECTOR = ATTRS.map(function (a) { return '[data-' + a + ']'; }).join(',');

    function upgrade(el) {
        for (var i = 0; i < ATTRS.length; i++) {
            var a = ATTRS[i];
            if (el.hasAttribute('data-' + a) && !el.hasAttribute('data-bs-' + a)) {
                var v = el.getAttribute('data-' + a);
                // BS4 dropdowns inside our sidebar submenus are handled by our own JS
                if (a === 'toggle' && v === 'dropdown' && el.closest('.dropdown-submenu')) continue;
                el.setAttribute('data-bs-' + a, v);
            }
        }
        // old ".close" buttons inside modals
        if (el.classList && el.classList.contains('close') && el.getAttribute('data-bs-dismiss')) {
            el.classList.add('btn-close');
            el.innerHTML = '';
        }
    }

    function scan(root) {
        if (!root || !root.querySelectorAll) return;
        if (root.matches && root.matches(SELECTOR)) upgrade(root);
        var list = root.querySelectorAll(SELECTOR);
        for (var i = 0; i < list.length; i++) upgrade(list[i]);
    }

    scan(document.documentElement);
    document.addEventListener('DOMContentLoaded', function () {
        scan(document.body);
        new MutationObserver(function (mutations) {
            mutations.forEach(function (m) {
                m.addedNodes.forEach(function (n) { if (n.nodeType === 1) scan(n); });
            });
        }).observe(document.body, { childList: true, subtree: true });
    });
})();
