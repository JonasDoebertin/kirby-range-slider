/**
 * Range Slider Field for Kirby 2
 *
 * @version   1.0.0-dev
 * @author    Jonas Döbertin <hello@jd-powered.net>
 * @copyright Jonas Döbertin <hello@jd-powered.net>
 * @link      https://github.com/JonasDoebertin/kirby-range-slider
 * @license   GNU GPL v3.0 <http://opensource.org/licenses/GPL-3.0>
 */

/**
 * Range Slider Field
 *
 * @since 1.0.0
 */
var RangeSliderField = function($, $field) {
    'use strict';

    var self = this;

    this.$field   = $field;
    this.$wrapper = $field.parent();
    this.$slider  = $field.siblings().find('.js-rangeslider-slider');
    this.$display = $field.siblings().find('.js-rangeslider-display');

    // this.$tooltips = [];

    this.slider = self.$slider.get(0);

    this.isActive = false;

    this.init = function() {
        var step,
            decimals;

        /* Calculate number of decimal units */
        step = self.$field.data('step');
        if (step % 1 === 0) {
            decimals = 0;
        }
        else {
            decimals = step.toString().split('.')[1].length;
        }

        /* Initialize noUiSlider */
        noUiSlider.create(self.slider, {
            start: self.$field.val(),
            range: {
                min: self.$field.data('min'),
                max: self.$field.data('max')
            },
            step: self.$field.data('step'),
            connect: 'lower',
            format: wNumb({
                decimals: decimals,
                mark: '.'
            })
        });

        /* Bind slider change handler */
        self.slider.noUiSlider.on('update', function(values, handle) {
            self.$field.val(values[handle]);
            self.$display.text(values[handle]);
        });

        /* Bind "active" style handlers */
        self.slider.noUiSlider.on('slide', function(values, handle) {
            if (self.isActive === false) {
                self.isActive = true;
                self.attachActiveState();
            }
        });
        self.slider.noUiSlider.on('change', function(values, handle) {
            if (self.isActive === true) {
                self.isActive = false;
                self.detachActiveState();
            }
        });
    };

    this.attachActiveState = function() {
        self.$wrapper.addClass('rangeslider-active');
    };

    this.detachActiveState = function() {
        self.$wrapper.removeClass('rangeslider-active');
    };

    return this.init();

};

/**
 * Hook into panel initialization.
 *
 * @since 1.0.0
 */
(function($) {
    'use strict';

    /**
     * Set up special "destroyed" event.
     *
     * @since 1.0.0
     */
    // $.event.special.destroyed = {
    //     remove: function(event) {
    //         if(event.handler) {
    //             event.handler.apply(this, arguments);
    //         }
    //     }
    // };

    /**
     * Tell the Panel to run our initialization.
     *
     * This callback will fire for every Range Slider Field
     * on the current panel page.
     *
     * @see https://github.com/getkirby/panel/issues/228#issuecomment-58379016
     * @since 1.0.0
     */
    $.fn.rangesliderfield = function() {
        return new RangeSliderField($, this);
    };

})(jQuery);
