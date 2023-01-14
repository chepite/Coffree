<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Character.php';
require_once __DIR__ . '/../model/Coffee.php';
require_once __DIR__ . '/../model/Detox.php';
require_once __DIR__ . '/../model/Recipe.php';
require_once __DIR__ . '/../model/Consumation.php';
//require_once __DIR__ . '/../model/Trophy.php';


class UserController extends Controller
{
    public function profile()
    {
        //SECRET DATE FORMULA
        //date('Y-m-d',strtotime($todayCoffee->updated_at))
        if (empty($user)) {
            $user = User::where('username', $_SESSION['username'])->first();
        }
        //lootbox test
        //lastdaystreak niet == vandaag wil zeggen dat ze nog niet ingelogd hebben vandaag
        if ($user->streak == 2 && $user->lastDayStreak != date('Y-m-d') || $user->streak == 6 && $user->lastDayStreak != date('Y-m-d')) {
            $this->lootbox($user);
        }
        //end lootbox test

        //if user skips character signup, can always happen 
        if ($user->character()->get()->count() == 0) {
            header('Location: index.php?page=characterName');
            exit();
        }
        //new signup give first 3 recipes
        if ($user->recipes()->count() == 0) {
            $recipes = Recipe::where('isRare', false)->get();
            foreach ($recipes as $recipe) {
                $user->recipes()->save($recipe);
            }
        }
        //end new signup code

        $_SESSION['characterName'] = $user->character->name;
        //todayCoffee that works 
        $current_date = date("Y-m-d");
        //$todayCoffee = Coffee::where('user_id', $user->id)->where('created_at', $current_date)->first();



        //EXP COFFEE NOT WORKING
        //if the dailyCoffee object exists update it otherwhise create it
        // if(Coffee::where('user_id', $user->id)->count() > 0){
        //     $todayCoffee = $this->_resetCoffee($user);
        // }
        // else{
        //     $todayCoffee = $this->_createCoffee($user);
        // }
        // $todayCoffee= $user->coffees()->where('updated_at', $current_date)->get();
        //END EXP COFFEE NOT WORKING CODE

        //og coffee code
        if (Coffee::where('user_id', $user->id)->count() == 0) {
            // $todayCoffee = $this->_createCoffee($user);
            $todayCoffee = $this->_createCoffee($user);
        } else {
            $todayCoffee = Coffee::where('user_id', $user->id)->first();
            // if($todayCoffee->updated_at !== $current_date){
            //    // $todayCoffee = $this->_resetCoffee($todayCoffee);
            // }
        }
        //RESETCOFFEE LAAT ALLES CRASHEN
        // if (date('Y-m-d',strtotime($todayCoffee->updated_at)) != $current_date) {
        //     //$todayCoffee = $this->_resetCoffee($user);
        //     //$todayCoffee = $this->_resetCoffee($todayCoffee);
        //     $todayCoffee= $this->_resetCoffee($todayCoffee);
        // }

        /*$returns=*/
        $this->_updateStreak($user, $todayCoffee);
        // $todayCoffee= $returns[1];
        // $user= $returns[0];


        //test consumations
        $consumations = $this->consumation($user);

        //test consumations



        // $lastCoffee= Coffee::where('user_id', $_SESSION['userId'])->orderBy('created_at', 'desc');
        // $this->set('lastCoffee', $lastCoffee);
        if (!empty($_POST['action'])) {
            if ($_POST['action'] == 'addCoffee') {
                $result = $this->_handleAddCoffee($todayCoffee, $user);
                if ($result['result'] == 'ok') {
                    header('Location: index.php?page=profile');
                    exit();
                } else {
                    $this->set('errors', $result['data']);
                }
            }
        }
        //test consumation
        $this->set('AmountAlternatives', Consumation::where('user_id', $user->id)->count());
        $this->set('consumations', $consumations);
        //test consumation
        $this->set('test', $todayCoffee->succesfull);
        $this->set('todayCoffee', $todayCoffee);
        $this->set('user', $user);
        $this->set('title', 'profile');
    }

