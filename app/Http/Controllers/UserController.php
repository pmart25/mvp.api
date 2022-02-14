<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Auth;
use App\Models\Product;

class UserController extends Controller
{
    //

    public function index()
    {
        return User::all();
    }


    public function show(Product $user)
    {
        return User::find($id);
    }

    
    public function createUser($userName, $email, $password, $deposit , $role)
    {
        
        $result = User::createUser($userName, $email, $password, $deposit, $role);
        
        return response()->json($result, 200);
    }



    public function getDeposit($userId){

        return User::getDeposit($userId);
    }


    public function resetDeposit(){

        $userId = auth()->user()->id;
        $userRole = auth()->user()->role;
        if (strcmp($userRole, "buyer") != 0) {  //if user role is not a buyer
            echo "User is not a buyer. Only buyer users can reset the deposit.";
            return 0;

        }
        return User::resetDeposit($userId);
    }

    public function deposit($amountMoney)
    {

        $user = auth()->user();
        
        if (strcmp($user->role, "buyer") != 0) {  //if user role is not a buyer
            echo "User is not a buyer. Only buyer users can introduce coins.";
            return 0;

        }

   

        $amountMoney = intval($amountMoney);
        switch ($amountMoney){
            case 5: break;
            case 10: break;
            case 20: break;
            case 50: break;
            case 100: break;
            default:
            echo "Coin not of 5,10,20,50 or 100 Cents. Please introduce a valid coin.";
            return 0;


        }
            
        $depositUser = self::getDeposit($user->id);

        if ($depositUser == 500) {
            echo "Not possible deposit more than 500 cents.";
            return 0;
  
         }


        //$depositUser = intval($depositUser) + intval($amountMoney);
        User::addDeposit($amountMoney);
        $response = "User : ".$user->username." has a deposit of ".$user->deposit;
        return $response;
    }


    public function buy($productId)
    {
        $user = auth()->user();
       
        if (strcmp($user->role, "buyer") != 0) {  //if user role is not a buyer
            echo "User is not a buyer. Only buyer users can buy a products.";
            return 0;

        }

        
        //check if product ist available?
        //return the amonut spent of the deposit and the change returning a array of 5, 10, 20, 50, 100

        $product = Product::where('id', $productId)->first();
        

        //check if product ist available?
        if ( intval($product->amountAvailable) <=  0 ) {  //if product cost is greater than user deposit ; user has no enough money to buy the product. 
            echo "No Product available in our Stock. Please buy other product.";
            return 0;

        }


        //check if user has enough Money?
        if ( $product->cost  >=  $user->deposit ) {  //if product cost is greater than user deposit ; user has no enough money to buy the product. 
            echo "User: ".$user->username." has no enough money in the deposit ( deposit user =".$user->deposit.") to buy the product ( product cost =".$product->cost."). Please introduce more money into the deposit.";
            return 0;

        }



        //everything is ok then

        echo "deposit of user before buy  a  product: ". User::getDeposit($user->id)."\n";
        echo "making transaction\n";
        Product::buyProduct($productId);  //update the Product DB.
        echo "update deposit\n";
        User::spendDeposit($product->cost); //update the User Deposit DB.

        $change = array( 
            "coin_5" => 0, 
            "coin_10" => 0,
            "coin_20" => 0,
            "coin_50" => 0,
            "coin_100" => 0,   
        );

        $restDeposit =  intval(User::getDeposit($user->id));
       
        
                    
        $buyTransaction = "User ". $user->username. "  bought the product " .$product->productName  . ". The product cost is  ". $product->cost. ". Actual User deposit after buy a product is ". $restDeposit . ". And the change is: ";
        echo $buyTransaction;
       

        $change = array( 
            "coin_5" => 0, 
            "coin_10" => 0,
            "coin_20" => 0,
            "coin_50" => 0,
            "coin_100" => 0,   
        );

        
   
        

       while ($restDeposit != 0) {
                if ($restDeposit >= 100 ) {                                                    //restDeposit greater than 100
                    echo "change is grater than 100: ".$restDeposit."\n";
                    $restDeposit = $restDeposit-100;
                    $change["coin_100"] = $change["coin_100"]+1;
                    if ($restDeposit >= 50 && $restDeposit < 100 ) {                           //restDeposit greater than 50 and less than 100
                        echo "change is grater than 50: ".$restDeposit."\n";
                        $restDeposit = $restDeposit-50;
                        $change["coin_50"] = $change["coin_50"]+1;
                        if ($restDeposit >= 20 && $restDeposit < 50 ) {                      //restDeposit greater than 20 and less than 50
                            echo "change is grater than 20: ".$restDeposit."\n";
                            $restDeposit = $restDeposit-20;
                            $change["coin_20"] = $change["coin_20"]+1;
                            if ($restDeposit >= 10 && $restDeposit < 20 )) {                      //restDeposit greater than 10 and less than 20
                                echo "change is grater than 20: ".$restDeposit."\n";
                                $restDeposit = $restDeposit-10;
                                $change["coin_10"] = $change["coin_10"]+1;
                                if ($restDeposit >= 5 && $restDeposit < 10 ) {                      //restDeposit greater than 5 and less than 10
                                    echo "change is grater than 20: ".$restDeposit."\n";
                                    $restDeposit = $restDeposit-5;
                                    $change["coin_5"] = $change["coin_5"]+1;
                                    if ($restDeposit <= 5) {                                       //for avoiding missmatches...
                                        $restDeposit = 0;
                                    }//end if less than 5 
                                }//end if coin_5  
                            }//end if coin_10  
                        }//end if coin_20      
                }//end if coin_50
        }//end if coin_100


       } //end while


        print_r($change);


        self::resetDeposit($user->id);
        return 1;

        

    }
}
