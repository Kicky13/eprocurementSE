<?php defined('BASEPATH') OR exit('No direct script access allowed');

$sys_helper = SYSDIR.DIRECTORY_SEPARATOR.'/helpers/array_helper.php';
file_exists($sys_helper) AND require_once($sys_helper);

if (!function_exists('array_pluck')) {
  /**
   * Pluck an array of values from an array.
   *
   * @param  array  $array
   * @param  string|array  $value
   * @param  string|array|null  $key
   * @return array
   * @see    https://github.com/laravel/framework/blob/29611a9d8abf46eabcf5bd1c4b47dfa7079ad6bf/src/Illuminate/Support/Arr.php
   */
  function array_pluck($array, $value, $key = null)
  {
      $results = [];

      // list($value, $key) = _explodePluckParameters($value, $key);

      foreach ($array as $item) {
          $itemValue = _data_get($item, (string) $value);

          // If the key is "null", we will just append the value to the array and keep
          // looping. Otherwise we will key the array using the value of the key we
          // received from the developer. Then we'll return the final array form.
          if (is_null($key)) {
              $results[] = $itemValue;
          } else {
              $itemKey = _data_get($item, $key);

              if (is_object($itemKey) && method_exists($itemKey, '__toString')) {
                  $itemKey = (string) $itemKey;
              }

              $results[$itemKey] = $itemValue;
          }
      }

      return $results;
  }

  /**
   * Explode the "value" and "key" arguments passed to "pluck".
   *
   * @param  string|array  $value
   * @param  string|array|null  $key
   * @return array
   */
  // function _explodePluckParameters($value, $key)
  // {
  //     $value = is_string($value) ? explode('.', $value) : $value;

  //     $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

  //     return [$value, $key];
  // }

  /**
   * A simple story about data_get().
   * Get an item from an array or object using "dot" notation.
   *
   * @param  mixed   $target
   * @param  string|array  $key
   * @param  mixed   $default
   * @return mixed
   * 
   */
  function _data_get($data, $key, $default = null) {
    if (is_array($data) && isset($data[$key])) {
      return $data[$key];
    } elseif (is_object($data) && property_exists($data, $key)) {
      return $data->{$key};
    } else {
      return $default;
    }
  }

}
