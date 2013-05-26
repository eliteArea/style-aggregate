<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| set destination directoroy don't use '/' at start
*/
$config['style_destionation'] = 'files/style';

/*
| public html if you app and core not in public folder
| default is: $config['public_html'] = '';
*/
$config['public_html'] = 'public_html';

/*
| Set aggregation to true or false
*/
$config['aggregate'] = true;
//$config['aggregate'] = false;


/*
| Set style file for loading
*/
$config['stylepath'][] = 'theme/stylesheets/screen.css';
$config['stylepath'][] = 'theme/stylesheets/screen2.css';

