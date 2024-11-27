=== Contact Button for WooCommerce ===
Contributors: theradix  
Stable Tag: 1.3
Tags: WooCommerce, contact, button, shortcode, customizable  
Requires at least: 5.0  
Tested up to: 6.7  
Requires PHP: 7.4  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

Agrega un botón de contacto en las páginas de productos de WooCommerce, permitiendo personalizar el mensaje, colores y más.

== Descripción ==
Contact Button for WooCommerce es un plugin que permite a los usuarios agregar un botón de contacto mediante whatsapp en las páginas de productos de WooCommerce. Este botón facilita que los clientes se comuniquen directamente con el vendedor para consultar sobre un producto específico.

### Características principales:
- Personaliza el número de contacto.
- Personaliza el texto del botón.
- Personaliza el mensaje que se envía, incluyendo etiquetas dinámicas:
  - `{product_name}`: Reemplazada por el nombre del producto.
  - `{product_url}`: Reemplazada por el enlace al producto.
- Cambia los colores del botón (fondo y texto).
- Restaura los valores predeterminados fácilmente desde la configuración.
- Incluye un shortcode: `[contact_button]`.

### Ejemplo del mensaje predeterminado:
`Hola, estoy interesado en el producto: {product_name} ({product_url})`

== Instalación ==
1. Sube los archivos del plugin a la carpeta `/wp-content/plugins/` o instala el plugin directamente desde el repositorio de WordPress.
2. Activa el plugin desde el menú "Plugins" en WordPress.
3. Ve a "Configuración > Botón de Contacto" para personalizar las opciones del botón.

== Uso ==
### Agregar el botón en una página de producto:
Utiliza el shortcode `[contact_button]` en la descripción del producto o cualquier otra área donde desees mostrar el botón.

### Personalizar el mensaje:
En la configuración del plugin, puedes personalizar el texto del mensaje utilizando las etiquetas `{product_name}` y `{product_url}`.

== FAQ ==
### ¿Este plugin funciona con cualquier tema?
Sí, el plugin es compatible con cualquier tema que soporte WooCommerce.

### ¿Puedo usar este plugin en sitios multilingües?
Sí, pero el mensaje personalizado no se traduce automáticamente. Puedes usar un plugin de traducción como WPML para personalizar mensajes en diferentes idiomas.

### ¿Qué sucede si no configuro un número de contacto?
El botón no se mostrará, y el usuario verá un mensaje solicitando configurar el número en las opciones del plugin.

== Changelog ==
### 1.3
- **Novedad**: Ahora puedes personalizar el mensaje enviado al cliente, con soporte para etiquetas dinámicas `{product_name}` y `{product_url}`.
- **Mejora**: Botón para restaurar valores predeterminados en la configuración.
- **UI**: Se agregó una sección de ayuda en la configuración.

### 1.2
- **Mejora**: Personalización de colores para el botón.
- **Novedad**: Shortcode `[contact_button]` para mayor flexibilidad.

### 1.1
- **Mejora**: Estilos básicos para el botón de contacto.

### 1.0
- **Lanzamiento inicial**: Botón de contacto en las páginas de productos de WooCommerce.

== License ==
Este plugin está licenciado bajo la **GPLv2 o posterior**. Para más información, consulta la [licencia GPLv2](https://www.gnu.org/licenses/gpl-2.0.html).
