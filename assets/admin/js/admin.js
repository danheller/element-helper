(function($) {
    $(function() {
        var $clearCache = $('.ehlelementjs-clear-cache'),
            $haMenu = $('#toplevel_page_ehlelement .toplevel_page_ehlelement .wp-menu-name'),
            menuText = $haMenu.text();

        $haMenu.text(menuText.replace(/\s/, ''));

        $clearCache.on('click', 'a', function(e) {
            e.preventDefault();

            var type = 'all',
                $m = $(e.delegateTarget);

            if ($m.hasClass('elh-el-clear-page-cache')) {
                type = 'page';
            }

            $m.addClass('elh-el-clear-cache--init');

            $.post(
                EhlElementAdmin.ajax_url,
                {
                    action: 'elh_element_clear_cache',
                    type: type,
                    nonce: EhlElementAdmin.nonce,
                    post_id: EhlElementAdmin.post_id
                }
            ).done(function(res) {
                $m.removeClass('elh-el-clear-cache--init').addClass('elh-el-clear-cache--done');
            });
        });
    })
}(jQuery));
