<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Meal extends Model //Eloquent
{
    #this is how you specificaly tell it what table to map to
    //protected $table = 'meal';
    #but you don't have to do this

    #you do not have to specify any properties explicitly, they will just be there based on the table
    #the table will not automatically get created when you first acces the model, the table needs to exist already


}
