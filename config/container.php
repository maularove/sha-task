<?php

use App\Shatask\Services\AuthService;
use App\Shared\Helpers\DB;
use App\Shared\Helpers\DBSAAS;
use App\Shared\Services\LanguageService;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Twig\TwigFunction;
use Slim\Middleware\ErrorMiddleware;

return [
    'settings' => fn() => require __DIR__ . '/settings.php',

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    DB::class => function (ContainerInterface $container) {
        $dbname = $container->get('settings')['db']['name'];
        $user = $container->get('settings')['db']['user'];
        $pass = $container->get('settings')['db']['pass'];
        $host = $container->get('settings')['db']['host'];
        $charset = $container->get('settings')['db']['charset'];

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset",
        ];

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';';

        return new DB($dsn, $user, $pass, $opt);
    },

    Flash::class => function () {
        $storage = [];

        return new Flash($storage);
    },

    Twig::class => function (ContainerInterface $c, Flash $flash, AuthService $authService, LanguageService $languageService) {
        $settings = $c->get('settings');
        $templates = [];
        // Obtenemos el nombre del namespace de los templates
        foreach (glob('../templates/*', GLOB_ONLYDIR) as $dir) {
            $parts = explode('/', $dir);
            $templates[$parts[2]] = $dir;
        }

        $twig = Twig::create($templates);
        $twig->getEnvironment()->addGlobal('uploads_paths', $settings['twig']['uploads']);

        $twig->getEnvironment()->addGlobal('flash', $flash);

        $isCurrentUri = new TwigFunction('is_current_uri', fn($uri) => str_contains($_SERVER['REQUEST_URI'], $uri));

        $twig->getEnvironment()->addFunction($isCurrentUri);

        $absoluteUrl = new TwigFunction('absolute_url', fn() => $_SERVER['HTTP_HOST']);

        $twig->getEnvironment()->addFunction($absoluteUrl);

        $fullPath = new TwigFunction('full_path', function () use ($c, $settings) {
            $secure = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 's' : '';
            $domain = 'http' .  $secure . '://' . $_SERVER['HTTP_HOST'];

            return $domain . $_ENV['APP_DIRECTORY'];
        });

        $twig->getEnvironment()->addFunction($fullPath);

        $textLang = new TwigFunction('text_lang', fn($key) => $languageService->getText($key));

        $twig->getEnvironment()->addFunction($textLang);

        $lang = new TwigFunction('lang', fn() => $languageService->getLanguage());

        $twig->getEnvironment()->addFunction($lang);

        return $twig;
    },

    Mailer::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['smtp'];

        $transport = new EsmtpTransport(
            $settings['host'],
            $settings['port'],
            // $settings['encryption']
        );

        $transport->setUsername($settings['username']);
        $transport->setPassword($settings['password']);

        return new Mailer($transport);
    },

    'csrf' => function (ContainerInterface $c) {
        $app = $c->get(App::class);
        $responseFactory = $app->getResponseFactory();

        return new Guard($responseFactory);
    },

    BodyRenderer::class => function (ContainerInterface $c) {
        $twigEnv = $c->get(Twig::class)->getEnvironment();

        return new BodyRenderer($twigEnv);
    }
];
