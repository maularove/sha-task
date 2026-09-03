# SHA-TASK

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![Slim](https://img.shields.io/badge/Slim-4.x-74B52E?logo=slim&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-10.x-003545?logo=mariadb&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)
![PHPUnit](https://img.shields.io/badge/Testing-PHPUnit-3C9CD7?logo=php&logoColor=white)

## 📋 Descripción

**SHA Task** es una aplicación web desarrollada como **Proyecto Final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW)**.

El proyecto está orientado a la gestión de tareas y usuarios, proporcionando una aplicación web estructurada y preparada para ejecutarse mediante un entorno Dockerizado.

Durante su desarrollo se trabajó tanto en la implementación de funcionalidades como en la organización de la aplicación, persistencia de datos, validación, testing y separación de responsabilidades.

El proyecto representa una aplicación completa desarrollada de principio a fin, desde la configuración del entorno y la base de datos hasta la implementación de la lógica de negocio y la interfaz web.

---

## ✨ Características

- Gestión de usuarios.
- Autenticación de usuarios.
- Gestión y organización de tareas.
- Persistencia de información mediante base de datos relacional.
- Interfaz web basada en plantillas.
- Validación de datos.
- Gestión de errores.
- Separación de responsabilidades dentro de la aplicación.
- Tests automatizados.
- Análisis estático del código.
- Comprobación de estándares de código.
- Entorno de desarrollo reproducible mediante Docker Compose.

> Las funcionalidades pueden variar según la configuración y versión actual del proyecto.

---

## 🛠️ Tecnologías utilizadas

### Backend

- **PHP**
- **Slim Framework 4**
- **Composer**

### Frontend

- **HTML5**
- **CSS3**
- **JavaScript**
- **Twig**

### Base de datos

- **MariaDB / MySQL**

### Testing y calidad del código

- **PHPUnit**
- **PHPStan**
- **PHP_CodeSniffer**

### Entorno y herramientas

- **Docker**
- **Docker Compose**
- **Git**
- **Visual Studio Code**

---

## 🏗️ Arquitectura

El proyecto está organizado siguiendo una separación de responsabilidades entre diferentes capas de la aplicación.

```text
src/
├── Application/
├── Domain/
└── Infrastructure/
    └── Persistence/
