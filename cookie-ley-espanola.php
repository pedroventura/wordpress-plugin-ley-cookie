<?php
/**
 * Plugin Name: Cookie Ley Española
 * Plugin URI: http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola
 * Description: Este plugin aporta la funcionalidad para hacer cumplir la ley de cookies en España informado al usuario de que el sitio usa las cookies propias o de terceros para mejorar el servicio de navegación, preferencias, mediciones y/o publicidad
 * Version: 1.2.3
 * Author: Pedro Ventura
 * Author URI: http://www.pedroventura.com/
 */

// cargamos los archivos js y css
add_action( 'wp_enqueue_scripts', 'cargar_archivos' );
// en el footer insertamos el código js para iniciar toda la funcionalidad
add_action( 'wp_footer', 'iniciar_app_cookie' );

// accion para manejar las acciones sobre nuestra funcion
do_action( 'wp_ajax_nopriv_geo-ip' );
do_action( 'wp_ajax_geo-ip' );
//conectamos el plugin con las acciones ajax que se ejecutarán
add_action( 'wp_ajax_nopriv_geo-ip', 'geo_usuario' );
add_action( 'wp_ajax_geo-ip', 'geo_usuario' );

//comprobamos las opciones de configuracion
add_action( 'plugins_loaded', 'comprobar_opciones' );

// creamos el menu en el dashboard
add_action( 'admin_menu', 'cookie_menu' );
add_action( 'admin_menu', 'cargar_archivos' );

// creamos la nueva pagina
register_activation_hook( __FILE__, 'registrar_datos' ); 

/**
 * cookie_menu
 * 
 * @access public
 *
 * @return mixed Value.
 */
function cookie_menu() {
	add_menu_page( 'Editor Ley Cookie', 'Ley Cookie', 'manage_options', 'cookie_ley_espana', 'opciones_menu' );
	// comprobación si vienen datos por post y actualizamos los datos
	if ( !empty( $_POST['cookie-form'] ) && ( $_POST['cookie-form'] == 1 ) ) {
		update_option( 'wp_cookie_ley_espana_mensaje', $_POST['mensaje']  );
		$checkGeoip = false;
		if ( isset( $_POST['geoip'] ) ) {
			$checkGeoip = $_POST['geoip'];
		}
		update_option( 'wp_cookie_ley_espana_geoip', comprobar_check( $checkGeoip ) );
		header('Location: admin.php?page=cookie_ley_espana&settings-updated=true');
		exit;
	}
}

/**
 * opciones_menu
 * 
 * @access public
 *
 * @return mixed Value.
 */
function opciones_menu() {
	include_once plugin_dir_path( __FILE__ ) . '/inc/admin/form.php';
}

/**
 * Funcion base para comprobar la ip del usuario y devolver el codigo de pais.
 * Esta función esta optimizada para funcionar con el plugin W3 Total Cache, con el que podemos cachear consultas
 * a la API externa de geoip, la cual tiene un límite de 10,000 llamadas a la hora.
 * 
*/
function geo_usuario() {
	$paisIp = false;
	$cached = 0;
	 // compruebo si existe el plugin de W3 Total Cache. Busco el archivo con la clase de cacheo de objectos.
	if ( file_exists( WP_PLUGIN_DIR . '/w3-total-cache/lib/W3/ObjectCache.php' ) ) {
		include_once WP_PLUGIN_DIR . '/w3-total-cache/lib/W3/ObjectCache.php';
		// si esta función esta declarada es que el plugin W3 está activo
		if ( function_exists( 'w3_instance' ) ) {
			// creo la instancia de la clase para cachear objectos con el plugin de W3 Total cache
			$cacheObjeto = new W3_ObjectCache();
			// compruebo si el cacheo de objectos está activo
			$cacheActivo = $cacheObjeto->_caching;
			if ( $cacheActivo ) {
				$paisIp = $cacheObjeto->get( 'ip_' . ip_to_slug( $_SERVER['REMOTE_ADDR'] ), 'cookieLegal' );
				if ( $paisIp === false ) {
					$paisIp = obtener_geo_info();
					$cacheObjeto->add( 'ip_' . ip_to_slug( $_SERVER['REMOTE_ADDR'] ), $paisIp, 'cookieLegal', 3600 );
					$cached = 1;
				}
			}
		}
	}
	// ultimo chequeo por si algún bucle de control falla que siempre se llame a la funcion para obtener el country_name
	if ( !$paisIp ) {
		$paisIp = obtener_geo_info();
	}
	$returnedData = array(
		'country_name' => $paisIp,
		'cached' => $cached,
		'userRequestIp' => $_SERVER['REMOTE_ADDR']);
	echo json_encode( $returnedData );
	exit;
}

/**
 * Function para obtener los datos geográficos de una IP.
 * Funcion con el servicio externo de freegeoip.
 * @link http://freegeoip.net/
 * @todo conectar con varios servicios, otro ejemplo http://api.hostip.info/get_json.php?ip=XX.XX.XX.XX
*/
function obtener_geo_info() {
	$urlIpCheck = 'http://freegeoip.net/json/' .  $_SERVER['REMOTE_ADDR'];
	$contenido = file_get_contents( $urlIpCheck );
	$parsedJson  = json_decode( $contenido );
	if ( isset( $parsedJson->country_code ) ) {
		return $parsedJson->country_code;
	} else {
		return false;
	}
}

