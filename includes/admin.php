<?php

namespace printdoors\Admin;

const MENU_TITLE_TOP = 'Printdoors';
const PAGE_TITLE_DASHBOARD = 'Dashboard';
const MENU_TITLE_DASHBOARD = 'Dashboard';
const MENU_SLUG_DASHBOARD = 'printdoors-dashboard';
const CAPABILITY = 'manage_options';
const PRINTDOORS_NAMESPACE = 'printdoors/v1';
const API_HOST = 'https://api.printdoors.com';
// const API_HOST = 'https://bmapi.s2bdiy.com';

function init()
{
    add_action('admin_enqueue_scripts', 'printdoors\Admin\load_admin_script');
    add_action('admin_menu', 'printdoors\Admin\register_menu');
    add_action('rest_api_init', 'printdoors\Admin\register_api');
}

function register_menu()
{
    add_menu_page(
        'printdoors',
        MENU_TITLE_TOP,
        CAPABILITY,
        MENU_SLUG_DASHBOARD,
        '\printdoors\Admin\admin_render',
        "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzUiIGhlaWdodD0iNDEiIHZpZXdCb3g9IjAgMCAzNSA0MSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgaWQ9IkZyYW1lIDExNiI+CjxnIGlkPSImIzIzMTsmIzE4NzsmIzEzMjsgMjU4MSI+CjxwYXRoIGlkPSImIzIzMjsmIzE4MzsmIzE3NTsmIzIyOTsmIzE5MDsmIzEzMjsgMTMzOSIgZD0iTTI2LjI5MzEgOS4yMzQ2MkgyMy40MzMxQzIzLjQzMzEgNy41Njk0NiAyMi43NzE3IDUuOTcyNDkgMjEuNTk0MiA0Ljc5NTA0QzIwLjQxNjggMy42MTc2IDE4LjgxOTggMi45NTYxMiAxNy4xNTQ2IDIuOTU2MTJDMTUuNDg5NSAyLjk1NjEyIDEzLjg5MjUgMy42MTc2IDEyLjcxNTEgNC43OTUwNEMxMS41Mzc2IDUuOTcyNDkgMTAuODc2MSA3LjU2OTQ2IDEwLjg3NjEgOS4yMzQ2Mkg4LjAxNjEzQzguMDAzNDkgOC4wMjY0OSA4LjIzMDU0IDYuODI3ODMgOC42ODQxMiA1LjcwODAxQzkuMTM3NzEgNC41ODgxOSA5LjgwODgzIDMuNTY5NDEgMTAuNjU4NyAyLjcxMDYzQzExLjUwODUgMS44NTE4NSAxMi41MjAyIDEuMTcwMTEgMTMuNjM1MiAwLjcwNDgzNEMxNC43NTAyIDAuMjM5NTYgMTUuOTQ2NCAwIDE3LjE1NDYgMEMxOC4zNjI4IDAgMTkuNTU5IDAuMjM5NTYgMjAuNjc0MSAwLjcwNDgzNEMyMS43ODkxIDEuMTcwMTEgMjIuODAwNyAxLjg1MTg1IDIzLjY1MDYgMi43MTA2M0MyNC41MDA0IDMuNTY5NDEgMjUuMTcxNiA0LjU4ODE5IDI1LjYyNTIgNS43MDgwMUMyNi4wNzg3IDYuODI3ODMgMjYuMzA1OCA4LjAyNjQ5IDI2LjI5MzEgOS4yMzQ2MlY5LjIzNDYyWiIgZmlsbD0id2hpdGUiLz4KPHBhdGggaWQ9IiYjMjI5OyYjMTM1OyYjMTQzOyYjMjI5OyYjMTQyOyYjMTg3OyAzNCIgZD0iTTUuMjg5NjggNDAuMTM5Mkg0Ljk1OTcyQzQuMjMyMDQgNDAuMTU0NSAzLjUwODc0IDQwLjAyMDcgMi44MzQxMSAzOS43NDc2QzIuMTU5NDggMzkuNDc0NCAxLjU0NzU5IDM5LjA2NjcgMS4wMzU2NSAzOC41NDkzQzAuNjg1MTk5IDM4LjE5MDcgMC40MTI2NTkgMzcuNzY0NCAwLjIzNTIzMiAzNy4yOTU0QzAuMDU3ODA1MSAzNi44MjY1IC0wLjAyMDY3OTQgMzYuMzI1NSAwLjAwNDY0MTAzIDM1LjgyNDdMMS4zOTA2MyAxNC4xNjI2QzEuNTI3NjMgMTEuOTg1NiAzLjcwMzYzIDEwLjI4MDggNi4zNDM2MyAxMC4yODA4SDI3Ljk3NTdDMzAuNjEyNyAxMC4yODA4IDMyLjc4ODcgMTEuOTg1NiAzMi45Mjg3IDE0LjE2MjZMMzQuMzExNiAzNS44MjQ3QzM0LjMzNyAzNi4zMjU1IDM0LjI1ODUgMzYuODI2NSAzNC4wODExIDM3LjI5NTRDMzMuOTAzNiAzNy43NjQ0IDMzLjYzMTEgMzguMTkwNyAzMy4yODA2IDM4LjU0OTNDMzIuNzY5MSAzOS4wNjY2IDMyLjE1NzUgMzkuNDc0NCAzMS40ODMyIDM5Ljc0NzZDMzAuODA4OSA0MC4wMjA4IDMwLjA4NiA0MC4xNTQ1IDI5LjM1ODYgNDAuMTM5MkgyNC41MjQ3VjQwLjExODdDMjQuNTI1IDQwLjExNjMgMjQuNTI1IDQwLjExNDEgMjQuNTI0NyA0MC4xMTE4QzI0LjQ4MDcgMzkuMjA1OCAyNC40NTg2IDM4LjA3NjMgMjQuNDU4NiAzNi43NTYzQzI0LjQ1ODYgMzMuNjcyMyAyNC41ODA2IDMwLjM3MDcgMjQuNjEzNiAyOS42NTY3QzI0LjY0MTYgMjkuMDgxNyAyNC43NjU2IDI4Ljk1NjUgMjQuODY0NiAyOC45NTY1QzI0LjkyNDQgMjguOTY1IDI0Ljk3OTIgMjguOTk0OCAyNS4wMTg3IDI5LjA0MDVDMjUuMjE2OSAyOS4yOTI2IDI1LjQzNjcgMjkuNTI3IDI1LjY3NTcgMjkuNzQwN0MyNi4yOTg3IDMwLjMyNjcgMjcuMTE3NiAzMC45ODA4IDI3LjUxNTYgMzEuMjc3OEwyNy41Mzk3IDMxLjI5NTRMMjcuNTUyNiAzMS4zMDYyQzI3LjY2MDQgMzEuMzg3NCAyNy43OTE3IDMxLjQzMTMgMjcuOTI2NiAzMS40MzEyQzI4LjAwMTQgMzEuNDMxMSAyOC4wNzU2IDMxLjQxNzUgMjguMTQ1NiAzMS4zOTExQzI5LjIxNjQgMzAuOTc1OCAzMC4xNzk2IDMwLjMyNDEgMzAuOTYzNiAyOS40ODQ5QzMxLjc0NzYgMjguNjQ1NiAzMi4zMzIyIDI3LjYzOTkgMzIuNjczNyAyNi41NDM1QzMyLjY5MjcgMjYuNDg0MyAzMi43MDI0IDI2LjQyMyAzMi43MDI2IDI2LjM2MDhDMzIuNzA0IDI2LjIwMTIgMzIuNjQzOCAyNi4wNDc2IDMyLjUzNDcgMjUuOTMxMkMyNy43MzQ3IDIwLjc1NDIgMjMuOTk0NyAxOC42MjIzIDIyLjk2MTcgMTguMDkyM0MyMi44Nzc3IDE4LjA0OTYgMjIuNzg0OSAxOC4wMjc5IDIyLjY5MDcgMTguMDI3OEMyMi41NDg2IDE4LjAyODggMjIuNDEwOSAxOC4wNzY0IDIyLjI5ODcgMTguMTYzNkMyMS4xNTIyIDE5LjEyNjcgMTkuNzE2MSAxOS42Nzg0IDE4LjIxOTYgMTkuNzNDMTcuNjk0OCAxOS43Mjk1IDE3LjE3MyAxOS42NTE2IDE2LjY3MDcgMTkuNDk5NUwxNi42NDg3IDE5LjQ5MjdMMTYuNjIxNyAxOS40ODM5TDE2LjU5ODYgMTkuNDc3MUgxNi41ODY3SDE2LjU3NzZIMTYuNTY2N0wxNi41Mjk3IDE5LjQ2MzRIMTYuNTIzN0gxNi41MTg3TDE2LjUwMDYgMTkuNDU3NUwxNi40ODE3IDE5LjQ1MDdIMTYuNDczNkgxNi40NjU3TDE2LjQzNDcgMTkuNDM5OUgxNi40MjU3SDE2LjQxMzdMMTYuMzk2NiAxOS40MzQxSDE2LjM4ODdMMTYuMzU1NyAxOS40MjA0SDE2LjM0MzZIMTYuMzMxN0wxNi4zMTA3IDE5LjQxMjZIMTYuMzAxNkgxNi4yOTQ3TDE2LjI3NzcgMTkuNDA1OEwxNi4yNTU2IDE5LjM5NzlIMTYuMjQ5NkMxNS4xNjg5IDE4Ljk1NTcgMTQuMjA3IDE4LjI2NTIgMTMuNDQxNyAxNy4zODMzTDEzLjQxNjYgMTcuMzU3OUMxMy4zNTggMTcuMjk3MSAxMy4yODc2IDE3LjI0OTEgMTMuMjA5NyAxNy4yMTYzQzEzLjEzMTkgMTcuMTgzNSAxMy4wNDgxIDE3LjE2NjEgMTIuOTYzNiAxNy4xNjY1QzEyLjkxNTggMTcuMTY2MiAxMi44NjgyIDE3LjE3MjIgMTIuODIxNyAxNy4xODMxQzExLjYwNjkgMTcuNDYzOSAxMC40MDc0IDE3LjgwNjEgOS4yMjc2NiAxOC4yMDk1SDkuMjEzNjJIOS4yMDU2OUg5LjE5ODYxTDkuMTYyNiAxOC4yMjMxQzYuNDY3MjYgMTkuMDQ2IDMuOTcyNzQgMjAuNDE5OSAxLjgzNzY1IDIyLjI1OTNMMS44MjE2NiAyMi4yNzY5QzEuNzQwMzkgMjIuMzU3OSAxLjY4MzI4IDIyLjQ2MDIgMS42NTY2MiAyMi41NzE4QzEuNjI5OTUgMjIuNjgzNCAxLjYzNDc4IDIyLjc5OTcgMS42NzA2NiAyMi45MDg3QzEuNjk2NjYgMjIuOTg3NyAxLjcyMjY2IDIzLjA2NTEgMS43NDg2NiAyMy4xNDExQzIuMTA1MzggMjQuMjYwMiAyLjU5MDk5IDI1LjMzMzMgMy4xOTU2OCAyNi4zNDAzTDMuMjA3NjQgMjYuMzU5OUwzLjIxOTYxIDI2LjM3ODRMMy4yNDI2OCAyNi40MTQ2VjI2LjQyMjRDMy42NjY3OSAyNy4xNDc3IDQuMjc1ODggMjcuNzQ3OCA1LjAwNzY5IDI4LjE2MDZDNS4xMDIgMjguMjA2MyA1LjE4OTUxIDI4LjI2NDcgNS4yNjc3IDI4LjMzNDVDNS4yNzA0MiAyOC4zMzY4IDUuMjcyNzQgMjguMzM5MyA1LjI3NDY2IDI4LjM0MjNDNS4zNDQxOSAyOC4zOTgyIDUuNDI0MzkgMjguNDM5NiA1LjUxMDM4IDI4LjQ2MzRDNS41OTYzNiAyOC40ODcxIDUuNjg2MzEgMjguNDkzMyA1Ljc3NDY2IDI4LjQ4MUM3LjAwMzI2IDI4LjM1NjIgOC4xOTYzNyAyNy45OTU1IDkuMjg4NyAyNy40MTk0QzkuMzEyNTkgMjcuNDA0MiA5LjM0MDMzIDI3LjM5NjggOS4zNjg2NSAyNy4zOTdDOS40MDkzNyAyNy4zOTcyIDkuNDQ4NDEgMjcuNDEyNiA5LjQ3NzY2IDI3LjQ0MDlDOS41MDY5MSAyNy40NjkyIDkuNTI0MDkgMjcuNTA3NyA5LjUyNTY0IDI3LjU0ODNDOS41MjU5NiAyNy41NTQzIDkuNTI1OTYgMjcuNTYwOSA5LjUyNTY0IDI3LjU2NjlDOC45NzA3IDMxLjg5ODkgNy41NjYyNiAzNi4wNzg2IDUuMzkyNyAzOS44NjY3TDUuMzg3NyAzOS44NzU1TDUuMzgwNjIgMzkuODkwMUM1LjM1MzA1IDM5Ljk0MDUgNS4zMzM1IDM5Ljk5MzkgNS4zMjI2MyA0MC4wNTAzTDUuMjkzNyA0MC4xODEyTDUuMjg5NjggNDAuMTM5MloiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGlkPSImIzIzMDsmIzE2NDsmIzE3MzsmIzIyOTsmIzE1NjsmIzEzNDsgMTMyIiBkPSJNMTIuOTExNCAyNi40NDIzQzEzLjQ3OSAyNi4zNzAyIDEzLjg1MjMgMjUuNjI4NyAxMy43NDUzIDI0Ljc4NjFDMTMuNjM4MyAyMy45NDM1IDEzLjA5MTQgMjMuMzE4OSAxMi41MjM4IDIzLjM5MDlDMTEuOTU2MiAyMy40NjMgMTEuNTgyOSAyNC4yMDQ2IDExLjY4OTkgMjUuMDQ3MkMxMS43OTY5IDI1Ljg4OTggMTIuMzQzOCAyNi41MTQ0IDEyLjkxMTQgMjYuNDQyM1oiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGlkPSImIzIzMDsmIzE2NDsmIzE3MzsmIzIyOTsmIzE1NjsmIzEzNDsgMTMzIiBkPSJNMjMuMDIzNyAyNi4wNjY1QzIzLjI3NDYgMjUuMjU1IDIzLjAzNDggMjQuNDYwMSAyMi40ODgyIDI0LjI5MTFDMjEuOTQxNiAyNC4xMjIxIDIxLjI5NSAyNC42NDI5IDIxLjA0NDEgMjUuNDU0NUMyMC43OTMyIDI2LjI2NiAyMS4wMzMgMjcuMDYwOCAyMS41Nzk2IDI3LjIyOThDMjIuMTI2MyAyNy4zOTg4IDIyLjc3MjggMjYuODc4IDIzLjAyMzcgMjYuMDY2NVoiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGlkPSImIzIzMjsmIzE4MzsmIzE3NTsmIzIyOTsmIzE5MDsmIzEzMjsgMTM0MyIgZD0iTTE2LjUzNzcgMzMuMzM1NEMxNi4zODU5IDMzLjMzNTQgMTYuMjM0MyAzMy4zMjUzIDE2LjA4MzcgMzMuMzA1NEMxMy41Mzk3IDMyLjk2OTQgMTIuNDMzNyAyOS44NDk0IDEyLjMxNTcgMjkuNDk0NEMxMi4yODc3IDI5LjM5MTQgMTIuMjgxNyAyOS4yODM3IDEyLjI5OCAyOS4xNzgzQzEyLjMxNDMgMjkuMDcyOCAxMi4zNTI2IDI4Ljk3MiAxMi40MTA0IDI4Ljg4MjNDMTIuNDY4MiAyOC43OTI2IDEyLjU0NDMgMjguNzE2MiAxMi42MzM2IDI4LjY1NzhDMTIuNzIyOCAyOC41OTk0IDEyLjgyMzQgMjguNTYwNCAxMi45Mjg3IDI4LjU0MzRDMTMuMTQ0OCAyOC40ODIgMTMuMzc1OSAyOC41MDE2IDEzLjU3ODUgMjguNTk4N0MxMy43ODExIDI4LjY5NTggMTMuOTQxMiAyOC44NjM1IDE0LjAyODcgMjkuMDcwNFYyOS4wNzA0QzE0LjI0ODcgMjkuNzI0NCAxNS4xNDY3IDMxLjYyNjQgMTYuMzUyNyAzMS43ODU0QzE3LjIxMTcgMzEuODk0NCAxOC4zNTk3IDMxLjA3NzQgMTkuNTg1NyAyOS40NzU0QzE5LjczNDIgMjkuMzAwNiAxOS45MzkxIDI5LjE4MzEgMjAuMTY0OSAyOS4xNDMzQzIwLjM5MDggMjkuMTAzNSAyMC42MjM0IDI5LjE0MzkgMjAuODIyNyAyOS4yNTc0QzIwLjkxNyAyOS4zMDMxIDIxIDI5LjM2OTEgMjEuMDY1NiAyOS40NTA4QzIxLjEzMTMgMjkuNTMyNSAyMS4xNzc5IDI5LjYyNzggMjEuMjAyMiAyOS43Mjk3QzIxLjIyNjYgMjkuODMxNiAyMS4yMjc5IDI5LjkzNzcgMjEuMjA2MiAzMC4wNDAyQzIxLjE4NDUgMzAuMTQyNyAyMS4xNDAzIDMwLjIzOTEgMjEuMDc2NyAzMC4zMjI0QzE5LjUzMTcgMzIuMzQ1NCAxOC4wNDA3IDMzLjMzNTQgMTYuNTM3NyAzMy4zMzU0WiIgZmlsbD0id2hpdGUiLz4KPC9nPgo8L2c+Cjwvc3ZnPgo=",
        57
    );
}

