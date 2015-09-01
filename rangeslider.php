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

    public $min = 0;

    public $max = 100;

    public $step = 1;

    public $default = 0;

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

    public function option($key)
    {
        switch ($key) {

            case 'min':
                return $this->sanitizeNumber($this->{$key}, 1, false);

            case 'max':
                return $this->sanitizeNumber($this->{$key}, 100, false);

            case 'step':
            case 'default':
                return $this->sanitizeNumber($this->{$key}, 1, true);

            default:
                return $this->{$key};
        }
    }

    /**
     * Sanitize a number and maybe apply a default value.
     *
     * @since 1.0.0
     * @param mixed    $number
     * @param integer   $default
     * @param bool    $float
     * @return int|float
     */
    protected function sanitizeNumber($number, $default = 0, $float = false)
    {
        return is_numeric($number) ? (($float === true) ? floatval($number) : intval($number)) : $default;
    }

    /**
     * Sanitize a boolean value and maybe apply a default value.
     * 
     * @since 1.0.0
     * @param mixed    $bool
     * @param bool    $default
     * @return bool
     */
    protected function sanitizeBool($bool, $default = false)
    {
        if (is_bool($bool)) {
            return $bool;
        }

        switch ($bool) {

            case 'true':
            case 'yes':
            case 'on':
                return true;

            case 'false':
            case 'no':
            case 'off':
                return false;

            default:
                return $default;
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
            'min'   => $this->option('min'),
            'max'   => $this->option('max'),
            'step'  => $this->option('step'),
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

    public function value()
    {
        return (isset($this->value) and is_numeric($this->value)) ? $this->value : $this->$this->option('default');
    }

}
