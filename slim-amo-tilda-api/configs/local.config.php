<?php

use lib\Config;

// DB Config
Config::write('db.host', 'localhost');
Config::write('db.port', '3306');
Config::write('db.basename', 'db');
Config::write('db.user', 'root');
Config::write('db.password', '');

// Project Config
Config::write('path', 'http://slim.local');