    //test consumation
    public function consumation($user)
    {
        $consumations = Consumation::where('user_id', $user->id)->get();
        $data = [];
        foreach ($consumations as $con) {
                $object = new stdClass();
                $object->name = $con->recipe->name;
                $object->amount = Consumation::where('recipe_id', $con->recipe_id)->count();
                array_push($data, $object);
            // if (!in_array($con->recipe->name, $data)) {
            //     $object = new stdClass();
            //     $object->name = $con->recipe->name;
            //     $object->amount = Consumation::where('recipe_id', $con->recipe_id)->count();
            //     array_push($data, $object);
            // }
        }
        return $data;
    }

    //test  consumation


    public function login()
    {
        // $errors= [];
        if (!empty($_POST['action'])) {
            if ($_POST['action'] == 'login') {
                //test errors
                $errors=[];
                $tryingUser = User::where('username', $_POST['username'])->first();
                if (!empty($tryingUser)) {
                    if ($tryingUser->password == $_POST['password']) {
                        //check for update streak
                        //$this->_updateStreak($tryingUser);
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $tryingUser->username;
                        $_SESSION["userId"] = $tryingUser->id;
                        header('Location: index.php?page=profile');
                        exit();
                    } else {
                        //echo ('<p>password incorrect, try again</p>');
                         $errors['incorrectPassword']= 'Password incorrect, try again.';
                    }
                } else {
                    //echo ('<p>no such user</p>');
                     $errors['noUser']= "User doesn't exist.";
                }
                $this->set('errors', $errors);
            }
        }
        /*if(!empty($trophies)){
            $this->set('trophies', $tryingUser->detox);
        }*/
        if (!empty($tryingUser)) {
            $this->set('user', $tryingUser);
        }
        $this->set('title', 'login');
    }
    //newest updatestreak
    public function _updateStreak($user, $todayCoffee)
    {
        $changes = [];
        $date = new DateTime(date('Y-m-d'));
        //formula for calculating allowedamount of that day
        $todayAllowedAmount = 10 - (($user->streak) + 1);
        $lastdayStreak = new DateTime(date($user->lastDayStreak));

        // if($todayCoffee->currentAmount > 10-($user->streak+1)){
        //         $todayCoffee->succesfull = false;
        //     }
        //things to check
        if ($todayCoffee->succesfull = true && $user->lastDayStreak == date('Y-m-d')) {
            //return [$user, $todayCoffee];
        }
        //alles ok dag ervoor
        else if ($todayCoffee->succesfull = true && $todayCoffee->currentAmount < $todayAllowedAmount && $date != $lastdayStreak && $date->diff($lastdayStreak)->days <= 1) {
            $this->_resetCoffee($todayCoffee);
            $user->streak++;
            $user->lastDayStreak = date('Y-m-d');
            $user->save();
            //exit("done ok dag ervoor");
        }
        //dag niet ingelogd

        //if coffee amount exceeds and is same day -> basically make sucessfull false and dip
        else if ($todayCoffee->currentAmount > $todayAllowedAmount && $todayCoffee->updated_at == $date) {
            $todayCoffee->succesfull = false;
            $todayCoffee->save();
            //exit("done exceeds same day");
        }
        //if coffee amount was exceeded and it was other day -> reset current amount coffe, succesfull = 1
        else if ($date->diff($lastdayStreak)->days <= 1 && $todayCoffee->succesfull == false) {
            $this->_resetCoffee($todayCoffee);
            $user->streak = 0;
            $user->lastDayStreak = date('Y-m-d');
            $user->save();
            //exit("done exceeds other day");
        } else if ($date->diff($lastdayStreak)->days > 1) {
            $this->_resetCoffee($todayCoffee);
            $user->streak = 0;
            $user->lastDayStreak = date('Y-m-d');
            $user->save();
            //exit("done dag niet ingelogd");
        } else {
            //exit("done nothing");
        }
        //test if work laat dit weg
        //return [$user, $todayCoffee];

        //if lastdaystreak was longer than one day -> streak = 0, reset amount coffee, successfull 1

        //when everything ok add day to streak

    }

    //OG _UPDATESTREAK
    // public function _updateStreak($tryingUser, $todayCoffee)
    // {
    //     $changes = [];
    //     $date = new DateTime(date('Y-m-d'));
    //     //check if info already in session -> skip query

