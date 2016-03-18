<?php
/**
 * Escapes the given object
 * @param any $object
 * @return string
 */
function escape($object) {
    if (isset($object)) {
        return htmlentities($object, HTML_SPECIALCHARS, 'UTF-8');
    }
    return '';
}

function var_dump_pre($output) {
    echo '<pre>';
    var_dump($output);
    echo '</pre>';
}