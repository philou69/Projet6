"use strict";

$(document).ready(function () {
    var $admin = $("input[value='ROLE_ADMIN']");
    var $naturaliste = $("input[value='ROLE_NATURALISTE']");
    if ($admin.attr('checked') === 'checked') {
        $admin.removeAttr('checked');
        $admin.prop('checked', 'checked');
    }
    if ($naturaliste.attr('checked') === 'checked') {
        $naturaliste.removeAttr('checked');
        $naturaliste.prop('checked', 'checked');
    }

    $admin.on('click', function () {
        if ($admin.prop('checked') === true && $naturaliste.prop('checked') === false) {
            $naturaliste.prop('checked', 'checked');
        }
    });
    $naturaliste.on('click', function () {
        if ($admin.prop('checked') === true && $naturaliste.prop('checked') === false) {
            $admin.prop('checked', false);
        }
    });
});
//# sourceMappingURL=role.user.js.map