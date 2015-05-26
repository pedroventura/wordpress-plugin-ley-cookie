/**
 * Libreria JavaScript para incluir el mensaje de advertencia del uso de cookies en la web.
 * Se incluye una cookie cuando el usuario entra en la web y si sigue navegando el valor de ésta cambia y 
 * el mensaje no vuelve a aparecer.
 * Al ser sólo una normativa a nivel de España, solo se mostrará esta advertencia y funcionalidad para los usuarios de este país.
 * Se necesita la librería jQuery para funcionar y el plugin jquery-cookie https://github.com/carhartl/jquery-cookie
 * Autor: Pedro Ventura http://www.pedroventura.com
 * Si lo consideras no dudes en aportar mejoras al código.
*/
var CookieLegal = {

	// variable que contiene el nombre de la web o blog, que se usará para setear la cookie
	web: null,

	// dias que durará la cookie. Por defecto 1 año
	duracionDias: 365,

	// si se quiere que dure mas de 1 año se usará esta variable para multiplicar por los años deseados
	anios: 1,

	// url pagina informativa sobre cookies
	pagePermanlink: null,
	// mensaje
	mensaje: null,
	// titulo página
	tituloPagina: null,

	// funcion para comprobar si el usuario es de España
	checkGeoUsuario: function _checkGeoUsuario( url, checkGeoip ) {
		if (checkGeoip == 'on') {
			jQuery.post( url, { action:"geo-ip" }, function( geoUsuario ) {
				var obj = jQuery.parseJSON( geoUsuario );
				if ( obj.country_name == 'ES' ) {
					CookieLegal.checkCookie();
					CookieLegal.cargaMensaje();
				}
			} );
		} else {
			CookieLegal.checkCookie();
			CookieLegal.cargaMensaje();
		}
	},

	// funcion que se encarga de crear y setear la cookie.
	// la duración de la cookie será de 1 año por
	checkCookie: function _checkCookie() {
		laCookie = CookieLegal.leerCookie();
		if ( isNaN( laCookie ) ) {
			CookieLegal.setearCookie( 1 );
		}
	},

	// crea la cookie con el valor asignado
	setearCookie: function _setearCookie( valor ) {
		jQuery.cookie( 'cookie_legal_' + CookieLegal.web, valor, { expires: CookieLegal.duracionDias * CookieLegal.anios, path: '/' } );
	},

	// funcion que se encarga de mostrar el mensaje legal
	cargaMensaje: function _cargaMensaje() {
		laCookie = CookieLegal.leerCookie();
		if ( laCookie != 2 ) {
			jQuery( 'body' ).prepend( '<div id="wrapperMensajeCookie" class="wrapperMensajeCookie"><div class="inner"><div class="textoLegalCookie"><p><strong>'+ CookieLegal.tituloPagina +'</strong></p><p> '+ CookieLegal.mensaje +' <a href="'+ CookieLegal.pagePermanlink +'" target="_blank"> '+ CookieLegal.tituloPagina +'  </a>.</p><a onclick="javascript:CookieLegal.cerrarModal();" class="cerrarTextoLegalCookie" title="Cerrar"></a></div></div></div>' );
		}
	},

	// funcion para leer el valor de la cookie
	leerCookie: function _leerCookie() {
		laCookie = parseInt( jQuery.cookie( 'cookie_legal_' + CookieLegal.web ), 10 );
		return laCookie;
	},

	cerrarModal: function _cerrarModal() {
		console.log('cerrado');
		jQuery('#wrapperMensajeCookie').hide();
		CookieLegal.setearCookie( 2 );
	},

	// funcion de inicialización
	inicio: function _inicio( setup ) {
		this.web = setup.web;
		this.pagePermanlink = setup.pagePermanlink;
		this.mensaje = setup.mensaje;
		this.tituloPagina = setup.tituloPagina;
		laCookie = this.leerCookie();
		//cuando ya existe la cookie no hace falta seguir haciendo esta comprobacion
		if ( ( laCookie != 2 ) || ( isNaN( laCookie ) ) ) {
			this.checkGeoUsuario( setup.ajaxCallback, setup.checkGeoip );
		}
	}
};