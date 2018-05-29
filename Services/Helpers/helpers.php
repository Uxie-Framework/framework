<?php

// include a view
function view(string $view, array $data = [])
{
    if (getenv('TEMPLATING_ENGINE') == 'Blade') {
        bladeView($view, $data);
    } else {
        pugView($view, $data);
    }
}

function bladeView(string $view, array $data = [])
{
    container()->build('Blade', ['../App/Views', '../cache/blade']);
    echo container()->Blade->make($view, $data);
}

function pugView(string $view, array $data = [])
{
    container()->build('Pug', [[
        'expressionLanguage' => 'php',
        'cache'              => '../cache/pug',
        'basedir'            => '../App/Views',
        ]]);

    echo container()->Pug->render("../App/Views/$view.pug", $data);
}

// return full valide url (inside application)
function url(string $url)
{
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';

    return $host.$url;
}
// redirect to a specific url (inside application);
function route(string $url)
{
    ob_start();
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
    header('Location: '.$host.$url);
}
// reidrect to an external url
function redirect(string $url)
{
    ob_start();
    header('Location: '.$url);
}

function session($key, $value = null)
{
    ob_start();
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!$value && isset($_SESSION[$key])) {
        return $_SESSION[$key] ?? false;
    }
    if ($value) {
        return $_SESSION[$key] = $value;
    }

    return null;
}

function unsetSession($key)
{
    session_start();
    unset($_SESSION[$key]);
}

function cookie($key, $value = null, $time = null)
{
    ob_start();
    if ($value && $time) {
        return setcookie($key, $value, $time);
    }
    if ($value && !$time) {
        return setcookie($key, $value);
    }
    if (!$value && !$time) {
        return $_COOKIE[$key] ?? null;
    }

    throw new \Exception("Cookie function can't resolve of the given arguments", 21);

}

function unsetCookie($key)
{
    setcookie($key, '', time() - 1);
}

function language(string $language = null)
{
    if ($language === null) {
        return cookie('_language') ?? 'en';
    }
    if (!is_string($language)) {
        return cookie('_language', $language, time()+3600*24);
    }
}

function translation(string $languageFile)
{
    return \Services\LanguagesResolver::resolve($languageFile);
}

function csrf_field()
{
    $token = session('_token') ?? uniqid(random_int(0, 1000));
    session('_token', $token);
    echo "<input type='hidden' name='_token' value='".$token."'>";
}

function csrf_token()
{
    return session('_token');
}

function method_field(string $method)
{
    echo "<input type='hidden' name='_method' value='$method' />";
}

function container()
{
    return IOC\IOC::container();
}

// get aliases using aliases service
function getAliase(string $aliase)
{
    return \Services\AliasesResolver::resolve($aliase);
}

function rootDir()
{
    return $_SERVER['DOCUMENT_ROOT'].'/../';
}

function previousUrl()
{
    return $_SERVER['HTTP_REFERER'] ?? '';
}

function currentUrl()
{
    return $_SERVER['REQUEST_URI'];
}
