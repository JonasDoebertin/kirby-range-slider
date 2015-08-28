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
class RangeSliderField extends InputField
{

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
            'wnumb-1.0.2.min.js',
            'rangeslider.js',
        ),
    );

    protected $step = 1;

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
     * Magic setter.
     *
     * Set a fields property and apply default value if required.
     *
     * @since 1.0.0
     *
     * @param string $option
     * @param mixed $value
     */
    public function __set($option, $value)
    {
        /* Set given value */
        $this->$option = $value;

        /* Check if value is valid */
        switch($option)
        {
            case 'step':
                $this->maybeSetStep($value);
                break;
        }
    }

    protected function maybeSetStep($value)
    {
        $this->step = is_numeric($value) ? floatval($value) : 1;
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
            'value'        => $this->value(),
            'required'     => $this->required(),
            'autocomplete' => 'off',
            'disabled'     => $this->disabled(),
            'readonly'     => $this->readonly(),
        ));

        /* Set previous content */

        /* Prepare for JS overlay */
        $input->attr('tabindex', '-1');
        $input->addClass('input-is-readonly');

        /* Set data attributes */
        $input->data(array(
            'field' => 'rangesliderfield',
            'step' => $this->step,
        ));

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

    /**
     * Create inner field element
     *
     * @since 1.0.0
     * @return Brick
     */
    public function content()
    {
        $content = Tpl::load(__DIR__ . DS . 'partials' . DS . 'content.php', array('field' => $this));

        return $content;
    }

}
