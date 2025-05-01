<?php

use App\Shatask\Controllers\ListasGetController;
use App\Shatask\Controllers\ListasSavePostController;
use App\Shatask\Middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Shatask\Controllers\Auth\LoginGetController;
use App\Shatask\Controllers\Auth\LoginPostController;
use App\Shatask\Controllers\Auth\LogoutPostController;

/*
 * SHATASK APP ROUTES
 */

 return function (App $app): void {
    $app->group('/shatask', function (RouteCollectorProxy $group): void {
        /* Public ROUTES */
        $group->get('/login', LoginGetController::class)->setName('shatask.login.get');
        $group->get('/logout', LogoutPostController::class)->setName('shatask.logout');
        $group->post('/auth', LoginPostController::class)->setName('shatask.auth');

        /* MIGRATIONS */
        // $group->get('/executeMigrations/{token}[/{first}]', ExecuteMigrationsController::class);


        /* Authenticated ROUTES */
        $group->group('', function (RouteCollectorProxy $group): void {
            $group->get('/listas', ListasGetController::class)->setName('shatask.listas.get.list');
            $group->post('/listas-save', ListasSavePostController::class)->setName('shatask.listas.post.save');
            // $group->get('/departamentos', DepartmentListGetController::class)->setName('adminrrhh.department.get.list');
            // $group->get('/empresas', CompanyListGetController::class)->setName('adminrrhh.company.get.list');
            // $group->get('/configuracion_mailing', MailingListGetController::class)->setName('adminrrhh.mailing.get.list');
            // $group->get('/config', ConfigGetController::class)->setName('adminrrhh.config.get');
        })->add(AuthMiddleware::class);
    });
};