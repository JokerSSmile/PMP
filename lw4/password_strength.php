<?php
header('Content-type: application/json');

if (!isset($_GET['password'])) {
    die();
}

function getDigitsCount($string)
{
    return preg_match_all( "/[0-9]/", $string );
}

function getCapitalsCount($string)
{
    return preg_match_all( "/[A-Z]/", $string );
}

function getSmallLetersCount($string)
{
    return preg_match_all( "/[a-z]/", $string );
}

function isOnlyLetters($string)
{
    return !preg_match('/[A-Za-z]/', $string);
}

function getDuplicatesCount($string)
{
    $repeatingCharsCount = 0;
    $charsCount = array_count_values(str_split($string));
    foreach($charsCount as $count) {
        if ($count > 1) {
            $repeatingCharsCount += $count;
        }
    }

    return $repeatingCharsCount;
}

function calculatePasswordStrength($password)
{
    $strength = 0;
    $passwordLength = strlen($password);
    $capitalsCount = getCapitalsCount($password);
    $smallLettersCount = getSmallLetersCount($password);
    $digitsCount = getDigitsCount($password);

    $strength += 4 * $passwordLength;
    $strength += 4 * $digitsCount;
    if ($capitalsCount > 0) {
        $strength += 2 * ($passwordLength - $capitalsCount);
    }
    if ($smallLettersCount > 0) {
        $strength += 2 * ($passwordLength - $smallLettersCount);
    }
    if (isOnlyLetters($password)) {
        $strength -= $capitalsCount + $smallLettersCount;
    }
    if ($digitsCount === $passwordLength) {
        $strength -= $digitsCount;
    }
    $strength -= getDuplicatesCount($password);

    return $strength;
}

echo json_encode(array('strength' => calculatePasswordStrength($_GET['password'])));