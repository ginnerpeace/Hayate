<?php

namespace Hayate;

/**
 * 数字处理函数(并无卵用)
 * _(:3」∠x)_
 */
class NumberHelpers {

	/**
	 * 长整型相减
	 * @author gjy
	 *
	 * @param  number string $num1
	 * @param  number string $num2
	 * @return number string
	 */
	public static function long_int_minus($num1, $num2) {
		if (!self::_check_long_number($num1, $num2)) {
			return 0;
		}

		if ($num1 < $num2) {
			return '-' . self::long_int_minus($num2, $num1);
		}

		$arr1 = str_split(strrev($num1), 9);
		$arr2 = str_split(strrev($num2), 9);

		foreach ($arr1 as &$v) {
			$v = strrev($v);
		}

		unset($v);

		foreach ($arr2 as &$v) {
			$v = strrev($v);
		}

		unset($v);

		array_walk($arr2, function ($v, $k) use (&$arr1) {
			$re = $arr1[$k];
			if ($arr1[$k] < $v) {
				$arr1[$k + 1] -= 1;
				$re = 1 . $arr1[$k];
			}
			$arr1[$k] = $re - $v;
		});

		$hehe = '';
		foreach ($arr1 as $v) {
			$hehe = (strlen($v) === 9 ? $v : sprintf("%09d", $v)) . $hehe;
		}

		return ltrim($hehe, '0');
	}

	/**
	 * 长整型相加
	 * @author gjy
	 *
	 * @param  number string $num1
	 * @param  number string $num2
	 * @return number string
	 */
	public static function long_int_sum($num1, $num2) {
		if (!self::_check_long_number($num1, $num2)) {
			return 0;
		}

		if ($num1 < $num2) {
			return self::long_int_sum($num2, $num1);
		}

		$arr1 = str_split(strrev($num1), 9);
		$arr2 = str_split(strrev($num2), 9);

		foreach ($arr1 as &$v) {
			$v = strrev($v);
		}

		unset($v);

		foreach ($arr2 as &$v) {
			$v = strrev($v);
		}

		unset($v);

		array_walk($arr2, function ($v, $k) use (&$arr1) {
			$arr1[$k] = $arr1[$k] + $v;
			if ($arr1[$k] > 999999999) {
				$arr1[$k] -= 1000000000;
				$arr1[$k + 1] += 1;
			}
		});

		$hehe = '';
		foreach ($arr1 as $v) {
			$hehe = $v . $hehe;
		}

		return $hehe;
	}

	private static function _check_long_number($num1, $num2) {
		return is_numeric($num1)
		&& is_numeric($num2)
		&& $num1 >= 0
		&& $num2 >= 0
		&& strpos($num1, '.') === FALSE && strpos($num1, '.') === FALSE
			&& ($num1 > 999999999 || $num2 > 999999999);
	}

	/**
	 * 字节转换
	 * @author gjy
	 *
	 * @param  integer | number string $num
	 * @param  integer $precision
	 * @return string
	 */
	public static function byte_format($num, $precision = 1) {
		if ($num >= 1000000000000) {
			$num = round($num / 1099511627776, $precision);
			$unit = 'TB';
		} elseif ($num >= 1000000000) {
			$num = round($num / 1073741824, $precision);
			$unit = 'GB';
		} elseif ($num >= 1000000) {
			$num = round($num / 1048576, $precision);
			$unit = 'MB';
		} elseif ($num >= 1000) {
			$num = round($num / 1024, $precision);
			$unit = 'KB';
		} else {
			$unit = 'Bytes';
			return number_format($num) . ' ' . $unit;
		}

		return number_format($num, $precision) . ' ' . $unit;
	}
}