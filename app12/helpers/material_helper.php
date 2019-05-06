<?php

if (!function_exists('qty_on_hand'))
{
	function qty_on_hand($item)
	{
		return 0;
	}
}

if (!function_exists('qty_ordered'))
{
	function qty_ordered($item)
	{
		return 0;
	}
}


if (!function_exists('join_qty'))
{
	function join_qty($operator, $qty)
	{
        $args = func_get_args();
        $argc = func_num_args();
        $result = 0;

        if ($argc <= 1) {
            return $result;
        }

        array_shift($args);

        if ($argc == 2 && is_array(current($args))) {
            $args = current($args);
        } 

        foreach($args as $i => $arg) {
            if ($i === 0) {
                $result = $arg;
                continue;
            }

            switch($operator) {
                case "add":
                case "+":
                    $result += $arg;
                    break;
                case "substract":
                case "-":
                    $result -= $arg;
                    break;
                case "multiply":
                case "*":
                    $result *= $arg;
                    break;
                case "divide":
                case "/":
                    $result /= $arg;
                    break;                
            } 
        }

        return $result;
	}
}

if (!function_exists('join_uom'))
{
    function join_uom($separator, $uom) {
        $args = func_get_args();
        $argc = func_num_args();

        if ($argc <= 1) {
            return '';
        }

        array_shift($args);

        if ($argc == 2 && is_array(current($args))) {
            $args = current($args);
        } 

        return implode($separator, $args);
    }
}

if (!function_exists('join_multi_uom')) 
{
    function join_multi_uom() {
        $args = func_get_args();

        if (func_num_args() === 1 && is_array(current($args))) {
            $args = current($args);
        }

        $args = array_values(array_filter($args));

        return join_uom('-', $args);
    }
}


if (!function_exists('tkdn_average')) 
{
    function tkdn_average($type, $goods_value, $service_value) {
        // TODO: use letter as ID instead of numeric. e.g ("GOODS". "SERVICE", etc)
        if ($type == '1') { // Goods
            return $goods_value;
        } elseif ($type == '2') { // Service
            return $service_value;
        } elseif ($type == '3') { // Combination
            return ( (float) $goods_value + (float) $service_value ) / 2;
        }
    }
}
