<?php
  define('HTTP_SERVER', 'http://localhost:8000');
  define('HTTPS_SERVER', 'http://localhost:8000');
  define('ENABLE_SSL', false);
  define('HTTP_COOKIE_DOMAIN', '');
  define('HTTPS_COOKIE_DOMAIN', '');
  define('HTTP_COOKIE_PATH', '/catalog/admin');
  define('HTTPS_COOKIE_PATH', '/catalog/admin');
  define('HTTP_CATALOG_SERVER', 'http://localhost:8000');
  define('HTTPS_CATALOG_SERVER', 'http://localhost:8000');
  define('ENABLE_SSL_CATALOG', 'false');
  
//  define('DIR_FS_DOCUMENT_ROOT', 'D:/projects/oscr/catalog/');
//  define('DIR_FS_CATALOG', 'D:/projects/oscr/catalog/');
//  define('DIR_FS_ADMIN', 'D:/projects/oscr/catalog/admin/');

  define('DIR_FS_DOCUMENT_ROOT', 'D:/Projekt/oscr/catalog/');
  define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT);
  define('DIR_FS_ADMIN', DIR_FS_DOCUMENT_ROOT . 'admin/');
  
  define('DIR_WS_ADMIN', '/catalog/admin/');
  define('DIR_WS_HTTPS_ADMIN', '/catalog/admin/');
  define('DIR_WS_CATALOG', '/catalog/');
  define('DIR_WS_HTTPS_CATALOG', '/catalog/');
  define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG . 'images/');
  define('DIR_WS_CATALOG_LANGUAGES', DIR_WS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

//  define('DB_SERVER', '192.168.5.2');
  define('DB_SERVER', 'localhost');
  define('DB_SERVER_USERNAME', 'root');
//  define('DB_SERVER_PASSWORD', 'faskdask');
  define('DB_SERVER_PASSWORD', 'bullerbo');
  define('DB_DATABASE', 'oscr');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'mysql');
  define('CFG_TIME_ZONE', 'Europe/Stockholm');
?>