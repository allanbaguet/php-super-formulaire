<?php 
// déclaration des constante pour le regex
define('REGEX_LASTNAME', '^[A-Za-zÀ-ÿ-]+$'); 
define('REGEX_EMAIL', '^[\w\.\-]+@[\w\-]+\.[a-z]{2,5}$');
define('REGEX_ZIPCODE', '^\d{5}$');
define('REGEX_BIRTHDAY', '^\d{4}-\d{2}-\d{2}$');
define('REGEX_URL', '^https:\/\/www\.linkedin\.com\/in\/[a-zA-Z0-9-]+\/?$');
define('REGEX_PASSWORD', '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$');

?>