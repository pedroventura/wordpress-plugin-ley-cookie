=== Wordpress Plugin Ley Cookie ===
Tags: Cookie, cookies, ley, law, Spain, España
Tested up to: 4.2.2
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Este plugin aporta la funcionalidad para hacer cumplir la ley de cookies en España.

== Description ==

Este plugin aporta la funcionalidad para hacer cumplir la ley de cookies en España informado al usuario de que el sitio usa las cookies propias o de terceros para mejorar el servicio de navegación, preferencias, mediciones y/o publicidad.

¡Importante! El plugin sigue en desarrollo y actualmente no permite cumplir la ley. <a href="http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola/#nocumple">leer más</a>

Se muestra a los usuarios que tienen ip española el mensaje advirtiendo de que el blog visitado usa cookies para diferentes fines.

El plugin adiccionalmente crea una página en tu blog llamada "Política de cookies", en la que el administrador del blog tendrá que indicar el texto legal con todas las cookies que esté usando en el blog. Por defecto se añade un breve texto advirtiendo que hay que completar esta página y un link a un pdf de la agencia española de protección de datos. 
Esta página no aparece completa automáticamente porque cada blog tendrá diferentes funcionalidades o herramientas que añaden cookies y el administrador del blog debe indicar cuales está agregado.

El plugin hace consultas a servicios de GeoIP para consultar la procedencia del visitante del blog, en caso que sea de España se inicia el proceso para mostrar el mensaje. Al resto de lectores de otros países no se les mostrará nada.

El plugin también hace uso del plugin de cacheo W3 Total Cache, para cachear el resultado de la llamada al servicio de GeoIP, por tener éstos una limitación en el número de llamadas.

**Para desarrolladores**

El código está versionado y es público para todo aquel que quiera colaborar en el desarrollo o mejoras del plugin. <a href="https://github.com/pedroventura/wordpress-plugin-ley-cookie">https://github.com/pedroventura/wordpress-plugin-ley-cookie</a>

== Screenshots ==

1.  Mensaje alerta para el usuario indicando el uso de cookies en el blog

== Installation ==

Para instalar el plugin.

1. Descarga el plguin, descomprime el archivo y súbelo a la carpeta `/wp-content/plugins/`
2. Activa el plugin.
3. Edita la página de "Política de cookies" indicando el texto legal y la información de cookies que usa tu blog

O bien puedes descargarlo directamente desde la sección Plugins dentro del panel de tu blog. 

1. Ir a la sección `Plugin`.
2. Haz click en el enlace `Añadir nuevo`
3. En el buscador, escribe `Cookie España`
4. Haz click en instalar
5. Edita la página de "Política de cookies" indicando el texto legal y la información de cookies que usa tu blog

== Frequently Asked Questions ==

Si tienes dudas, preguntas o te da errores ponte en contacto conmigo. <a href="http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola/#comments">http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola</a>
