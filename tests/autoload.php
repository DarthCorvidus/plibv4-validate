<?php
require './src/Validate.php';
require './src/ValidateException.php';
require './src/ValidateDate.php';
require './src/ValidateTime.php';
if(file_exists("../plibv4-assert")) {
	require "../plibv4-assert/src/Assert.php";
}

if(file_exists("./vendor/")) {
	require "./vendor/autoload.php";
}