    //     $lastdayStreak = new DateTime(date($tryingUser->lastDayStreak));
    //     //also check for succesfull
    //     //START TEST CODE SUCCESFULL
    //     // print($tryingUser->coffees->succesfull);
    //     //checks when the previous day wasn't succesfull
    //     if  ($todayCoffee->succesfull == false && $todayCoffee->updated_at != date('Y-m-d')){
    //         $tryingUser->streak= 0;
    //         $this->_resetCoffee($todayCoffee);
    //         // $todayCoffee->succesfull = 1;
    //         // $todayCoffee->currentAmount = 0;
    //         $tryingUser->lastDayStreak = date('Y-m-d');
    //         $tryingUser->save();
    //         // $todayCoffee->save();
    //         $changes["steak reset"] = "you're streak has been reset because you drank too much coffee";
    //         exit();
    //     }
    //     //checks when you exceeded the amount of today -> the streak won't be reset the day itself
    //     //otherwhise if you drank 8 on a day of 7 the streak would reset to a day of 9 allowed
    //     //which would return the day as succesfull which isn't what we want
    //     if($todayCoffee->succesfull == false && $todayCoffee->updated_at == date('Y-m-d')){
    //         $changes["steak already reset by add coffee"] = "you're streak has been reset because you drank too much coffee this day";
    //         exit();
    //     }
    //     //meestal gebruikt na addcoffee
    //     //als de amount overschreden is maar de todaycoffee still succesfull is en de datum = vandaag
    //     //deze methode is geschreven omdat we eerst de streak resetten in addcoffee maar dit gaf fouten en is
    //     //overzichtelijker als alle resetfuncties in 1 functie staan
    //     $todayAllowedAmount= 10-($tryingUser->streak+1);
    //     if($todayCoffee->succesfull== true && $todayCoffee->updated_at == date('Y-m-d') && $todayCoffee->currentAmount > $todayAllowedAmount){
    //         // print('this is the case');
    //         $tryingUser->streak= 0;
    //         $tryingUser->lastDayStreak= date('Y-m-d');
    //         $todayCoffee->succesfull = false;
    //         $todayCoffee ->save();
    //         $tryingUser->save();
    //         // header('Location: index.php?page=profile');
    //        // exit();
    //     }
    //     if($todayCoffee->succesfull== true && $todayCoffee->updated_at != date('Y-m-d') && $todayCoffee->currentAmount > $todayAllowedAmount){
    //         // print('this is the case');
    //         $this->_resetCoffee($todayCoffee);
    //         // $todayCoffee ->save();
    //         // header('Location: index.php?page=profile');
    //         //exit();
    //     }
    //     //END TESTCODE SUCCESFULL
    //     if ($date->diff($lastdayStreak)->days > 1) {
    //         // if($tryingUser->lastDayStreak->date_diff($date)->days > 1){
    //         $tryingUser->streak = 0;
    //         $tryingUser->lastDayStreak = $date;
    //         $tryingUser->save();
    //         $changes["steak reset"] = "you're streak has been reset because you didn't log in yesterday";
    //         //exit();
    //     } 
    //     else if ($date->diff($lastdayStreak)->days <= 1 && $tryingUser->lastDayStreak != date('Y-m-d')) {
    //         $tryingUser->streak++;
    //         $todayCoffee->updated_at = date('Y-m-d');
    //         //$this->_updateDetox($tryingUser);
    //         $tryingUser->lastDayStreak = $date;
    //         $tryingUser->save();
    //         $todayCoffee->save();
    //         $changes["new streak set"] = "A new streak has been set";
    //         //header('Location: index.php?page=profile');
    //     } else {
    //         // exit();
    //         $changes["no changes has been made"] = "you have already logged in today";
    //     }

    //     // $recommendAmount= Detox::find($tryingUser->streak+1);
    //     // $this->set('recommendedAmount', $recommendAmount);
    //     $this->set('date', $date);
    //     return [$tryingUser, $todayCoffee];
    // }
    //END OG UPDATESTREAK



    //function written at 5am idk man probably trying to get the highest achieved detox skip for
    //now man
    // public function _updateDetox($user)
    // {
    //     //will get the highest achieved detox by this user
    //     $highestDetox = Detox::where('user_id', $user->id)->orderBy('id', 'desc')->first();
    //     //the highest day is the id of the highest detox -1
    //     if ($highestDetox - 1 < $user->streak) {
    //         $detox = new Detox;
    //         $detox->user_id = $user->id;
    //         $detox->detox_id = $highestDetox;
    //         $detox->save();
    //     } else {
    //         // exit();
    //     }
    // }





