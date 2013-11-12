<?php
$mensaje = get_option( 'wp_cookie_ley_espana_mensaje' );
$geoip = get_option( 'wp_cookie_ley_espana_geoip' );
?>

<div class="admincookie-wrapper-header">
	<span>&nbsp;</span>
	<h2>Editor Ley Cookie</h2>
</div>
<?php if ( isset( $_GET['settings-updated'] ) ) { ?>
<div class="wrap">
	<div id="message" class="updated">
		<p><strong><?php _e('Settings saved.') ?></strong></p>
	</div>
</div>
<?php } ?>

<div class="wrap">
	<p>Configura el mensaje que aparece a tus usuarios.</p>
	<div class="postbox-container">
		<form name="cookie-form" action="admin.php?page=cookie_ley_espana" method="post">
			<input type="hidden" name="cookie-form" value="1">
			<div class="metabox-holder">
				<div class="postbox" style="width:100%">
					<h3><span>Editor</span></h3>
					<table class="form-table">
						<tbody>
							<tr>
								<th>Mensaje: </th>
								<td>
									<textarea id="cookie-form-mensaje" name="mensaje" rows="8" cols="100%"><?php echo $mensaje; ?></textarea>
								</td>
							</tr>
							<tr>
								<th>Habilitar GeoPosicionamiento:</th>
								<td>
									<span>Habilitando esta opción sólo muestras el mensaje a los usuarios con ip española.<br /> Si quieres mostrar el mensaje siempre, NO chequear esta opción.</span>
									<br />
									<input name="geoip" type="checkbox" <?php echo $geoip == 'on' ? 'checked' : ''; ?> >
								</td>
							</tr>
							<tr>
								<th></th>
								<td>
									<input type="submit" class="button-primary" value="<?php _e('Save'); ?>">
									&nbsp;&nbsp;&nbsp;
									<input type="button" onclick="jQuery('#cookie-form-mensaje').html('Utilizamos cookies propias y de terceros para mejorar la experiencia de navegación, y ofrecer contenidos y publicidad de interés. Al continuar con la navegación entendemos que se acepta nuestra Política de cookies.');" class="button" value="Cargar texto predeterminado">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="postbox">
					<h3><span>Soporte y Ayuda</span></h3>
					<table class="form-table">
						<tbody>
							<tr>
								<th>Página del plugin</th>
								<td>Para solicitar ayuda o reportar errores, escribe un comentario en el artículo sobre este plugin: <a target="_blank" href="http://pedroventura.es/1amvc1g">Ir a página del plugin</a></td>
							</tr>
							<tr>
								<th>Twitter </th>
								<td>
									También puedes reportarme comentarios por twitter. <br /> <a href="https://twitter.com/intent/tweet?screen_name=pedrojventura" class="twitter-mention-button" data-related="pedrojventura">Tweet to @pedrojventura</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>
			</div>
			<p class="text-right">Desarrollado por: <a href="http://www.pedroventura.com/" target="_blank"> Pedro Ventura</a></p>
		</from>
	</div>
</div>