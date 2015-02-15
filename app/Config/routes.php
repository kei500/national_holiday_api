<?php
Router::parseExtensions('json');
Router::connect('/',      array('controller' => 'national_holidays', 'action' => 'view'));
Router::connect('/:date', array('controller' => 'national_holidays', 'action' => 'view'));
