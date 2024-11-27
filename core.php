<?php
/*
Plugin Name: Contact Button for WooCommerce
Description: Agrega un botón de contacto mediante whatsapp en los productos de WooCommerce mediante un shortcode. [contact_button]
Version: 1.3
Author: Theradix
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Crear la página de configuración
function cbb_add_settings_page()
{
    add_menu_page(
        'Configuración del Botón de Contacto',
        'Botón de Contacto',
        'manage_options',
        'cbb_settings',
        'cbb_render_settings_page',
        'dashicons-phone',
        20
    );
}
add_action('admin_menu', 'cbb_add_settings_page');

function cbb_render_settings_page()
{
    if (isset($_POST['cbb_reset_defaults']) && check_admin_referer('cbb_settings_action', 'cbb_settings_nonce')) {
        cbb_restore_defaults();
        echo '<div class="notice notice-success is-dismissible"><p>Se han restaurado los valores predeterminados.</p></div>';
    }

?>
    <div class="wrap">
        <h1>Configuración del Botón de Contacto</h1>
        <div style="display: flex; gap: 20px;">
            <form method="post" action="options.php" style="flex: 2;">

                <?php
                settings_fields('cbb_settings_group');
                do_settings_sections('cbb_settings');
                ?>
                <?php wp_nonce_field('cbb_settings_action', 'cbb_settings_nonce'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Número de Contacto</th>
                        <td><input type="text" name="cbb_contact_number" value="<?php echo esc_attr(get_option('cbb_contact_number')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Texto del Botón</th>
                        <td><input type="text" name="cbb_button_text" value="<?php echo esc_attr(get_option('cbb_button_text', 'Contactar ahora')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Texto del Mensaje</th>
                        <td><textarea name="cbb_message_text" rows="3"><?php echo esc_attr(get_option('cbb_message_text', 'Hola, estoy interesado en el producto: {product_name} ({product_url})')); ?></textarea></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Color de Fondo</th>
                        <td><input type="color" name="cbb_button_bg_color" value="<?php echo esc_attr(get_option('cbb_button_bg_color', '#25D366')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Color de Texto</th>
                        <td><input type="color" name="cbb_button_text_color" value="<?php echo esc_attr(get_option('cbb_button_text_color', '#FFFFFF')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>

            <div style="flex: 1; background: #f9f9f9; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                <h2>Ayuda</h2>
                <p>En el campo "Texto del Mensaje", puedes utilizar las siguientes etiquetas:</p>
                <ul>
                    <li><code>{product_name}</code>: Será reemplazado por el nombre del producto.</li>
                    <li><code>{product_url}</code>: Será reemplazado por el enlace al producto.</li>
                </ul>
                <p>Ejemplo:</p>
                <pre>Hola, estoy interesado en el producto: {product_name} ({product_url})</pre>
                <p>Este mensaje se personalizará automáticamente según el producto en el que esté el cliente.</p>
            </div>
        </div>
    </div>
<?php
}

// Registrar las opciones
function cbb_register_settings()
{
    register_setting('cbb_settings_group', 'cbb_contact_number');
    register_setting('cbb_settings_group', 'cbb_button_text');
    register_setting('cbb_settings_group', 'cbb_message_text');
    register_setting('cbb_settings_group', 'cbb_button_bg_color');
    register_setting('cbb_settings_group', 'cbb_button_text_color');
}
add_action('admin_init', 'cbb_register_settings');

// Restaurar valores predeterminados
function cbb_restore_defaults()
{
    check_admin_referer('cbb_reset_defaults', 'cbb_reset_defaults_nonce');

    update_option('cbb_contact_number', '');
    update_option('cbb_button_text', 'Contactar ahora');
    update_option('cbb_message_text', 'Hola, estoy interesado en el producto: {product_name} ({product_url})');
    update_option('cbb_button_bg_color', '#25D366');
    update_option('cbb_button_text_color', '#FFFFFF');
}

// Generar el shortcode del botón
function cbb_contact_button_shortcode()
{
    $contact_number = get_option('cbb_contact_number');
    if (!$contact_number) {
        return 'Por favor, configure un número de contacto en las opciones del plugin.';
    }

    if (is_product()) {
        global $product;
        $product_url = get_permalink($product->get_id());
        $product_name = $product->get_name();
    } else {
        return 'Este shortcode solo funciona en páginas de productos.';
    }

    $message_template = get_option('cbb_message_text', 'Hola, estoy interesado en el producto: {product_name} ({product_url})');
    $message = str_replace(
        ['{product_name}', '{product_url}'],
        [$product_name, $product_url],
        $message_template
    );

    $contact_link = 'https://wa.me/' . esc_attr($contact_number) . '?text=' . urlencode($message);

    $button_text = get_option('cbb_button_text', 'Contactar ahora');
    $button_bg_color = get_option('cbb_button_bg_color', '#25D366');
    $button_text_color = get_option('cbb_button_text_color', '#FFFFFF');

    return '<a href="' . esc_url($contact_link) . '" class="button contact-button" target="_blank" style="background-color: ' . esc_attr($button_bg_color) . '; color: ' . esc_attr($button_text_color) . ';">' . esc_html($button_text) . '</a>';
}
add_shortcode('contact_button', 'cbb_contact_button_shortcode');

// Estilos predeterminados para el botón
function cbb_enqueue_styles()
{
    echo '<style>
        .contact-button {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none !important;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }
    </style>';
}
add_action('wp_head', 'cbb_enqueue_styles');
