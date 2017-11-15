<?php

define('PLUGIN_CODE_SCRIPT_URL',
    '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js');
define('PLUGIN_CODE_STYLESHEET_URL',
    '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css');

define('PLUGIN_CODE_FORCE_USE_JAVASCRIPT', false);


function plugin_code_get_error($index)
{
    global $_code_messages;
    $message = isset($_code_messages[$index]) ? $_code_messages[$index] : 'unknown error';

    return sprintf($_code_messages['error_template'], $_code_messages[$index]);
}
