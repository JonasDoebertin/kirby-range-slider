/**
 * Range Slider Field for Kirby 2
 *
 * @version   1.1.0
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

    /* Cache jQuery objects */
    this.$field   = $field;
    this.$wrapper = $field.parent();
    this.$slider  = $field.siblings().find('.js-rangeslider-slider');
    this.$display = $field.siblings().find('.js-rangeslider-display');

    /* Cache DOM elements */
    this.slider = self.$slider.get(0);

    /* State & config */
    this.isActive = false;
    this.config = {
        min:     self.$field.data('min'),
        max:     self.$field.data('max'),
        step:    self.$field.data('step'),
        prefix:  self.$field.data('prefix') || '',
        postfix: self.$field.data('postfix') || ''
    };

    /**
     * Initialization.
     *
     * @since 1.0.0
     */
    this.init = function() {
        /* Initialize display width */
        self.initDisplayWidth();

        /* Initialize noUiSlider */
        self.initNoUiSlider();
    };

    /**
     * Initialize the displays min-width.
     *
     * @since 1.0.0
     */
    this.initDisplayWidth = function() {
        var testNumber = Math.floor(parseFloat(self.config.max)) + parseFloat(self.config.step),
            testText   = '' + self.config.prefix + testNumber + self.config.postfix,
            width;

        self.$display.text(testText);
        width = self.$display.outerWidth() + 10;

        self.$display.parent().css({
            minWidth: width + 'px',
            flex: '0 0 ' + width + 'px'
        });
    };

    /**
     * Initialize noUiSlider.
     *
     * @since 1.0.0
     */
    this.initNoUiSlider = function() {
        noUiSlider.create(self.slider, {
            start: self.$field.val(),
            range: {
                min: self.config.min,
                max: self.config.max
            },
            step: self.config.step,
            connect: 'lower',
            format: wNumb({
                decimals: self.calculateDecimals(),
                mark: '.',
                prefix: self.config.prefix,
                postfix: self.config.postfix
            })
        });

        /* Bind slider change handler */
        self.slider.noUiSlider.on('update', function(values, handle, unencoded) {
            self.$field.val(unencoded);
            self.$display.text(values[handle]);
        });

        /* Enable active state on interaction */
        self.$slider.find('.noUi-handle').on('mousedown', self.setActiveState);
        self.slider.noUiSlider.on('slide', self.setActiveState);

        /* disable active state */
        self.slider.noUiSlider.on('change', self.unsetActiveState);
    };

    /**
     * Calculate the number of decimals based on the `step` setting.
     *
     * @since 1.0.0
     * @return integer
     */
    this.calculateDecimals = function() {
        if (self.config.step % 1 === 0) {
            return 0;
        }
        else {
            return self.config.step.toString().split('.')[1].length;
        }
    };

    /**
     * Enable the active state.
     *
     * @since 1.0.0
     */
    this.setActiveState = function() {
        if (self.isActive === false) {
            self.isActive = true;
            self.attachActiveStateStyles();
        }
    };

    /**
     * Disable the active state.
     *
     * @since 1.0.0
     */
    this.unsetActiveState = function() {
        if (self.isActive === true) {
            self.isActive = false;
            self.detachActiveStateStyles();
        }
    };

    /**
     * Attach active state indicator class.
     *
     * @since 1.0.0
     */
    this.attachActiveStateStyles = function() {
        self.$wrapper.addClass('rangeslider-active');
    };

    /**
     * Detach active state indicator class.
     *
     * @since 1.0.0
     */
    this.detachActiveStateStyles = function() {
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