    public function signup()
    {
        // session_start();
        //make user if handle ok
        if (!empty($_POST["action"])) {
            //start making basic username, password user
            if ($_POST["action"] === "addUser") {
                //check if username already exists, if not continue
                if (!User::where('username', $_POST['username'])->get()->count() != 0) {
                    //validate form
                    $user = new User;
                    $user->username = $_POST['username'];
                    $user->password = $_POST['password'];
                    $user->repeatPassword = $_POST['repeatPassword'];
                    $user->streak = 0;
                    $user->lastDayStreak = date('Y-m-d');
                    $errors = User::validatesignup($user);
                    if (empty($errors)) {
                        //make new user because in the db repeatPassword is not stored
                        //bit redundant but was easiest way, if i would save user above would give errors
                        $user = new User;
                        $user->username = $_POST['username'];
                        $user->password = $_POST['password'];
                        $user->streak = 0;
                        $user->lastDayStreak = date('Y-m-d');
                        $user->save();
                        $_SESSION['userId'] = $user->id;
                        $_SESSION['username'] = $_POST['username'];
                        $_SESSION['password'] = $_POST['password'];
                        header('Location: index.php?page=characterName');
                        // exit();
                    } else {
                        $this->set('errors', $errors);
                    }

                    // $newUser= new User;
                    //posts hoogstwaarschijnlijk vervangen door sessionsvariables
                    // $newUser->username= $_POST["username"];
                    // $newUser->password=$_POST["password"];
                    //$newUser->character->name = $_POST['characterName'];
                    //color, head, body for character
                } else {
                    $errors['user exists'] = 'user already exists';
                    $this->set('errors', $errors);
                }
            }
            //make a character name for the user's character

            //make a character with the chosen attributes
        }
        $this->set('title', 'signup');
    }

    public function characterName()
    {
        //get id of user that was signed up
        // $signedUpId= User::where('username', $_SESSION['username'])->get();
        // $signedUpId= User::where('username', $_POST['username'])->get();
        // $this->set('signedUpId', (array) $signedUpId);
        // echo("<p> dev phase check: ".$signedUpId."</p>");
        if (!empty($_POST["action"])) {
            if ($_POST["action"] == "characterName") {
                //these sessions don't work but the ones in signup do, why you bully php
                // $_SESSION['userId']= $signedUpId[0]['id'];
                $_SESSION['characterName'] = $_POST['characterName'];
                //geen html uitputten voor de header zoals de p van dev phase hierboven
                header('Location: index.php?page=characterGenerator');
                // exit();

            }
        }
        $this->set('title', 'characterName');
    }

    public function characterGenerator()
    {
        //setting sessions test
        // $_SESSION['characterName']= $_POST['characterName'];
        // $signedUpId= User::where('username', $_SESSION['username'])->get();
        // $_SESSION['userId']= $signedUpId->id;
        //end setting sessions test
        if (!empty($_POST["action"])) {
            if ($_POST["action"] == "characterGenerator") {
                $character = new Character;
                // $character->id= $_SESSION['userId'];
                $character->user_id = $_SESSION['userId'];
                $character->name = $_SESSION['characterName'];
                $character->color = $_POST['color'];
                $character->head = $_POST['characterHead'];
                $character->body = $_POST['characterBody'];
                $errors = Character::validate($character);

                if (empty($errors)) {
                    $character->save();
                    //saving so we don't have to query it on the home page when we redirect
                    $_SESSION['color'] = $_POST['color'];
                    $_SESSION['characterBody'] = $_POST['characterBody'];
                    $_SESSION['characterHead'] = $_POST['characterHead'];
                    $_SESSION['loggedin'] = true;
                    header('Location: index.php?page=profile');
                    exit();
                } else {
                    $this->set("errors", $errors);
                }
            }
        }
        $this->set('title', 'CharacterGenerator');
    }

    public function validatesignup($user)
    {
        $errors = User::validatesignup($user);
        if (empty($errors)) {
            $user->save();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user->username;
            header('Location: index.php?page=profile');
        } else {
            $this->set('errors', $errors);
        }
    }

