<div align="center">

# SHA-TASK

**Gestor de tareas y listas — Proyecto Final de Ciclo (DAW)**

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![Slim](https://img.shields.io/badge/Slim-4.x-74B52E?logo=slim&logoColor=white)
![Twig](https://img.shields.io/badge/Twig-templates-B41717?logo=twig&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.5-7952B3?logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-relational_DB-4479A1?logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)

</div>

---

## 📋 Descripción

**SHA-TASK** es una aplicación web de gestión de tareas desarrollada como **Proyecto
Final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW)**.

El objetivo es ofrecer una agenda virtual sencilla donde cualquier usuario pueda
registrar, organizar y consultar sus tareas pendientes y completadas, evitando
depender únicamente de la memoria. La interfaz se diseñó de forma minimalista,
priorizando la claridad y evitando la saturación visual.

Es un proyecto realizado de principio a fin: desde el diseño de la base de datos y
la configuración del entorno con Docker, hasta la implementación del backend en PHP
(Slim Framework) y del frontend con Twig, Bootstrap y JavaScript.

> Desarrollado por **Mauro Adrián Lara Ovejero**, alumno del CIPFP Mislata,
> como parte del ciclo de Grado Superior en Desarrollo de Aplicaciones Web,
> mientras continúa sus estudios de Ingeniería Informática.

---

## ✨ Funcionalidades

- **Registro e inicio de sesión** de usuarios (usuario + contraseña).
- **Gestión de listas de tareas**: crear, renombrar y eliminar listas propias.
- **Visualización de listas** en la pantalla principal, representadas como tarjetas.
- **Gestión de tareas** dentro de cada lista: crear, editar, eliminar y marcar como completadas.
- **Organización por estado**: las tareas se dividen en *Por hacer* y *Hechas*, con cambio de estado mediante checkbox.
- **Detalle de tarea**: al pulsar sobre una tarea se muestra su descripción completa.
- **Acciones mediante modales** (crear/editar/eliminar listas y tareas) para una experiencia de uso más fluida.
- **Cierre de sesión** disponible desde cualquier punto de la aplicación.

---

## 🖼️ Capturas de pantalla

| Login | Home — Mis listas |
|---|---|
| ![Login](./screenshots/01-login.png) | ![Home](./screenshots/02-home-listas.png) |

| Vista de lista (Por hacer / Hechas) | Crear nueva tarea |
|---|---|
| ![Vista de lista](./screenshots/03-vista-lista.png) | ![Crear tarea](./screenshots/04-crear-tarea.png) |

---

## 🛠️ Tecnologías utilizadas

**Backend**
- PHP + [Slim Framework](https://www.slimframework.com/) (microframework para APIs y rutas HTTP)
- Composer (gestión de dependencias)

**Frontend**
- HTML5, CSS3, JavaScript
- [Twig](https://twig.symfony.com/) como motor de plantillas
- [Bootstrap](https://getbootstrap.com/) 5.3.5

**Base de datos**
- MySQL

**Infraestructura**
- Docker + Docker Compose (entorno de desarrollo reproducible: app, base de datos, phpMyAdmin)
- Git

---

## 🏗️ Arquitectura

El proyecto sigue una organización en capas dentro de `app/`, separando
responsabilidades para facilitar el mantenimiento y la escalabilidad:

```
docker/                 # Configuración de contenedores Docker
app/
├── Controllers/         # Controladores: gestionan las peticiones HTTP
├── Middlewares/          # p.ej. AuthMiddleware: control de acceso por autenticación
├── Models/               # Entidades de datos de la aplicación
├── Repositories/         # Abstracción del acceso a datos / BD
├── Services/             # Lógica de negocio reutilizable
└── routes.php            # Definición de rutas -> controladores/middlewares
config/
├── bootstrap.php         # Arranque de la app (DI, sesión, rutas, Twig)
├── Container.php         # Contenedor de dependencias (Slim, BD, Twig, SMTP, CSRF...)
├── Dependencies.php       # Inyección del logger (Monolog)
└── Settings.php           # Configuración por entorno
db/ SQL/                 # Migraciones, seeds y scripts SQL
public/                  # Punto de entrada público, estáticos y assets
templates/                # Vistas Twig (layout + plantillas)
docker-compose.yml
composer.json / package.json
```

---

## 🚀 Puesta en marcha

```bash
# 1. Clonar el repositorio
git clone https://github.com/maularove/sha-task.git
cd sha-task

# 2. Instalar dependencias
composer install
npm install

# 3. Levantar el entorno con Docker
docker compose up -d

# 4. Acceder a la aplicación
# revisa docker-compose.yml para el puerto expuesto (p. ej. http://localhost:8080)
```

> Ajusta las variables de entorno necesarias (base de datos, etc.) antes del primer arranque.

---

## 🔭 Próximas mejoras

Algunas funcionalidades quedaron identificadas para futuras iteraciones:

- Registro de nuevos usuarios totalmente operativo y recuperación de contraseña.
- Requisitos de seguridad más estrictos para las contraseñas.
- Alertas informativas sobre el resultado de cada acción.
- Recordatorios y tareas recurrentes, con calendario integrado.
- Compartir listas/tareas con otros usuarios.
- Rediseño de interfaz más moderno y fluido.
- Sistema de logros y recompensas.

---

## 📄 Licencia

Consulta el archivo [`CONTRIBUTING.md`](./CONTRIBUTING.md) del repositorio para las
pautas de contribución. La memoria académica del proyecto se publica bajo licencia
[Creative Commons BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/deed.es).
