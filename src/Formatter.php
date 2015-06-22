<?php
namespace Litipk\BigNumbers;

class Formatter
{
    /**
     * Number of decimal places to round to in formatted output. Resulting 
     * decimal portion will be zero-padded if $this->padDecimal is true
     */
    private $scale = null;

    /**
     * If true, decimal component will be padded with zeroes up to the length
     * of $this->scale
     */
    private $padDecimal = true;

    private $decimalMark = '.';
    private $thousandsMark = ',';

    /**
     * String used for sign.
     */
    private $sign = '-';

    /**
     * If you want to pad {sign} with whitespace, set $this->sign instead otherwise
     * your padding will appear in unsigned numbers too.
     *
     * Use this for things like currency:
     *   format('1.234', ['tpl'=>'AUD {sign}${num}'])
     */
    private $tpl = '{sign}{num}';

    private static $registry = [];

    static function register($name, $options)
    {
        static::$registry[$name] = new static($options);
    }

    static function unregister($name=null)
    {
        if ($name) {
            unset(static::$registry[$name]);
        } else {
            static::$registry = [];
        }
    }

    static function formatAs($name, $number)
    {
        if (!isset(static::$registry[$name])) {
            throw new \InvalidArgumentException("Unregistered formatter $name");
        }
        return static::$registry[$name]->format($number);
    }

    /**
     * Accepts an array of keyword arguments corresponding to the following properties:
     *   scale, decimalMark, thousandsMark, sign, tpl
     */
    public function __construct(array $options=[])
    {
        foreach ($options as $k=>$v) {
            if (!property_exists($this, $k)) {
                throw new \InvalidArgumentException("Unexpected keyword argument $k");
            }
            $this->$k = $v;
        }

        if (!$this->decimalMark) {
            throw new \InvalidArgumentException("Decimal mark was blank");
        }

        if (!$this->sign) {
            throw new \InvalidArgumentException("Sign was blank");
        }

        $this->thousandsMarkRev = isset($this->thousandsMark[1])
            ? strrev($this->thousandsMark)
            : $this->thousandsMark;
    }

    /**
     * @param  mixed   $decimal  Anything accepted by Decimal::create
     * @return string
     */
    public function format($decimal)
    {
        if (!$decimal instanceof Decimal) {
            $decimal = Decimal::create($decimal);
        }

        if ($this->scale !== null) {
            $decimal = $decimal->round($this->scale < 0 ? 0 : $this->scale);
        }

        $negative = $decimal->isNegative();
        $decimal = $decimal->abs();

        $x = explode('.', $decimal->__toString(), 2);
        $whole = $x[0];
        $decimal = isset($x[1]) ? $x[1] : null;

        $out = strrev(implode($this->thousandsMarkRev, str_split(strrev($whole), 3)));

        if ($decimal !== null) {
            $decimalOut = $decimal;

            if ($this->padDecimal) {
                $decimalOut = str_pad($decimalOut, $this->scale, '0');
            }
            $out .= $this->decimalMark.$decimalOut;
        }

        return strtr($this->tpl, array(
            '{num}'=>$out,
            '{sign}'=>$negative ? $this->sign : '',
        ));
    }
}