/**
 * Funcion para crear un slug en base a una ip. 
 * Se usará como base del id cuando se cachea la consulta
*/
function ip_to_slug( $ip ) {
	return str_replace( '.', '_', $ip );
}

/**
 * Funcion para cargar las librerias js y el css necesario
*/
function cargar_archivos() {
	wp_enqueue_script(
		'cookie-check',
		plugins_url( '/assets/js/cookie-check.js', __FILE__ ),
		array( 'jquery' ),
		'1.2.1'
		);
	wp_enqueue_script(
		'jquery.cookie',
		plugins_url( '/assets/js/jquery-cookie/jquery.cookie.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0'
		);
	wp_enqueue_style(
		'ley-cookie', 
		plugins_url( '/assets/css/ley-cookie.css', __FILE__ )
		);
}

/**
 * Funcion que inicializa la api de la libreria js que se encarga de comprobar la cookie y mostrar el mensaje
*/
function iniciar_app_cookie() {
	$mensaje = get_option( 'wp_cookie_ley_espana_mensaje' );
	$tituloPagina = page_title();
	$checkGeoip = get_option( 'wp_cookie_ley_espana_geoip' );
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		CookieLegal.inicio({
			ajaxCallback: "<?php echo home_url(); ?>/wp-admin/admin-ajax.php",
			checkGeoip: "<?php echo $checkGeoip;?>",
			mensaje: "<?php
				echo str_replace("\n", "<br />",
					str_replace("\r\n", "\n", $mensaje));
					?>",
			pagePermanlink:"<?php echo page_slug();?>",
			tituloPagina: "<?php echo $tituloPagina;?>",
			web: "<?php echo str_replace( 'http://', '', home_url() ); ?>", 
		});
	});
	</script>
	<?php 
}

/**
 * registrar_datos
 * 
 * @access public
 *
 * @return mixed Value.
 */
function registrar_datos() {
	crear_pagina();
	// guardar las opciones en base de datos
	comprobar_opciones();
}

/**
 * Funcion para crear una página automáticamente en el blog que será la base de la página informativa
 * sobre el uso de cookies en cada blog
*/
function crear_pagina() {
	global $wpdb;

	$paginaId = get_option( 'wp_cookie_ley_espana_page_id' );

	if ( empty( $paginaId ) ) {
		$titulo = 'Política de cookies';
		$checkPagina = get_page_by_title( $titulo );
		if ( !$checkPagina ) {
			// generamos los datos de la página
			$nuevaPagina = array();
			$nuevaPagina['post_title'] = $titulo;
			$nuevaPagina['post_content'] = "Debes escribir el texto indicando tu política de cookies, con las cookies que usas en tu blog. <br/ > Documentacion: <a href='http://www.agpd.es/portalwebAGPD/canaldocumentacion/publicaciones/common/Guias/Guia_Cookies.pdf'>http://www.agpd.es/portalwebAGPD/canaldocumentacion/publicaciones/common/Guias/Guia_Cookies.pdf</a>";
			$nuevaPagina['post_status'] = 'publish';
			$nuevaPagina['post_type'] = 'page';
			$nuevaPagina['comment_status'] = 'closed';
			$nuevaPagina['ping_status'] = 'closed';
			$nuevaPagina['post_category'] = array( 1 ); // por defecto 'Uncategorised'
			// insertamos la página en base de datos
			$paginaId = wp_insert_post( $nuevaPagina );
			update_option( 'wp_cookie_ley_espana_page_id', $paginaId );
		} else {
			update_option( 'wp_cookie_ley_espana_page_id', $checkPagina->ID );
		}
	}	
}

/**
 * comprobar_opciones
 * 
 * @access public
 *
 * @return mixed Value.
 */
function comprobar_opciones() {
	$mensaje = get_option( 'wp_cookie_ley_espana_mensaje' );
	if ( empty( $mensaje) ) {
		update_option( 'wp_cookie_ley_espana_mensaje', 'Utilizamos cookies propias y de terceros para mejorar la experiencia de navegación, y ofrecer contenidos y publicidad de interés. Al continuar con la navegación entendemos que se acepta nuestra Política de cookies.' );
	}
	// opcion para habilitar el geoip
	$geoip = get_option( 'wp_cookie_ley_espana_geoip' );
	if ( empty( $geoip ) ) {
		update_option( 'wp_cookie_ley_espana_geoip', 'off' );
	}
	// comprobación del id de la página
	$paginaId = get_option( 'wp_cookie_ley_espana_page_id' );
	if ( empty( $paginaId ) ) {
		// volvemos a llamar a esta función para comtemplan a los usuarios que tienen que no hayan actualizado el código
		// de esta manera forzamos a que se cree el campo con el id de la pagina creada
		crear_pagina();
	}

}

/**
 * Obtiene la url de la página del blog. 
 * En cada uno será diferente en funcion de la configuración de los enlaces permanentes
*/
function page_slug() {
	return get_permalink( get_option( 'wp_cookie_ley_espana_page_id' ) );
}

/**
 * page_title
 * 
 * @access public
 *
 * @return mixed Value.
 */
function page_title() {
	return get_the_title( get_option( 'wp_cookie_ley_espana_page_id' ) );
}

/**
 * comprobar_check
 * 
 * @param mixed $check_type Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
function comprobar_check( $check_type = false ) {
	if ( $check_type != 'on' ) {
		return 'off';
	}
	return 'on';
}
