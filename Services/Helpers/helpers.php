<?php

// include a view
function view(string $view, array $data = [])
{
    container()->build('Blade', '../App/Views', '../cache/blade');
    return container()->Blade->make($view, $data);
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
    container()->Session->set($key, $value);
}

function getSession(string $key)
{
    return container()->Session->$key;
}

function destroySession(string $key)
{
    container()->Session->delete($key);
}

function destroyAllSessions()
{
    container()->Session->deleteAll();
}

function setNewCookie(string $key, string $value, string $date)
{
    container()->Cookie->set($key, $value, $date);
}

function getCookie(string $key)
{
    return container()->Cookie->$key;
}

function destroyCookie(string $key)
{
    container()->Cookie->delete($key);
}

function destroyAllCookies()
{
    container()->Cookie->deleteAll();
}

function setLanguage(string $language): void
{
    setNewCookie('_language', $language, time()+3600*24*364);
}

function getLanguage(): string
{
    return getCookie('_language') ?? 'en';
}

function translation(string $languageFile)
{
    return \Services\LanguagesResolver::resolve($languageFile);
}

function csrf_field()
{
    if (getSession('_token')) {
        $token = getSession('_token');
    } else {
        $token = uniqid(random_int(0, 1000));
    }
    setSession('_token', $token);
    echo "<input type='hidden' name='_token' value='".$token."'>";
}

function csrf_token()
{
    return getSession('_token');
}

function generate_csrf_token()
{
    setSession('_token', uniqid(random_int(0, 1000)));
    return getSession('_token');
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
