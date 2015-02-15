<?php
Router::parseExtensions('json');

Router::connect('/years/:year', array('controller' => 'national_holidays', 'action' => 'year'));
Router::connect('/',      array('controller' => 'national_holidays', 'action' => 'view'));
Router::connect('/:date', array('controller' => 'national_holidays', 'action' => 'view'));
