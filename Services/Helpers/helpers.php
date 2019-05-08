<?php

// include a view
function view(string $view, array $data = [])
{
    if (getenv('TEMPLATING_ENGINE') == 'Blade') {
        return bladeView($view, $data);
    } else {
        return pugView($view, $data);
    }
}

function bladeView(string $view, array $data = [])
{
    container()->build('Blade', '../App/Views', '../cache/blade');
    return container()->Blade->make($view, $data);
}

function pugView(string $view, array $data = [])
{
    container()->build('Pug', [
        'expressionLanguage' => 'php',
        'cache'              => '../cache/pug',
        'basedir'            => '../App/Views',
        ]);

    return container()->Pug->render("../App/Views/$view.pug", $data);
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
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
    header('Location: '.$host.$url);
}
// reidrect to an external url
function redirect(string $url)
{
    header('Location: '.$url);
}

function setSession(string $key, string $value)
{
    container()->Response->session->set($key, $value);
}

function getSession(string $key)
{
    return container()->Response->session->get($key);
}

function destroySession(string $key)
{
    container()->Response->session->destroy($key);
}

function destroyAllSessions()
{
    container()->Response->session->destroyAll();
}

function setNewCookie(sting $key, string $value, string $date)
{
    container()->Response->cookie->set($key, $value, $date);
}

function getCookie(string $key)
{
    return container()->Resonse->cookie->get($key);
}

function destroyCookie(string $key)
{
    container()->Response->cookie->destroy($key);
}

function destroyAllCookies()
{
    container()->Response->cookie->destroyAll();
}

function language(string $language = null)
{
    if ($language === null) {
        return cookie('_language') ?? 'en';
    }
    if (is_string($language)) {
        cookie('_language', $language, time()+3600*24*30);
        return cookie('_language');
    }
}

function translation(string $languageFile)
{
    return \Services\LanguagesResolver::resolve($languageFile);
}

function csrf_field()
{
    if (isset(container()->Response->session->_token)) {
        $token = container()->Response->session->_token;
    } else {
        $token = uniqid(random_int(0, 1000));
    }
    container()->Response->session->set('_token', $token);
    echo "<input type='hidden' name='_token' value='".$token."'>";
}

function csrf_token()
{
    return container()->Response->session->_token;
}

function generate_csrf_token()
{
    container()->Response->session->set('_token', uniqid(random_int(0, 1000)));
    return container()->Response->session->_token;
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
