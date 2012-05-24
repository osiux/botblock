<?php
function print_js($file = null) {
    $ci =& get_instance();

    if (!empty($file)) {
        $ci->assets->add_js($file, true);
    }

    echo $ci->assets->print_js();
}

function print_css($file = null) {
    $ci =& get_instance();

    if (!empty($file)) {
        $ci->assets->add_css($file, true);
    }

    echo $ci->assets->print_css();
}

function print_img($file = null, $alt = '', $attr = array(), $echo = true) {
    $ci =& get_instance();

    if (empty($file)) {
        return '';
    }

    $attrs = '';
    if (!empty($attr)) {
        foreach ($attr as $key => $value) {
            $attrs .= ' ' . $key . '="' . $value . '"';
        }
    }

    $string = '<img' . $attrs . ' src="' . $ci->assets->img_url($file) . '" alt="' . htmlspecialchars($alt) . '" />';

    if ($echo)  echo $string;
    else        return $string;
}