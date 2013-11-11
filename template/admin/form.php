<?php
$mensaje = get_option( 'wp_cookie_ley_espana_mensaje' );
$geoip = get_option( 'wp_cookie_ley_espana_geoip' );
?>

<div class="admincookie-wrapper-header">
	<span>&nbsp;</span>
	<h2>Editor Cookie Ley Española</h2>
</div>

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
								<th>Habilitar GeoPosicionamiento.</th>
								<td>
									<span>Habilitando esta opción sólo muestras el mensaje a los usuarios con ip española</span>
									<br />
									<input name="geoip" type="checkbox" <?php echo $geoip == 'on' ? 'checked' : ''; ?> >
								</td>
							</tr>
							<tr>
								<th></th>
								<td><input type="submit" class="button-primary" value="Guardar"></td>
								<td><input type="button" onclick="jQuery('#cookie-form-mensaje').html('Utilizamos cookies propias y de terceros para mejorar la experiencia de navegación, y ofrecer contenidos y publicidad de interés. Al continuar con la navegación entendemos que se acepta nuestra Política de cookies.');" class="button" value="Texto Predeterminado"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="postbox">
					<h3><span>Soporte</span></h3>
					<table class="form-table">
						<tbody>
							<tr>
								<th>Soporte y Ayuda </th>
								<td>Para solicitar ayuda o reportar errores, escribe un comentario en el artículo sobre este plugin: <br/ ><a target="_blank" href="http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola/">http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola/</a></td>
							</tr>
							
						</tbody>
					</table>
				</div>
			</div>
		</from>
	</div>
</div>