<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Recipe.php';
require_once __DIR__ . '/../model/Ingredient.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Consumation.php';
// require_once __DIR__ . '/../model/Brewery.php';

class RecipeController extends Controller{
    public function brewery(){
        if (!empty($_POST['action'])) {
            if ($_POST['action'] == 'addConsumation') {
                $result= $this->_handleInsertConsumation();
                if ($result['result'] == 'ok') {
                    header_remove();
                    header('Location: index.php?page=brewery');
                    exit();
                  } else {
                    $this->set('errors', $result['data']);
                  }
            }
        }
        // $user= User::where('id', $_SESSION['userId'])->get();
        // $this->set('recipes', $user);
        // $recipes= Recipe::find(1)->users()->where('user_id', $_SESSION['userId'])->get();

        //OG WORKING CODE
        // $user= User::where('id', $_SESSION['userId'])->first();
        // $this->set('user', $user);
        //END OG WORKING CODE
        $this->set('title','brewery');
    }
    //test consume button
    public function consumedApi(){
        $consumed = Consumation::where('user_id', $_SESSION['userId'])->get();
        echo $consumed->toJson();
        exit();
    }
    public function apiCreate(){
        $result = $this->_handleInsertConsumation();
        echo json_encode($result);
        exit();
    }
    
    public function _handleInsertConsumation(){
        $newConsumation = new Consumation;
        $newConsumation->user_id = $_SESSION['userId']; 
        $newConsumation->recipe_id = intval($_POST['recipe_id']); 
        $errors = Consumation::validate($newConsumation);
        if (empty($errors)) {
            $newConsumation->save();
             return ['result' => 'ok', 'data' =>  $newConsumation->toArray()];
        } else {
             return ['result' => 'error', 'data' => $errors];
        }
    }


    //end test consume button

    public function breweryApi(){
        $user = $this-> _getRecipeResults();
        echo $user->toJson();
        exit();
    }
    private function _getRecipeResults(){
        $user= User::where('id', $_SESSION['userId'])->first()->recipes;
        return $user;
    }
}
?>