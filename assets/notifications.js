/* Bell notifications for admin, HR and faculty.
   Needs: #notifBell, #notifBadge, #notifDropdown on the page.
   Optional: window.notifLink(type) -> page to open when a notification is tapped. */
(function () {
    var unread = 0;
    function esc(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
    function badge() { return document.getElementById('notifBadge'); }

    function setBadge(n) {
        unread = Math.max(0, n);
        var b = badge();
        if (!b) return;
        if (unread > 0) { b.style.display = 'inline-block'; b.textContent = unread > 9 ? '9+' : unread; }
        else { b.style.display = 'none'; }
    }

    function load() {
        fetch('../notifications_ajax.php?t=' + Date.now(), { cache: 'no-store' })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                setBadge(data.unread_count || 0);
                var dd = document.getElementById('notifDropdown');
                if (!dd) return;
                if (!data.notifications || !data.notifications.length) {
                    dd.innerHTML = '<div class="p-3 text-center text-muted">No notifications yet.</div>';
                    return;
                }
                var head = '<div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-white" style="position:sticky;top:0;">' +
                    '<strong style="font-size:13px;">Notifications</strong>' +
                    '<a href="#" style="font-size:12px;" data-all="1">Mark all as read</a></div>';
                dd.innerHTML = head + data.notifications.map(function (n) {
                    return '<a href="#" class="dropdown-item ' + (n.is_read ? '' : 'bg-light fw-semibold') + ' py-2 border-bottom" data-id="' + n.id + '" data-type="' + esc(n.type) + '" data-read="' + (n.is_read ? 1 : 0) + '">' +
                        '<div style="font-size:13px;white-space:normal;">' + esc(n.message) + '</div>' +
                        '<small class="text-muted">' + esc(n.time) + '</small></a>';
                }).join('');
            })
            .catch(function () {});
    }

    function mark(url) { return fetch(url + (url.indexOf('?') > -1 ? '&' : '?') + 't=' + Date.now(), { cache: 'no-store' }); }

    document.addEventListener('click', function (e) {
        var dd = document.getElementById('notifDropdown');
        if (!dd || !dd.contains(e.target)) return;
        var a = e.target.closest('a');
        if (!a) return;
        e.preventDefault();

        if (a.getAttribute('data-all')) {
            setBadge(0);
            dd.querySelectorAll('[data-id]').forEach(function (x) { x.classList.remove('bg-light', 'fw-semibold'); x.setAttribute('data-read', 1); });
            mark('../mark_notifications_read.php').then(load);
            return;
        }

        var id = a.getAttribute('data-id');
        if (!id) return;
        if (a.getAttribute('data-read') !== '1') {
            setBadge(unread - 1);            // badge goes down immediately
            a.classList.remove('bg-light', 'fw-semibold');
            a.setAttribute('data-read', 1);
        }
        var link = (typeof window.notifLink === 'function') ? window.notifLink(a.getAttribute('data-type')) : '';
        mark('../mark_notifications_read.php?id=' + id).then(function () {
            if (link) { window.location.href = link; } else { load(); }
        }).catch(function () { if (link) window.location.href = link; });
    });

    var bell = document.getElementById('notifBell');
    if (bell) bell.addEventListener('click', load);
    load();
    setInterval(load, 30000);
})();