<?php
/**
 * @noinspection PhpIncludeInspection
 * @noinspection PhpUnused
 */

use App\Components\DateTime\Now;
use App\Components\Env\EnvFile;
use App\Components\Http\SingletonRequest;
use App\Components\Http\Url;
use App\Components\Routers\GenerateRouter;
use App\Components\View\View;

/**
 * @param $function
 * @return bool
 */
function fn_e($function)
{
    return function_exists($function);
}

function db_path($file)
{
    $relative = implode(DIRECTORY_SEPARATOR, ['Database', $file]);
    return base_path($relative);

}

function base_path($file = null)
{
    return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $file;
}

/**
 * @param $file
 * @param array $params
 * @return false|string
 * @return false|string
 */
function view($file, $params = [])
{
    return (new View($file, $params))->compile();
}

function dd($param)
{
    var_dump($param);
    die();
}

function abort($status)
{
    http_response_code(404);
    view($status);
    die();
}

/**
 * @param null $name
 * @return mixed|Session|string|null
 */
function session($name = null)
{
    $session = new Session();
    if ($name === null) {
        return $session;
    }
    return $session->get($name);

}

/**
 * @return Url
 */
function url()
{
    return new Url();
}

/**
 * @param $file
 * @return string
 */
function assets($file)
{
    return sprintf('%s/public/%s', \url()->base(), trim($file, '/'));
}

/**
 * @param $name
 * @param array $parameters
 * @return string
 */
function router($name, array $parameters = [])
{
    return (new GenerateRouter())->url($name, $parameters);
}

/**
 * @param $str
 * @return string
 */
function snakeToCamel($str)
{
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
}

/**
 * @param $string
 * @return string
 */
function pascal_to_snake($string)
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
}


/**
 * @param null $name
 * @return App|mixed
 */
function app($name = null)
{
    $app = new App();
    return $name === null ? $app : $app->get($name);
}

/**
 * @param string|null $view
 * @return string
 */
function view_path(?string $view = null)
{
    $viewPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'Views';
    if ($view === null) {
        return $viewPath;
    }
    return $viewPath . DIRECTORY_SEPARATOR . trim("$view.blade.php", '/');
}

/**
 *
 */
function activate_errors()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

/**
 * @return SingletonRequest
 */
function request()
{
    return SingletonRequest::getInstance();
}

function env($name,$default=null)
{

    return (new EnvFile('.env'))->getValue($name) ?: $default;

}

function now()
{
    return new Now();
}