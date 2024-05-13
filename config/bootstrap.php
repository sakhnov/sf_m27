<?php

error_reporting(E_ALL); // Error engine
ini_set('display_errors', TRUE); // Error display
ini_set('log_errors', TRUE); // Error logging
ini_set('error_log', 'errors.log'); // Logging file 

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/main.php';
require_once 'config/configuration.php';
require_once 'vendor/autoload.php';
Main::showPage();
