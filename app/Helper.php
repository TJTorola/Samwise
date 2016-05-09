<?php

function randomPassword($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function isValidEmail($eMail) {
    return filter_var($eMail, FILTER_VALIDATE_EMAIL);
}

function returnDate($timeStamp) {
	return date("D. M. j, G:i, Y", $timeStamp);
}

function returnUSD($value) {
	return "$ ".number_format($value, 2);
}

function makeSlug($input) {
	$input = strtolower($input);
	$input = str_replace(array(' ', '/'), '-', $input);
	$input = str_replace('&', 'and', $input);
	$input = str_replace(array(':', "'", ','), '', $input);
	return $input;
}

function strStartsWith($haystack, $needle) {
  // search backwards starting from haystack length characters from the end
  return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function strEndsWith($haystack, $needle) {
  // search forward starting from end minus needle length characters
  return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function humanFileSize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == "GB")
    return number_format($size/(1<<30),2)."GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB")
    return number_format($size/(1<<20),2)."MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB")
    return number_format($size/(1<<10),2)."KB";
  return number_format($size)." bytes";
}

function anyStartsWith($needle, $haystack) {
  for ($i=0; $i < count($haystack); $i++) { 
    if (strStartsWith($haystack[$i], $needle)) {
      return true;
    }
  }

  return false;
}