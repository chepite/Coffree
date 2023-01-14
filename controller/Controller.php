<?php

class Controller {

  public $route;
  protected $viewVars = array();

  public function filter() {
    if(!isset($_SESSION['loggedin'])){
      $_SESSION['loggedin']= false;
    }
    if(!isset($_SESSION['characterName'])){
      $_SESSION['characterName']= 'your character';
    }
    if(!isset($_SESSION['username'])){
      $_SESSION['username']= '';
    }
    if(!isset($_SESSION['userId'])){
      $_SESSION['userId']= null;
    }
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = array();
    }
    call_user_func(array($this, $this->route['action']));
  }

  public function render() {
    //logic before render
    $numItems = 0;
    foreach ($_SESSION['cart'] as $items) {
      $numItems += $items['quantity'];
    }
    $this->set('numItems', $numItems);
    //end logic
    $this->createViewVarWithContent();
    $this->renderInLayout();
  }

  public function set($variableName, $value) {
    $this->viewVars[$variableName] = $value;
  }

  private function createViewVarWithContent() {
    extract($this->viewVars, EXTR_OVERWRITE);
    ob_start();
    require __DIR__ . '/../view/' . strtolower($this->route['controller']) . '/' . $this->route['action'] . '.php';
    $content = ob_get_clean();
    $this->set('content', $content);
  }

  private function renderInLayout() {
    extract($this->viewVars, EXTR_OVERWRITE);
    include __DIR__ . '/../view/layout.php';


    // empty info and error messages
    // we keep the cart, as we don't want to clear the cart on each page refresh
    if (!empty($_SESSION['info'])) {
      unset($_SESSION['info']);
    }
    if (!empty($_SESSION['error'])) {
      unset($_SESSION['error']);
    }
  }

}
