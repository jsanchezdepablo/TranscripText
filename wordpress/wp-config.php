<?php
/**
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'proyecto_tfg');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'J6Vp{hVB{$@RQ+yChuZXtpjf%JB&SaNvjHd%f~hMh4;3!r~sFufw5D%Z|XM] LQC');
define('SECURE_AUTH_KEY', 'xPPL}28|M8a3%l&fZ5f_oAg4G!.Hg+18%$KB_<VcZc];.;!yCh%iMUP)x^W| Dik');
define('LOGGED_IN_KEY', '`);{AHjS+{+UsdS!{/~^t9##KVyC:Wtg~ nF*GOn8hX8Jc7)gCafs-7MD;{/}B&B');
define('NONCE_KEY', '6c6$>= 7j0K(_S9/TUK1[iQqH3U[9Hr<!v0wHCv?oljLYAQkb7|ZO*7+=Z#F~>-.');
define('AUTH_SALT', 'XjI:Gr2Y0*JANG0gkPQ2ZD~c|^PK528zKJM?q5S))Co3V6:YkT OTf6gfu3T^>f}');
define('SECURE_AUTH_SALT', '3]P7^kr6h7lHv}gU1NK*q-iMUL`k3)P^rq}!4lhT]X5*V(-`cLtd0^5GR6bi&j.?');
define('LOGGED_IN_SALT', 'P6Asl2q$px#R`OIfTWnEG:Yo*!]KN,AJP|0g/iJfDP+}Hu)C+#Ww9z:5;hz@- -}');
define('NONCE_SALT', 'V(cV+{Ncu}L|W#{h+Rb8!ylo4@h3FAEt]bmjs;|=zK?~2VHHpC[bf/8~vh5yylf/');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', true);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