    //instead of creating new coffee update the values to default
    public function _createCoffee($user)
    {
        $coffee = new Coffee();
        $coffee->user_id = $user->id;
        $coffee->currentAmount = 0;
        $coffee->succesfull = true;
        $errors = Coffee::validate($coffee);
        if (empty($errors)) {
            $coffee->save();
        } else {
            $this->set('errors', $errors);
        }
        return $coffee;
    }
    //instead of making new coffee update the existing one because each user only has one coffee
    //object
    public function _resetCoffee($todayCoffee)
    {
        $todayCoffee->currentAmount = 0;
        $todayCoffee->succesfull = true;
        // $errors = Coffee::validate($todayCoffee);
        // if(empty($errros)){
        $todayCoffee->save();
        // }
        // else{
        //     $this->set('errors', $errors);
        // }
    }

    // public function _handleAddCoffee($todayCoffee, $user)
    // {
    //     // $current_date= new DateTime('now');
    //     //$current_date= date("Y-m-d");
    //     //$todayCoffee= $user->coffees->where('created_at',$current_date)->get();
    //     //$todayCoffee= Coffee::where('user_id', $user->id)->where('created_at', $current_date)->get();
    //     if (empty($todayCoffee)) {
    //         $this->_createCoffee($user);
    //     } else {
    //         // $user->coffees->currentAmount ++;
    //         // $user->coffees->save();
    //          $todayCoffee->currentAmount++;


    //         //check for succesfull
    //         //$this->_updateStreak($user, $todayCoffee);
    //         // if($todayCoffee->currentAmount > 10-($user->streak+1)){
    //         //     // $todayCoffee->succesfull = false;
    //         //     // $user->streak= 0;
    //         //     // $user->save();
    //         //     $this->_updateStreak($user, $todayCoffee);
    //         // }
    //         $todayCoffee->save();
    //         // $this->set('todayCoffee', $todayCoffee);
    //         header('Location: index.php?page=profile');
    //         exit();
    //     }
    // }
    //TEST BUGFIX
    public function _handleAddCoffee($todayCoffee, $user)
    {
        $result = [];
        // $current_date= new DateTime('now');
        //$current_date= date("Y-m-d");
        //$todayCoffee= $user->coffees->where('created_at',$current_date)->get();
        //$todayCoffee= Coffee::where('user_id', $user->id)->where('created_at', $current_date)->get();
        if (empty($todayCoffee)) {
            $this->_createCoffee($user);
        } else {
            // $user->coffees->currentAmount ++;
            // $user->coffees->save();
            $todayCoffee->currentAmount++;

            $todayCoffee->save();
            $result['result'] = 'ok';
            // $this->set('todayCoffee', $todayCoffee);

        }
        return $result;
    }
    //END TEST BUGFIX





    //echo detox data in api
    public function detoxApi()
    {
        $detox = Detox::get();
        echo $detox->toJson();
        exit();
    }

    //lootbox test
    public function lootbox($user)
    {
        // if($user->streak == 3 || $user->streak==7){
        $rareRecipes = Recipe::where('isRare', true)->get();
        $ownedRecipes = $user->recipes;
        foreach ($rareRecipes as $rare) {
            if ($ownedRecipes->contains('name', $rare->name) == false) {
                $user->recipes()->save($rare);
                break;
            }
        }
        // }
    }
    //end lootbox test


}


//$todayCoffee = $user->coffees;
// $todayCoffee->currentAmount= 1;
// $todayCoffee->succesfull= true;
// $errors= Coffee::validate($todayCoffee);
// if (empty($errors)) {
//     $todayCoffee->save();
// } else {
//     $this->set('errors', $errors);
// }
// return $todayCoffee;






// public function signup(){
//     //make user if handle ok
//     if(!empty($_POST["action"])){
//         if($_POST["action"] === "addUser"){
//             //check if username already exists, if not continue
//             if(!User::where('username', $_POST['username'])->get()->count() != 0){
//     $newUser= new User;
//     //posts hoogstwaarschijnlijk vervangen door sessionsvariables
//     $newUser->username= $_POST["username"];
//     $newUser->password=$_POST["password"];
//     //$newUser->character->name = $_POST['characterName'];
//     //color, head, body for character
    
//     $errors = User::validate($newUser);
//     if(empty($errors)){
//       $newUser->save();
//       $_SESSION['loggedin']= true;
//       $_SESSION['username']= $_POST['username'];
//         header('Location: index.php?page=profile');
//     }
//     else{
//       $this->set('errors', $errors);
//     }
//     }
//     else{
//         $errors['user exists']='user already exists';
                  
//         $this->set('errors', $errors);

//     }
            
//         }
//     }
//     $this->set('title','signup');
// }
