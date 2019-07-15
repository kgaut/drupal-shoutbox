/**
 * @file
 * Placeholder file for custom sub-theme behaviors.
 *
 */
(function ($, Drupal) {

    /**
     * Use this behavior as a template for custom Javascript.
     */
    Drupal.behaviors.shoutbox = {
        attach: function (context, settings) {
            $('.js-load-shouts').once('shoutbox').click(function (e) {
                e.preventDefault();
                var link = e.target;
                var shoutbox = parseInt($(link).attr('data-shoutbox'));
                var range = parseInt($(link).attr('data-range'));
                var offset = parseInt($(link).attr('data-offset'));

                $.ajax('/shouts/' + shoutbox + '/load/' + range + '/' + offset).done(function (data) {
                    if(data.has_mode_shouts) {
                        $(link).attr('data-offset', offset + range);
                    }
                    else {
                        $(link).remove();
                    }
                    if(data.shouts.length > 0) {
                        var $shoutsWrapper = $('.js-shoutbox-' + shoutbox + ' .js-shouts-wrapper');
                        $(data.shouts).each(function (id, shout) {
                            $shoutsWrapper.append(shout);
                        });
                    }
                });
            });
        }
    };

})(jQuery, Drupal);
