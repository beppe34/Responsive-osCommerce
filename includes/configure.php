<?php
  define('HTTP_SERVER', 'http://localhost:8000');
  define('HTTPS_SERVER', 'http://localhost:8000');
  define('ENABLE_SSL', false);
  define('HTTP_COOKIE_DOMAIN', '');
  define('HTTPS_COOKIE_DOMAIN', '');
  define('HTTP_COOKIE_PATH', '/catalog/');
  define('HTTPS_COOKIE_PATH', '/catalog/');
  define('DIR_WS_HTTP_CATALOG', '/catalog/');
  define('DIR_WS_HTTPS_CATALOG', '/catalog/');

  define('DIR_FS_CATALOG', 'D:/projects/oscr/catalog/');  
//  define('DIR_FS_CATALOG', 'D:/Projekt/oscr/catalog/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

  define('DIR_WS_IMAGES', DIR_WS_HTTP_CATALOG . 'images/');
  define('DIR_WS_MODULES', DIR_WS_HTTP_CATALOG . 'includes/modules/');
  
  
  define('DB_SERVER', '192.168.5.2');
//  define('DB_SERVER', 'localhost');  
  define('DB_SERVER_USERNAME', 'root');
  define('DB_SERVER_PASSWORD', 'faskdask');
//  define('DB_SERVER_PASSWORD', 'bullerbo');
  define('DB_DATABASE', 'oscr');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'mysql');
  define('CFG_TIME_ZONE', 'Europe/Stockholm');
?>