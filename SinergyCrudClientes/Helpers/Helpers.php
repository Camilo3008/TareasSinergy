<?php

//Retorla la url del proyecto
function base_url()
{
    return BASE_URL;
}

function media()
{
    return BASE_URL . "Assets";
}

//Muestra información formateada
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}
function jsonResponse($data, $code)
{
    header(header: "HTTP/1.1 $code");
    header(header: "Cotent-type: application/json");
    echo json_encode($data);
}
function testString($data)
{
    $expresionRegular = "/[a-zA-Z]/";
    if (preg_match($expresionRegular, $data)) {
        return true;
    } else {
        return false;
    }
}
function testNumber($number)
{
    $expresionRegular = "/\d+/";
    if (preg_match($expresionRegular, $number)) {
        return true;
    } else {
        return false;
    }
}
function testEmail($number)
{
    $expresionRegular = '/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/m';
    if (preg_match($expresionRegular, $number)) {
        return true;
    } else {
        return false;
    }
}

function validateElements($arrayElementsString, $arrayElementsNumber, $elementsEmail, $elementsNormal)
{
    $responseValidateElements = [];
    for ($x = 0; $x < count($arrayElementsString); $x++) {
        if (empty($_POST[$arrayElementsString[$x]])) {
            $responseValidateElements[$arrayElementsString[$x]] =  "Is empty";
        } else if (!testString($_POST[$arrayElementsString[$x]])) {
            $responseValidateElements[$arrayElementsString[$x]] = "should not contain numbers";
        }
    };
    for ($x = 0; $x < count($arrayElementsNumber); $x++) {
        if (empty($_POST[$arrayElementsNumber[$x]])) {
            $responseValidateElements[$arrayElementsNumber[$x]] =  "Is empty";
        } else if (testString($_POST[$arrayElementsNumber[$x]])) {
            $responseValidateElements[$arrayElementsNumber[$x]] = "should not contain letters";
        }
    };
    for ($x = 0; $x < count($elementsEmail); $x++) {
        if (empty($_POST[$elementsEmail[$x]])) {
            $responseValidateElements[$elementsEmail[$x]] =  "Is empty";
        } else if (!testEmail($_POST[$elementsEmail[$x]])) {
            $responseValidateElements[$elementsEmail[$x]] = "Verify your email";
        }
    };
    for ($x = 0; $x < count($elementsNormal); $x++) {
        if (empty($_POST[$elementsNormal[$x]])) {
            $responseValidateElements[$elementsNormal[$x]] =  "Is empty";
        }
    };
    return $responseValidateElements;
}
