<?php

use App\Shatask\Controllers\ListasGetController;
use App\Shatask\Middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/*
 * ADMINRRHH APP ROUTES
 */

 return function (App $app): void {
    $app->group('/shatask', function (RouteCollectorProxy $group): void {
        /* Public ROUTES */
        // $group->get('/login', LoginGetController::class)->setName('adminrrhh.login.get');
        // $group->get('/logout', LogoutPostController::class)->setName('adminrrhh.logout');
        // $group->post('/auth', LoginPostController::class)->setName('adminrrhh.auth');

        /* MIGRATIONS */
        // $group->get('/executeMigrations/{token}[/{first}]', ExecuteMigrationsController::class);


        /* Authenticated ROUTES */
        $group->group('', function (RouteCollectorProxy $group): void {
            $group->get('/', ListasGetController::class)->setName('shatask.lista.get');
            // $group->get('/exportar_excel', ExportGetController::class)->setName('adminrrhh.export_excel');
            // $group->get('/departamentos', DepartmentListGetController::class)->setName('adminrrhh.department.get.list');
            // $group->get('/empresas', CompanyListGetController::class)->setName('adminrrhh.company.get.list');
            // $group->get('/configuracion_mailing', MailingListGetController::class)->setName('adminrrhh.mailing.get.list');
            // $group->get('/config', ConfigGetController::class)->setName('adminrrhh.config.get');
        })->add(AuthMiddleware::class);
    });
};