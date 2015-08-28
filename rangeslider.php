<?php
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
class RangeSliderField extends InputField {

    /**
     * Language files directory.
     *
     * @since 1.0.0
     * @var string
     */
    const LANG_DIR = 'languages';

    /**
     * Define frontend assets.
     *
     * @since 1.0.0
     * @var array
     */
    public static $assets = array(
        'css' => array(
            'nouislider-8.0.2.min.css',
            'rangeslider.css',
        ),
        'js' => array(
            'nouislider-8.0.2.min.js',
            'rangeslider.js',
        ),
    );

    /**
     * Translated strings.
     *
     * @since 1.0.0
     * @var array
     */
    protected $translation;

    /**
     * Field setup.
     *
     * (1) Load language files
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        /* (1) Load language files */
        $baseDir = __DIR__ . DS . self::LANG_DIR . DS;
        $lang    = panel()->language();
        if (file_exists($baseDir . $lang . '.php')) {
            $this->translation = include $baseDir . $lang . '.php';
        }
        else {
            $this->translation = include $baseDir . 'en.php';
        }
    }

    /**
     * Create input element
     *
     * @since 1.0.0
     * @return Brick
     */
    public function input()
    {
        $input = new Brick('input');

        /* Set general attributes */
        $input->attr(array(
            'type'         => 'text',
            'name'         => $this->name(),
            'id'           => $this->id(),
            'value'        => '',
            'required'     => $this->required(),
            'autocomplete' => 'off',
            'disabled'     => $this->disabled(),
            'readonly'     => $this->readonly(),
        ));

        /* Set previous content */

        /* Prepare for JS overlay */
        $input->attr('tabindex', '-1');
        $input->addClass('input-is-readonly');

        return $input;
    }

    /**
     * Create outer field element
     *
     * @since 1.0.0
     * @return Brick
     */
    public function element()
    {
        $element = parent::element();
        $element->addClass('field-with-rangeslider');

        return $element;
    }

}
