;(function($, EhlElementDashboard) {
    'use strict';

    $(function() {

        var $tabsWrapper = $('.elh-el-dashboard-tabs'),
            $tabsNav = $tabsWrapper.find('.elh-el-dashboard-tabs__nav'),
            $tabsContent = $tabsWrapper.find('.elh-el-dashboard-tabs__content'),
            $sidebarMenuWrapper = $('#toplevel_page_ehlelement'),
            $sidebarSubmenu = $sidebarMenuWrapper.find('.wp-submenu');

        $tabsNav.on('click', '.elh-el-dashboard-tabs__nav-item', function(event) {
            var $currentTab = $(event.currentTarget),
                tabTargetHash = event.currentTarget.hash,
                tabIdSelector = '#tab-content-' + tabTargetHash.substring(1),
                $currentTabContent = $tabsContent.find(tabIdSelector);

                alert($currentTab);

            if ( $currentTab.is( '.nav-item-is--link' ) ) {
                return true;
            }

            event.preventDefault();

            $currentTab
                .addClass('tab--is-active')
                .siblings()
                .removeClass('tab--is-active');

            $currentTabContent
                .addClass('tab--is-active')
                .siblings()
                .removeClass('tab--is-active');

            window.location.hash = tabTargetHash;
            $sidebarSubmenu.find('a').filter(function(i, a) {
                return tabTargetHash === a.hash;
            }).parent().addClass('current').siblings().removeClass('current');
        });

        if (window.location.hash) {
            $tabsNav.find('a[href="'+window.location.hash+'"]').click();
            $sidebarSubmenu.find('a').filter(function(i, a) {
                return window.location.hash === a.hash;
            }).parent().addClass('current').siblings().removeClass('current');
        }

        $sidebarSubmenu.on('click', 'a', function(event) {
            if ( ! event.currentTarget.hash) {
                return true;
            }
            event.preventDefault();

            window.location.hash = event.currentTarget.hash;

            var $currentItem = $(event.currentTarget);
            $currentItem.parent().addClass('current').siblings().removeClass('current');

            $tabsNav.find('a[href="'+event.currentTarget.hash+'"]').click();
        });

        var $dashboardForm = $('#elh-el-dashboard-form'),
            $widgetsList = $dashboardForm.find('.elh-el-dashboard-widgets'),
            $saveButton = $dashboardForm.find('.elh-el-dashboard-btn--save');

        $dashboardForm.on('submit', function(event) {
            event.preventDefault();

            $.post({
                url: EhlElementDashboard.ajaxUrl,
                data: {
                    nonce: EhlElementDashboard.nonce,
                    action: EhlElementDashboard.action,
                    data: $dashboardForm.serialize()
                },
                beforeSend: function() {
                    $saveButton
                        .text('.....')
                        .css('animation', 'animateTextIndent infinite 2.5s');
                },
                success: function(response) {
                    if ( response.success ) {
                        var t = setTimeout(function () {
                            $saveButton
                                .css('animation', '')
                                .attr('disabled', true)
                                .text(EhlElementDashboard.savedLabel);
                            clearTimeout(t);
                        }, 500);
                    }
                }
            });
        });

        $dashboardForm.on('change', ':checkbox, :radio', function() {
            $saveButton.attr('disabled', false).text(EhlElementDashboard.saveChangesLabel);
        });

        $('.elh-el-action--btn').on('click', function(event) {
            event.preventDefault();

            var $currentAction = $(this),
                filter = $currentAction.data('filter'),
                action = $currentAction.data('action'),
                $all = $widgetsList.find('.elh-el-dashboard-widgets__item'),
                $free = $all.not('.item--is-pro'),
                $pro = $all.filter('.item--is-pro'),
                $toggle = $all.not('.item--is-placeholder').find(':checkbox');

            if ( filter ) {
                switch ( filter ) {
                    case 'free':
                        $free.show();
                        $pro.hide();
                        break;
                    case 'pro':
                        $free.hide();
                        $pro.show();
                        break;
                    case '*':
                    default:
                        $all.show();
                        break;
                }
            }

            if ( action ) {
                if ('enable' === action) {
                    $toggle.prop('checked', true);
                } else if ( 'disable' === action ) {
                    $toggle.prop('checked', false);
                }
                $toggle.trigger('change');
            }
        });


        $('.elh-el-feature-sub-title-a').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,

            fixedContentPos: false
        });

        $('.btn-how-to-contribute').on('click', function(event) {
            event.preventDefault();
            $(this).next().show();
        });
    });
}(jQuery, window.EhlElementDashboard));
