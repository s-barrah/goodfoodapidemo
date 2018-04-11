<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;


class RecipeController extends Controller
{

    protected $url = 'https://www.bbcgoodfood.com/recipes/collection/top-20-spring';

    /**
     * Recipes page view.
     */
    public function index(){

        //GET WEBPAGE URL
        $url = $this->url;

        //GET HTML CONTENTS
        $html = file_get_contents($url);

        //
        $recipe_doc = new \DOMDocument();

        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        // creating an array of elements
        $recipes = [];

        if(!empty($html)){//if any html is actually returned

            // load HTML
            $recipe_doc->loadHTML($html);

            // Restore error level
            libxml_use_internal_errors($internalErrors);

            $recipe_xpath = new \DOMXPath($recipe_doc);

            //GET RECIPE ROWS
            $recipe_row = $recipe_xpath->query('//div[@class="view-content"]//article[@id]');

            if($recipe_row->length > 0){
                for($i = 0; $i < $recipe_row->length; $i++){

                    //get the recipe name
                    $recipe_name = $recipe_xpath->query('//h3[@class="teaser-item__title"]')->item($i)->nodeValue;

                    //get the cooking time
                    $cooking_time = $recipe_xpath->query('//li[@class="teaser-item__info-item teaser-item__info-item--total-time"]')->item($i)->nodeValue;

                    //get the description
                    $description = $recipe_xpath->query('//div[@class="field-item even"]')->item($i)->nodeValue;

                    //STORE IN ARRAY
                    $recipes[] = array('recipe_name' => $recipe_name, 'description' => $description, 'cooking_time' => $cooking_time);
                }

            }
        }

        //Convert array to JSON
        $jsonData = json_encode($recipes, JSON_PRETTY_PRINT);

        //
       // dd($jsonData);

        //return response()->json($data);
        return view('recipes.index')
            ->with('pageTitle', 'Recipes')
            ->with('pageID', 'recipes')
            ->with('recipes', $recipes)
            ->with('jsonData', $jsonData);


    }






}
