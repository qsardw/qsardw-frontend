<?php

namespace Qsardw\Frontend\Utils;

/**
 * Description of String
 *
 * @author Javier Caride Ulloa <javiercaride@mobail.es>
 */
class String
{
    /**
     * Returns the camelcase string of an underscore separated string
     *
     * - Example: test_column => testColumn
     *
     * @param string $string Underscored string
     * @return string
     */
    public static function underscoreCamelCaser($string)
    {
        $words = explode("_", $string);
        foreach ($words as $position => $value) {
            if ($position >= 1) {
                $value = ucfirst($value);
            }
            $words[$position] = $value;
        }

        return implode('', $words);
    }

    /**
     * Returns the underscore string from a CamelCase string
     *
     * @param string $string CamelCase string
     * @return string
     */
    public static function camelcaseUnderscorer($string)
    {
        $underscores = array(
            '_a', '_b', '_c', '_d', '_e', '_f', '_g', '_h', '_i', '_j', '_k',
            '_l', '_m', '_n', '_o', '_p', '_q', '_r', '_s', '_t', '_u', '_v',
            '_w', '_x', '_z'
        );

        $uppercases = array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z'
        );

        $underscoresString = str_replace($uppercases, $underscores, $string);

        if (substr($underscoresString, 0, 1) === '_') {
            $underscoresString = substr($underscoresString, 1);
        }

        return $underscoresString;
    }
}
