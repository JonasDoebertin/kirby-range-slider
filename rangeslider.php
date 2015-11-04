<?php

/**
 * Range Slider Field for Kirby 2.
 *
 * @version   1.1.0
 *
 * @author    Jonas Döbertin <hello@jd-powered.net>
 * @copyright Jonas Döbertin <hello@jd-powered.net>
 *
 * @link      https://github.com/JonasDoebertin/kirby-range-slider
 *
 * @license   GNU GPL v3.0 <http://opensource.org/licenses/GPL-3.0>
 */

/**
 * Range Slider Field.
 *
 * @since 1.0.0
 */
class RangeSliderField extends InputField
{
    /**
     * Define backend assets.
     *
     * @since 1.0.0
     *
     * @var array
     */
    public static $assets = array(
        'css' => array(
            'nouislider-8.1.0.min.css',
            'rangeslider.css',
        ),
        'js' => array(
            'nouislider-8.1.0.min.js',
            'wnumb-1.0.2.min.js',
            'rangeslider.js',
        ),
    );

    /**
     * Minimum value.
     *
     * @since 1.0.0
     *
     * @var int|float
     */
    public $min = 0;

    /**
     * Maximum value.
     *
     * @since 1.0.0
     *
     * @var int|float
     */
    public $max = 100;

    /**
     * Step value.
     *
     * @since 1.0.0
     *
     * @var int|float
     */
    public $step = 1;

    /**
     * Default value.
     *
     * @since 1.0.0
     *
     * @var int|float
     */
    public $default = 0;

    /**
     * Value display prefix.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $prefix = '';

    /**
     * Value display postfix.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $postfix = '';

    /**
     * Get a sanitized option value.
     *
     * @since 1.0.0
     *
     * @param string $key
     *
     * @return mixed
     */
    public function option($key)
    {
        switch ($key) {

            case 'min':
                return $this->sanitizeNumber($this->{$key}, 1, true);

            case 'max':
                return $this->sanitizeNumber($this->{$key}, 100, true);

            case 'step':
            case 'default':
                return $this->sanitizeNumber($this->{$key}, 1, true);

            case 'disabled':
            case 'readonly':
                return $this->sanitizeBool($this->{$key}, false);

            default:
                return $this->{$key};
        }
    }

    /**
     * Sanitize a number and maybe apply a default value.
     *
     * @since 1.0.0
     *
     * @param mixed $number
     * @param int   $default
     * @param bool  $float
     *
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
     *
     * @param mixed $bool
     * @param bool  $default
     *
     * @return bool
     */
    protected function sanitizeBool($bool, $default = false)
    {
        switch ($bool) {

            case true:
            case 'true':
            case 'yes':
            case 'on':
                return true;

            case false:
            case 'false':
            case 'no':
            case 'off':
                return false;

            default:
                return $default;
        }
    }

    /**
     * Create input element.
     *
     * @since 1.0.0
     *
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
            'tabindex'     => '-1',
            'disabled'     => $this->option('disabled'),
            'readonly'     => $this->option('readonly'),
        ));

        $input->addClass('input-is-readonly');

        /* Set data attributes */
        $input->data(array(
            'field'   => 'rangesliderfield',
            'min'     => $this->option('min'),
            'max'     => $this->option('max'),
            'step'    => $this->option('step'),
            'prefix'  => $this->option('prefix'),
            'postfix' => $this->option('postfix'),
        ));

        return $input;
    }

    /**
     * Create outer field element.
     *
     * @since 1.0.0
     *
     * @return Brick
     */
    public function element()
    {
        $element = parent::element();
        $element->addClass('field-with-rangeslider');

        return $element;
    }

    /**
     * Create inner field element.
     *
     * @since 1.0.0
     *
     * @return Brick
     */
    public function content()
    {
        $content = Tpl::load(__DIR__ . DS . 'partials' . DS . 'content.php', array('field' => $this));

        return $content;
    }

    /**
     * Get the fields value.
     *
     * @since 1.0.0
     *
     * @return int|float
     */
    public function value()
    {
        return (isset($this->value) and is_numeric($this->value)) ? $this->value : $this->option('default');
    }
}
