<?php 
function compress($buffer) {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

header('Content-type: text/css');

ob_start("compress");

include('core/normalize.css');
include('utils/animation.css');

include('lib/owl.carousel.min.css');
include('lib/owl.theme.default.min.css');

include('core/main.css');
include('core/table.css');

include('template/header.css');
include('template/footer.css');
include('template/nav.css');

include('layout/home.css');
include('layout/auth.css');
include('layout/company-list.css');
include('layout/register.css');
include('layout/faculty.css');
include('layout/profile.css');
include('layout/analytics.css');
include('template/chat.css');

include('admin/admin.css');

include('fonts/flaticon.css');
include('utils/vars.css');
include('utils/media.css');
include('utils/print.css');

ob_end_flush();
?>