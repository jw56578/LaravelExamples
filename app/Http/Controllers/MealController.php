<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Meal;
/*
the names of all these functions are specific. as defined in the documentation
*/
class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::all();
        return view('meals.index')->with('meals',$meals); //makes there be a variable called $meals in the view
    }
    public function create()
    {
        return view("meals.create");
    }
    public function store(Request $request)
    {
        $meal = new Meal;
        $meal->name = $request->name;
        $meal->save();

        //easier way to do this
        //$inputs = $request->all();
        //$easierway = Meal::Create($inputs);

        return redirect()->action('MealController@index');
    }
    public function show($id)
    {
        $meal = Meal::find($id);

    }
}