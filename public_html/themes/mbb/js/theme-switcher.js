/*----------------------------------------------------*/
/*	Theme Switcher
/*----------------------------------------------------*/
var ThemeSwitcher = function () {
    return {        
       initThemeSwitcher: function() {    
            var panel = jQuery('.theme-switcher');

            jQuery('.theme-switcher-icon').click(function () {
                jQuery('.theme-switcher').show();
            });

            jQuery('.theme-close').click(function () {
                jQuery('.theme-switcher').hide();
            });
            
            jQuery('li', panel).click(function () {
                var color = jQuery(this).attr("data-style");
                $.cookie('theme', color, { path: '/' });
                var data_header = jQuery(this).attr("data-header");
                setColor(color, data_header);
                jQuery('.list-unstyled li', panel).removeClass("theme-active");
                jQuery(this).addClass("theme-active");
            });

            var setColor = function (color, data_header) {
            	var url = $("link[href*='_theme']").attr("href");
                var theme_url = url.substring(0, url.indexOf(url.substring(url.lastIndexOf("/") + 1)));
            	$("link[href*='_theme']").attr("href", theme_url + color + "_theme.css");
            	var img_src = jQuery('#brand-logo').attr("src");
            	var logo_url = img_src.substring(0, img_src.indexOf(img_src.substring(img_src.lastIndexOf("/") + 1)));
            	jQuery('#brand-logo').attr("src", logo_url + color + "_logo.png");
            }
        }        
    };
}();