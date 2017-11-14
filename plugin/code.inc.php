<?php

if (file_exists(LIB_DIR . '/plugin_code_config.php')) {
    require_once LIB_DIR . '/plugin_code_config.php';
} elseif (file_exists(LIB_DIR . '/plugin_code_config.dist.php')) {
    require_once LIB_DIR . '/plugin_code_config.dist.php';
} else {
    die_message(sprintf('code plugin: Invalid configuration, %s/%s is not found', LIB_DIR,
        'plugin_code_config.php'));
}

function plugin_code_convert()
{
    if (!(PKWK_ALLOW_JAVASCRIPT || PLUGIN_CODE_FORCE_USE_JAVASCRIPT)) {
        return plugin_code_get_error('javascript_denied');
    }

    $args = func_get_args();
    if (count($args) === 0) {
        return plugin_code_get_error('missing_argument');
    }

    if (isset($args[1])) {
        $lang = $args[0];
        $class_attr = sprintf(' class="%s"', htmlspecialchars($lang, ENT_COMPAT, SOURCE_ENCODING));
        $body = $args[1];
    } else {
        $class_attr = '';
        $body = $args[0];
    }
    return sprintf("<pre><code%s>%s</code></pre>", $class_attr, htmlspecialchars($body, ENT_COMPAT, SOURCE_ENCODING));
}

function plugin_code_init()
{
    global $head_tags;

    $messages = [
        '_code_messages' => [
            'error_template' => '<span style="color: red; font-weight: bold;">エラー: %s</span>',
            'misconfiguration_multiline' => 'PKWKEXP_DISABLE_MULTILINE_PLUGIN_HACK は 0 である必要があります。',
            'javascript_denied' => 'PKWK_ALLOW_JAVASCRIPT設定とPLUGIN_CODE_FORCE_USE_JAVASCRIPT設定が無効です。',
        ]
    ];
    set_plugin_messages($messages);

    if (PKWKEXP_DISABLE_MULTILINE_PLUGIN_HACK) {
        die_message($messages['_code_messages']['misconfiguration_multiline']);
        return false; // no return
    }
    if (PKWK_ALLOW_JAVASCRIPT || PLUGIN_CODE_FORCE_USE_JAVASCRIPT) {
        $head_tags[] = sprintf('<link rel="stylesheet" href="%s">',
            htmlspecialchars(PLUGIN_CODE_STYLESHEET_URL, ENT_COMPAT, SOURCE_ENCODING));
        $head_tags[] = sprintf('<script src="%s"></script>',
            htmlspecialchars(PLUGIN_CODE_SCRIPT_URL, ENT_COMPAT, SOURCE_ENCODING));
        $head_tags[] = '<script>hljs.initHighlightingOnLoad();</script>';
    }
}
