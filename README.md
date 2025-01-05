# Proyecto: Tenedor4v

## Descripción
Este proyecto es una aplicación web desarrollada en PHP con arquitectura MVC y una capa de persistencia para gestionar una base de datos de restaurantes. Está inspirado en "El Tenedor". Permite listar, crear, editar, eliminar y buscar restaurantes, gestionar categorías y reservas, además de incluir un sistema de autenticación de usuarios.

---

## Pasos para ejecutar el proyecto

### 1. **Requisitos previos**
- Tener instalado **XAMPP** o similar para ejecutar Apache y MySQL.
- Tener instalado **NetBeans IDE** con soporte para PHP.
- Contar con un entorno compatible con PHP 7.4 o superior.
- Tener configurado **Git**.

---

### 2. **Configuración inicial**
1. **Base de Datos**:
   - Iniciar el servidor MySQL desde el panel de control de XAMPP.
   - Importar el archivo `bd.sql` en MySQL para crear la base de datos `tenedor4vbd`.
   - Verifica que se han creado las tablas necesarias: `restaurant`, `category`, `users`, `reservations`, etc.

2. **Servidor Apache**:
   - Iniciar Apache desde el panel de control de XAMPP.
   - Configurar la carpeta del proyecto en `htdocs` (por ejemplo, `/xampp/htdocs/tenedor4v`).

3. **Clonar el repositorio**:
   - Clona el proyecto desde el repositorio GIT que hayas configurado:
     ```bash
     git clone <URL_DEL_REPOSITORIO>
     ```
   - Asegúrate de que el proyecto se encuentra en la carpeta raíz configurada para Apache.

---

### 3. **Ejecución del proyecto**
1. Abre el proyecto en **NetBeans**.
2. Configura el proyecto como aplicación PHP en NetBeans:
   - Ve a `Propiedades del Proyecto > Configuración`.
   - Asegúrate de que la URL del proyecto apunta a: `http://localhost/tenedor4v`.
3. Accede a la URL desde el navegador para cargar la aplicación: http://localhost/tenedor4v

---

## Funcionalidades principales
### 1. **Gestión de Restaurantes**
- **Listar restaurantes**: Se muestran con imagen, nombre, precio del menú y descripción.
- **Crear restaurantes**: Validaciones obligatorias en controlador (URL de imagen válida, rango de precio, etc.).
- **Editar restaurantes**: Peticiones GET y POST para obtener y actualizar datos.
- **Borrar restaurantes**: Solo accesible para usuarios administradores.

### 2. **Gestión de Categorías**
- Crear y asignar categorías a los restaurantes.
- Búsqueda por categoría con consultas directas a la base de datos.

### 3. **Sistema de Autenticación y Roles**
- Usuarios:
- **Sin identificar**: Solo pueden ver restaurantes y reservar.
- **Gestor**: Puede crear y modificar restaurantes.
- **Admin**: Puede realizar todas las acciones, incluido borrar.
- Gestión de sesión:
- Almacena nombre y rol del usuario autenticado.

### 4. **Reservas**
- Los usuarios pueden reservar en restaurantes indicando:
- Fecha y hora (válida según las reglas: 14:00 o 21:00, fechas futuras).
- Número de comensales (máximo 10).

---

## Notas importantes
1. **Validaciones**:
- Todas las validaciones se realizan en los controladores, no en las vistas.
2. **Errores**:
- Si hay errores (validaciones, permisos, etc.), se mostrarán mensajes adecuados o se redirigirá a una página de error.
3. **Estructura del Proyecto**:
- **app/controllers**: Controladores principales (restaurantes, reservas, categorías).
- **app/views**: Vistas públicas y privadas.
- **persistencia/DAO**: Capa de acceso a datos.
- **bd**: Archivos relacionados con la base de datos.
- **conf**: Configuración general.

---

## Licencia
Proyecto desarrollado como parte de la Evaluación de Recuperación de Desarrollo Web para 2 DAM.
