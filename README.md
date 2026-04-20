# Sistema CRUD de Bodegas

Aplicación web desarrollada en PHP puro con PostgreSQL para la gestión de bodegas y sus encargados.

---

## Tecnologías utilizadas

- PHP (sin frameworks)
- PostgreSQL
- HTML + Bootstrap 5
- PDO (conexión a base de datos)
- Arquitectura MVC básica
- XAMPP (Apache)

---

## Funcionalidades

### Bodegas

- Crear bodegas
- Listar bodegas
- Editar bodegas
- Eliminar bodegas
- Filtrar por estado (activas/inactivas)

### Encargados

- Asignación de múltiples encargados a una bodega (relación N:M)
- Visualización de encargados asociados

---

## Modelo de datos

- **bodegas**
- **encargados**
- **bodega_encargado** (tabla intermedia N:M)

Incluye restricciones:

- PRIMARY KEY
- FOREIGN KEY
- UNIQUE (código de bodega)
- CHECK (dotación > 0)
- ON DELETE CASCADE

---

## Arquitectura

El proyecto sigue un patrón tipo MVC básico:

- /models -> lógica de base de datos
- /controllers -> lógica de aplicación
- /views -> interfaz de usuario
- /config -> conexión a base de datos
- /index.php -> enrutador principal

---

## Instalación

1. Clonar el repositorio:

git clone https://github.com/Georgakis1/bodega-app

2. Importar base de datos en PostgreSQL

3. Configurar archivo .env

4. Ejecutar con XAMPP: http://localhost/bodega-app/

## Validaciones

# Validación de campos obligatorios

    Restricción de código único
    Validación de dotación mayor a 0
    Manejo de errores con mensajes al usuario

# Flujo de la aplicación

    Usuario accede al listado de bodegas
    Puede crear, editar o eliminar registros
    Cada bodega puede tener múltiples encargados
    Los datos se sincronizan con la base de datos en tiempo real

# Notas

    Proyecto desarrollado sin frameworks para fines académicos
    Se priorizó la lógica backend y el diseño de base de datos
    Bootstrap utilizado solo para mejorar la presentación visual

## Autor

    Georgios Geldres
