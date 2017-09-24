<?php
	$errorList = [];
	$str = basename($_SERVER['QUERY_STRING']);
	$out = [];
	parse_str($str, $out);

	if (count($out) < 3) {
		array_push($errorList, "Переданы не все параметры arg1, arg2 и operation");
	}
	if (!isset($_GET["arg1"]) || !isset($_GET["arg2"]) || !isset($_GET["operation"])) {
		array_push($errorList, "Один или несколько параметров имеют некорректные имена (например, arg1, arg2 и op)");
	}
	if (count($out) > 3) {
		array_push($errorList, "Переданы лишние параметры (например, arg1, arg2, operation, name)");
	}
	if (isset($_GET["arg1"]) && isset($_GET["arg2"]) && (!is_numeric($_GET["arg1"]) || !is_numeric($_GET["arg2"]))) {
		array_push($errorList, "Параметры arg1 и arg2 содержат данные, отличные от числовых");
	}
	if (isset($_GET["operation"]) && !in_array($_GET["operation"], array("add", "sub", "mul", "div"))) {
		array_push($errorList, "Параметр operation содержит некорректную операцию");
	}
	if (isset($_GET["arg2"]) && isset($_GET["operation"]) && $_GET["operation"] === "div" && $_GET["arg2"] === "0") {
		array_push($errorList, "Происходит деление на ноль");
	}
	
	if (count($errorList) === 0) {
		$arg1 = $_GET["arg1"];
		$arg2 = $_GET["arg2"];
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
				echo $arg1 / $arg2;
				break;
		}
	} else {
		foreach ($errorList as $value) {
			echo $value."<br>";
		}
	}