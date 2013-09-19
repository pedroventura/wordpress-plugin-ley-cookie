<?php
/**
 * Plugin Name: Cookie Ley Española
 * Plugin URI: http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola
 * Description: Este plugin aporta toda la funcionalidad para hacer cumplir la ley de cookies en España
 * Version: 1.0
 * Author: Pedro Ventura
 * Author URI: http://www.pedroventura.com/
 */

// cargamos los archivos js y css
add_action( 'wp_enqueue_scripts', 'cargar_archivos' );
// en el footer insertamos el código js para iniciar toda la funcionalidad
add_action('wp_footer', 'iniciar_app_cookie');

// declaramos la URL del fichero que maneja las llamadas AJAX (wp-admin/admin-ajax.php)
wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

// accion para manejar las acciones sobre nuestra funcion
do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );
do_action( 'wp_ajax_' . $_POST['action'] );

//conectamos el plugin con las acciones ajax que se ejecutarán
add_action( 'wp_ajax_nopriv_geo-ip', 'geoUsuario' );
add_action( 'wp_ajax_geo-ip', 'geoUsuario' );

// creamos la nueva pagina
register_activation_hook(__FILE__,'crear_pagina'); 

/**
 * Funcion base para comprobar la ip del usuario y devolver el codigo de pais.
 * Esta función esta optimizada para funcionar con el plugin W3 Total Cache, con el que podemos cachear consultas
 * a la API externa de geoip, la cual tiene un límite de 10,000 llamadas a la hora.
 * 
*/
function geoUsuario() {
	 // compruebo si existe el plugin de W3 Total Cache
	if (file_exists(WP_PLUGIN_DIR . '/w3-total-cache/lib/W3/ObjectCache.php')) {
		require_once WP_PLUGIN_DIR . '/w3-total-cache/lib/W3/ObjectCache.php';
		// creo la instancia de la clase para cachear objectos con el plugin de W3 Total cache
		$cacheObjeto = & W3_ObjectCache::instance();
		// compruebo si el cacheo de objectos está activo
		$cacheActivo = $cacheObjeto->_caching;
		if ($cacheActivo) {
			$paisIp = $cacheObjeto->get('ip_' . ipToSlug($_SERVER['REMOTE_ADDR']),'cookieLegal');
			if ( $paisIp === false ) {
				$paisIp = obtenerGeoInfo();
				$cacheObjeto->add('ip_' . ipToSlug($_SERVER['REMOTE_ADDR']), $paisIp, 'cookieLegal', 3600);
			}
			echo $paisIp;
			exit;
		}
	} else {
		echo obtenerGeoInfo();
		exit;
	}
}

/**
 * Function para obtener los datos geográficos de una IP.
 * Funcion con el servicio externo de freegeoip.
 * @link http://freegeoip.net/
 * @todo conectar con varios servicios, otro ejemplo http://api.hostip.info/get_json.php?ip=XX.XX.XX.XX
*/
function obtenerGeoInfo() {
	$urlIpCheck = 'http://freegeoip.net/json/' .  $_SERVER['REMOTE_ADDR'];
	$contenido = file_get_contents($urlIpCheck);
	$parsedJson  = json_decode($contenido);
	if (isset($parsedJson->country_code)) {
		return $parsedJson->country_code;
	} else {
		return false;
	}
}

/**
 * Funcion para crear un slug en base a una ip. 
 * Se usará como base del id cuando se cachea la consulta
*/
function ipToSlug($ip) {
	return str_replace('.', '_', $ip);
}

/**
 * Funcion para cargar las librerias js y el css necesario
*/
function cargar_archivos() {
	wp_enqueue_script(
		'cookie-check',
		plugins_url( '/assets/js/cookie-check.js' , __FILE__ ),
		array( 'jquery' ),
		'1.0.0'
		);
	wp_enqueue_script(
		'jquery.cookie',
		plugins_url( '/assets/js/jquery-cookie/jquery.cookie.js' , __FILE__ ),
		array( 'jquery' ),
		'1.0.0'
		);
	wp_enqueue_style(
		'ley-cookie', 
		plugins_url( '/assets/css/ley-cookie.css' , __FILE__ )
		);
}

/**
 * Funcion que inicializa la api de la libreria js que se encarga de comprobar la cookie y mostrar el mensaje
*/
function iniciar_app_cookie() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		CookieLegal.inicio({
			web: "<?php echo str_replace('http://', '',home_url()); ?>", 
			ajaxCallback: "wp-admin/admin-ajax.php",
			pagePermanlink:"<?php echo pageSlug();?>"
		});
	});
	</script>
	<?php 
}

/**
 * Funcion para crear una página automáticamente en el blog que será la base de la página informativa
 * sobre el uso de cookies en cada blog
*/
function crear_pagina() {
	global $wpdb;
	$the_page_title = 'Política de cookies';
	$the_page_name = 'politica-cookies-es';
	$the_page = get_page_by_title( $the_page_title );
	
	if ( ! $the_page ) {
		// generamos los datos de la página
		$_p = array();
		$_p['post_title'] = $the_page_title;
		$_p['post_content'] = "Debes escribir el texto indicando tu política de cookies, con las cookies que usas en tu blog. <br/ > Documentacion: <a href='http://www.agpd.es/portalwebAGPD/canaldocumentacion/publicaciones/common/Guias/Guia_Cookies.pdf'>http://www.agpd.es/portalwebAGPD/canaldocumentacion/publicaciones/common/Guias/Guia_Cookies.pdf</a>";
		$_p['post_status'] = 'publish';
		$_p['post_type'] = 'page';
		$_p['comment_status'] = 'closed';
		$_p['ping_status'] = 'closed';
		$_p['post_category'] = array(1); // por defecto 'Uncategorised'
		// insertamos la página en base de datos
		$the_page_id = wp_insert_post( $_p );
	}
}

/**
 * Obtiene la url de la página del blog. 
 * En cada uno será diferente en funcion de la configuración de los enlaces permanentes
*/
function pageSlug() {
	return get_permalink(get_page_by_title('Política de cookies'));
}