function load_admin_script()
{
    $plugin_path = dirname(__DIR__);
    $static_path = $plugin_path . DIRECTORY_SEPARATOR . "build" . DIRECTORY_SEPARATOR . "static";
    $js_path = $static_path . DIRECTORY_SEPARATOR . 'js';
    $css_path = $static_path . DIRECTORY_SEPARATOR . 'css';

    $js_url_path = plugins_url('build/static/js/', dirname(__FILE__));
    foreach (scandir($js_path) as $key => $path) {
        if (endsWith($path, '.js')) {
            wp_enqueue_script('printdoors_js_' . $key, $js_url_path . $path, [], null, true);
        }
    }

    $css_url_path = plugins_url('build/static/css/', dirname(__FILE__));
    foreach (scandir($css_path) as $key => $path) {
        if (endsWith($path, '.css')) {
            $name = 'printdoors_css_' . $key;
            wp_register_style($name, $css_url_path . $path, false, null);
            wp_enqueue_style($name);
        }
    }
}

function domain_need_update()
{
    $domain = get_option('printdoors_domain');
    $currentDomain = get_site_url();
    if (!$domain) {
        add_option('printdoors_domain', $currentDomain);
        return false;
    }
    return $domain != $currentDomain;
}

function get_store_data()
{
    $code = get_option('printdoors_code');
    if (!$code) {
        $code = (string)wp_generate_uuid4();
        add_option('printdoors_code', $code);
    }
    $accessKey = get_option('printdoors_access_key');
    $storeId = get_option('printdoors_store_id');
    return array(
        'updateDomain' => domain_need_update(),
        'version'   => WC()->version,
        'apiHost'  => API_HOST,
        'accessKey' => $accessKey ? $accessKey :  '',
        'storeId'   => $storeId ? $storeId : '',
        'name'      => get_bloginfo('title', 'display'),
        'website'   => get_site_url(),
        'code'      => $code,
        'params'    => base64_encode(json_encode([
            'name' => get_bloginfo('title', 'display'),
            'website' => get_site_url(),
            'code' => $code,
        ])),
        'woocommerceConnect' => '/api/woocommerce'
    );
}

