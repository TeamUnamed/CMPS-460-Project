<?php

    $form_data = [];

    function getData(string $key, $default = null) : mixed {
        global $form_data;
        if (array_key_exists($key, $form_data))
            return $form_data[$key];
        else
            return ($default ?? "");
    }

    function input($type, $name, $label, $placeholder = "") : void {
        print "<label>"   . $label . ": <input" .
              " type=\""  . $type  . "\"" .
              " name=\""  . $name  . "\"" .
              " value=\"" . getData($name, "") . "\"" .
              " placeholder=\"" . $placeholder . "\"" .
              " /> </label>";
        if (isset($GLOBALS["error__".$name]))
            print $GLOBALS["error__".$name];
        print "<br>\n";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($_POST as $key => $value) {
            $form_data += [$key => $value];
        }
    }