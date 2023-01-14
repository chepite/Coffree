<?php

$routes = array(
   'home' => array(
    'controller' => 'Product',
    'action' => 'index'
   ),
  'shop' => array(
    'controller' => 'Product',
    'action' => 'shop'
  ),
  'brewery' => array(
    'controller' => 'Recipe',
    'action' => 'brewery'
  ),
  'profile' => array(
    'controller' => 'User',
    'action' => 'profile'
  ),
  'login' => array(
    'controller' => 'User',
    'action' => 'login'
  ),
  'signup' => array(
    'controller' => 'User',
    'action' => 'signup'
  ),
  'characterName' => array(
    'controller' => 'User',
    'action' => 'characterName'
  ),
  'characterGenerator' => array(
    'controller' => 'User',
    'action' => 'characterGenerator'
  ),
  'breweryApi' => array(
    'controller' => 'Recipe',
    'action' => 'breweryApi'
  ),
  'cart' => array(
    'controller' => 'Product',
    'action' => 'cart'
  ),
  'detoxApi' => array(
    'controller' => 'User',
    'action' => 'detoxApi'
  ),
  //test consumations
  'consumedApi' => array(
    'controller' => 'Recipe',
    'action' => 'consumedApi'
  ),
  'api-create-consumation' => array(
    'controller' => 'Recipe',
    'action' => 'apiCreate'
  ),
  'cartConfirmation' => array(
    'controller' => 'Product',
    'action' => 'cartConfirmation'
  )
  //end test consumations
);

if(empty($_GET['page'])) {
  $_GET['page'] = 'home';
}

//ALS DIT WEG IS WERKT MIJN INLOGSYSTEEM
//WERKT SOMS OOK ALS DIT ER STAAT WTF PHP
if(empty($routes[$_GET['page']])) {
  header('Location: index.php');
  exit();
}

$route = $routes[$_GET['page']];