<?php

use App\Shatask\Controllers\ListasGetController;
use App\Shatask\Middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Shatask\Controllers\Auth\LoginGetController;
use App\Shatask\Controllers\Auth\LoginPostController;

/*
 * SHATASK APP ROUTES
 */

 return function (App $app): void {
    $app->group('/shatask', function (RouteCollectorProxy $group): void {
        /* Public ROUTES */
        $group->get('/login', LoginGetController::class)->setName('shatask.login.get');
        $group->post('/auth', LoginPostController::class)->setName('shatask.auth');
        // $group->get('/logout', LogoutPostController::class)->setName('adminrrhh.logout');

        /* MIGRATIONS */
        // $group->get('/executeMigrations/{token}[/{first}]', ExecuteMigrationsController::class);


        /* Authenticated ROUTES */
        $group->group('', function (RouteCollectorProxy $group): void {
            $group->get('/', ListasGetController::class)->setName('shatask.listas.get.list');
            // $group->get('/departamentos', DepartmentListGetController::class)->setName('adminrrhh.department.get.list');
            // $group->get('/empresas', CompanyListGetController::class)->setName('adminrrhh.company.get.list');
            // $group->get('/configuracion_mailing', MailingListGetController::class)->setName('adminrrhh.mailing.get.list');
            // $group->get('/config', ConfigGetController::class)->setName('adminrrhh.config.get');
        })->add(AuthMiddleware::class);
    });
};