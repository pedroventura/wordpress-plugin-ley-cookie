Wordpress plugin cookie ley española
=======================

Este plugin aporta la funcionalidad para hacer cumplir la ley de cookies en España informado al usuario de que el sitio usa las cookies propias o de terceros para mejorar el servicio de navegación, preferencias, mediciones y/o publicidad.

### GeoPosicionamiento IP del usuario

El plugin hace consultas a servicios de GeoIP para consultar la procedencia del visitante del blog, en caso de que el usuario tenga ip española se inicia el proceso para mostrar el mensaje. A los visitantes de otros países no se les mostrará nada, ya que puede que sus leyes locales no les afecte y no tengan que advertir del uso de Cookies. Igualmente, se puede deshabilitar el geoposicionamiento desde el menú de administración y el mensaje se mostrará a todos los visitantes que accedan al blog, independientemente de su ip.

### Limitaciones APIs GeoPosicionamiento y Cacheo

#### API GeoPosicionamiento

Actualmente se está usando el servicio de http://freegeoip.net/ para solicitar la información de GeoPosicionamiento de la ip del visitante. 

Se solicita una petición HTTP GET con el siguiente formato:

`
freegeoip.net/json/{ip_usuario}
`

Existe una limitación de 10,000 peticiones a la hora.

#### Cacheo

Se hace uso del plugin de cacheo W3 Total Cache, para cachear el resultado de la llamada al servicio de GeoIP, por tener éstos una limitación en el número de llamadas. El plugin W3 Total Cache NO es obligatorio, pero recomendable para cachear el resultado de la petición de geoposicionamiento y evitar alcanzar la limitación de peticiones. Es útil cuando el usuario visita más de una página.

### Página de Política de Cookies

El plugin adicionalmente crea una página en tu blog llamada "Política de cookies", en la que el administrador del blog tendrá que indicar el texto legal con todas las cookies que esté usando en el blog. 
Por defecto se añade un breve texto advirtiendo que hay que completar esta página y un link a un pdf de la agencia española de protección de datos. 
Esta página no aparece completa automáticamente porque cada blog tendrá diferentes funcionalidades o herramientas que añaden cookies y el administrador del blog debe indicar cuales está agregado.


Instalación en Wordpress
=======================

Url del plugin en Wordpress: <a href="http://wordpress.org/plugins/spain-cookie-law/">http://wordpress.org/plugins/spain-cookie-law/</a>

Guía de instalación: <a href="http://wordpress.org/plugins/spain-cookie-law/installation/">http://wordpress.org/plugins/spain-cookie-law/installation/</a>

FAQ y Colaboración
=======================

Si tienes dudas, preguntas o te da errores ponte en contacto conmigo: <a href="http://www.pedroventura.com/internet/plugin-en-wordpress-cumplir-ley-espanola/#comments">página del plugin</a>
