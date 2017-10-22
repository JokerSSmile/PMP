<?php
function strToNum($string)
{
	if (!is_numeric($string)) {
		throw new Exception();
	}

	return intval($string);
}

$error = "";
$out = [];
parse_str($_SERVER['QUERY_STRING'], $out);

if (count($out) < 3) {
	$error = "Переданы не все параметры";
} else if (count($out) > 3) {
	$error = "Переданы лишние параметры";
} else if (!isset($_GET["arg1"]) || !isset($_GET["arg2"]) || !isset($_GET["operation"])) {
	$error = "Один или несколько параметров имеют некорректные имена (например, arg1, arg2 и op)";
}

if ($error === "") {
	try {
		$arg1 = strToNum($_GET["arg1"]);
		$arg2 = strToNum($_GET["arg2"]);
	} catch (Exception $e) {
		echo "Параметры arg1 и arg2 содержат данные, отличные от числовых";
		die();
	}
	$operation = $_GET["operation"];
	switch ($operation) {
		case "add":
			echo $arg1 + $arg2;
			break;
		case "sub":
			echo $arg1 - $arg2;
			break;
		case "mul":
			echo $arg1 * $arg2;
			break;
		case "div":
			if ($arg2 === 0) {
				echo "Деление на ноль";
			} else {
				echo $arg1 / $arg2;
			}
			break;
		default:
			echo "Параметр operation содержит некорректную операцию";
			break;
	}
} else {
	echo $error;
}