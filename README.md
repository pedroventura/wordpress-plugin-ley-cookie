Wordpress Plugin Cookie ley España
=======================

Este plugin aporta la funcionalidad para hacer cumplir la ley de cookies en España informado al usuario de que el sitio usa las cookies propias o de terceros para mejorar el servicio de navegación, preferencias, mediciones y/o publicidad.

Se muestra a los usuarios que tienen ip española el mensaje advirtiendo de que el blog visitado usa cookies para diferentes fines.

El plugin adicionalmente crea una página en tu blog llamada "Política de cookies", en la que el administrador del blog tendrá que indicar el texto legal con todas las cookies que esté usando en el blog. Por defecto se añade un breve texto advirtiendo que hay que completar esta página y un link a un pdf de la agencia españaola de protección de datos. 
Esta página no aparece completa automáticamente porque cada blog tendrá diferentes funcionalidades o herramientas que añaden cookies y el administrador del blog debe indicar cuales está agregado.

El plugin hace consultas a servicios de GeoIP para consultar la procedencia del visitante del blog, en caso que sea de España se inicia el proceso para mostrar el mensaje. Al resto de lectores de otros países no se les mostrará nada.

El plugin también hace uso del plugin de cacheo W3 Total Cache, para cachear el resultado de la llamada al servicio de GeoIP, por tener éstos una limitación en el número de llamadas.


Instalación en Wordpress
=======================

Url del plugin en Wordpress: <a href="http://wordpress.org/plugins/spain-cookie-law/">http://wordpress.org/plugins/spain-cookie-law/</a>

Guía de instalación: <a href="http://wordpress.org/plugins/spain-cookie-law/installation/">http://wordpress.org/plugins/spain-cookie-law/installation/</a>

FAQ y Colaboración
=======================

Si tienes dudas, preguntas o te da errores ponte en contacto conmigo. <a href="http://www.pedroventura.com/contacto/">http://www.pedroventura.com/contacto/</a>

No dudes en colaborar en el desarrollo y mejoraras de este plugin. 

TODO
=======================
* El plugin aún NO cumple la premisa de evitar que se instalen las cookies antes de que el usuario las acepte. Es decir NO se pueden instalar cookies hasta que el usuario de consentimiento, ya sea continuando con la navegación o pulsando un botón aceptar, en ese momento ya se pueden instalar las cookies y no antes.
El plugin ahora NO es capaz de evitar que se instalen las cookies que usa el blog, ya sean las de google analytics, o cualquier otra que use el blog.
Todo este desarrollo está en progreso pero depende de que otros desarrolladores colaboren con el proyecto de este plugin.
En caso de que no sea viable integrar esta funcionalidad, el plugin NO podrá hacer cumplir la Ley de Cookies
* El texto informativo está hardcodeado en el javascript, se debe crear en el dashboard de Wordpress un menú donde el usuario pueda ajustar el texto, y este texto se debe guardar en las opciones del plugin en la base de datos del usuario. 
