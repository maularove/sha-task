<?php

use App\Shatask\Controllers\ListasDeletePostController;
use App\Shatask\Controllers\ListasGetController;
use App\Shatask\Controllers\ListasSavePostController;
use App\Shatask\Controllers\TareasDeletePostController;
use App\Shatask\Controllers\TareasGetController;
use App\Shatask\Controllers\TareasSavePostController;
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
            $group->post('/listas-delete', ListasDeletePostController::class)->setName('shatask.listas.post.delete');
            $group->get('/listas/{lista_id}', TareasGetController::class)->setName('shatask.tareas.get.list');
            $group->post('/listas/tarea-save', TareasSavePostController::class)->setName('shatask.tareas.post.save');
            $group->post('/listas/tarea-delete', TareasDeletePostController::class)->setName('shatask.tareas.post.delete');
            // $group->get('/departamentos', DepartmentListGetController::class)->setName('adminrrhh.department.get.list');
            // $group->get('/empresas', CompanyListGetController::class)->setName('adminrrhh.company.get.list');
            // $group->get('/configuracion_mailing', MailingListGetController::class)->setName('adminrrhh.mailing.get.list');
            // $group->get('/config', ConfigGetController::class)->setName('adminrrhh.config.get');
        })->add(AuthMiddleware::class);
    });
};