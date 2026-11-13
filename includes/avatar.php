<?php
/*
|--------------------------------------------------------------------------
| Sidebar profile photo (shows the user's photo, or a blank white-person
| avatar like Facebook when no photo is uploaded).
| Usage:  <?php require_once __DIR__ . '/../includes/avatar.php'; echo sidebar_avatar($conn); ?>
|--------------------------------------------------------------------------
*/
if (!function_exists('sidebar_avatar')) {
    function sidebar_avatar($conn, $href = 'profile.php') {
        $uid = (int)($_SESSION['user_id'] ?? 0);
        $pic = '';

        $res = mysqli_query($conn, "SELECT profile_picture FROM users WHERE user_id = $uid LIMIT 1");
        if ($res && ($r = mysqli_fetch_assoc($res))) {
            $pic = (string)($r['profile_picture'] ?? '');
        }

        $pic = basename($pic);
        $file = dirname(__DIR__) . '/uploads/profile_pictures/' . $pic;

        if ($pic !== '' && file_exists($file)) {
            $src = '../uploads/profile_pictures/' . rawurlencode($pic);
        } else {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">'
                 . '<rect width="100" height="100" fill="#b0b3b8"/>'
                 . '<circle cx="50" cy="38" r="17" fill="#ffffff"/>'
                 . '<path d="M15 100c0-22 15-37 35-37s35 15 35 37z" fill="#ffffff"/>'
                 . '</svg>';
            $src = 'data:image/svg+xml;utf8,' . rawurlencode($svg);
        }

        return '<a href="' . htmlspecialchars($href) . '" title="My Profile" '
             . 'style="padding:0;margin:0 auto 6px;background:none;display:block;width:fit-content;text-decoration:none;">'
             . '<img src="' . htmlspecialchars($src, ENT_QUOTES) . '" alt="Profile" '
             . 'style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid #fff;'
             . 'display:block;margin:auto;background:#b0b3b8;box-shadow:0 2px 8px rgba(0,0,0,.25);">'
             . '</a>';
    }
}

if (!function_exists('topbar_avatar')) {
    /* Round profile photo for the top bar (right side). Default = white person on gray. */
    function topbar_avatar($conn, $size = 44, $href = 'profile.php') {
        $uid = (int)($_SESSION['user_id'] ?? 0);
        $pic = '';
        $res = mysqli_query($conn, "SELECT profile_picture FROM users WHERE user_id = $uid LIMIT 1");
        if ($res && ($r = mysqli_fetch_assoc($res))) { $pic = basename((string)($r['profile_picture'] ?? '')); }
        $file = dirname(__DIR__) . '/uploads/profile_pictures/' . $pic;
        if ($pic !== '' && file_exists($file)) {
            $src = '../uploads/profile_pictures/' . rawurlencode($pic);
        } else {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">'
                 . '<rect width="100" height="100" fill="#b0b3b8"/>'
                 . '<circle cx="50" cy="38" r="17" fill="#ffffff"/>'
                 . '<path d="M15 100c0-22 15-37 35-37s35 15 35 37z" fill="#ffffff"/></svg>';
            $src = 'data:image/svg+xml;utf8,' . rawurlencode($svg);
        }
        $size = (int)$size;
        return '<a href="' . htmlspecialchars($href) . '" title="My Profile" style="display:inline-block;line-height:0;">'
             . '<img src="' . htmlspecialchars($src, ENT_QUOTES) . '" alt="Profile" '
             . 'style="width:' . $size . 'px;height:' . $size . 'px;border-radius:50%;object-fit:cover;'
             . 'border:2px solid #0A2E73;background:#b0b3b8;"></a>';
    }
}