function admin_render()
{
    echo '<script> window.printdoorsStoreData = ' . json_encode(get_store_data()) . '</script>';
    echo '<div id="printdoors-root"></div>';
}

function register_api()
{
    register_rest_route(PRINTDOORS_NAMESPACE, '/set_access_key', array(
        'methods' => \WP_REST_Server::EDITABLE,
        'callback' => "printdoors\Admin\set_access_key",
        'show_in_index' => false,
        'permission_callback' => '__return_true',
        'args' => array(
            'accessKey' => array(
                'required' => true,
                'type' => 'string',
                'description' => 'Printdoors access key',
            ),
            'verification' => array(
                'required' => true,
                'type' => 'string',
                'description' => 'Printdoors verification',
            ),
            'storeId' => array(
                'required' => true,
                'type' => 'integer',
                'description' => 'Store Identifier'
            ),
        ),
    ));
    register_rest_route(PRINTDOORS_NAMESPACE, '/clear_all', array(
        'methods' => \WP_REST_Server::READABLE,
        'callback' => "printdoors\Admin\clear_all",
        'show_in_index' => false,
        'permission_callback' => '__return_true'
    ));
}

function set_access_key($request)
{
    $verification = $request['verification'];
    $code = get_option('printdoors_code');
    if ($verification != md5($request['accessKey'] . $request['storeId'] . $code)) {
        return new \WP_Error('invalid verification', 'invalid verification');
    }
    add_option('printdoors_access_key', $request['accessKey']);
    add_option('printdoors_store_id', $request['storeId']);
    return rest_ensure_response('ok');
}

function clear_all($request)
{
    // $accessKey = get_option('printdoors_code');
    // if ($accessKey != $request['token']) {
    //     return new \WP_Error('invalid token', 'invalid token');
    // }
    delete_option('printdoors_code');
    delete_option('printdoors_access_key');
    delete_option('printdoors_store_id');
    return rest_ensure_response('ok');
}

// function test($request)
// {
//     return rest_ensure_response(md5("+"));
// }

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if (!$length) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}
