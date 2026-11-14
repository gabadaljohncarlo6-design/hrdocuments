/* Adds a show/hide (eye) button to every <input type="password"> on the page. */
(function () {
    var EYE = '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    var EYE_OFF = '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';

    function addToggle(input) {
        if (input.dataset.pwToggle) return;
        input.dataset.pwToggle = "1";

        var wrap = document.createElement('div');
        wrap.style.position = 'relative';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        input.style.setProperty('padding-right', '2.6rem', 'important');

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Show password');
        btn.title = 'Show password';
        btn.innerHTML = EYE;
        btn.style.cssText = 'position:absolute;top:0;right:0;height:100%;width:2.6rem;' +
            'display:flex;align-items:center;justify-content:center;' +
            'border:none;background:none;padding:0;color:#6c757d;cursor:pointer;';
        btn.addEventListener('mouseenter', function () { btn.style.color = '#0A2E73'; });
        btn.addEventListener('mouseleave', function () { btn.style.color = '#6c757d'; });

        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.innerHTML = show ? EYE_OFF : EYE;
            var label = show ? 'Hide password' : 'Show password';
            btn.setAttribute('aria-label', label);
            btn.title = label;
            input.focus();
        });

        wrap.appendChild(btn);
    }

    function init() {
        document.querySelectorAll('input[type="password"]').forEach(addToggle);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();