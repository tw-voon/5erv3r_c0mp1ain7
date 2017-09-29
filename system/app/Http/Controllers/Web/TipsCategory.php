<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Http\Controllers\VoyagerBreadController;

class TipsCategory extends Controller
{
    use BreadRelationshipParser;
    private $VoyagerBreadController;

    public function __construct()
    {
        $this->VoyagerBreadController = new VoyagerBreadController();
    }

    function index(Request $request){
    	return $this->VoyagerBreadController->index($request);
    }

    function show(Request $request, $id){
    	$slug = $this->VoyagerBreadController->getSlug($request);

    	// GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', "safetytips")->first();

        // Check permission
        Voyager::canOrFail('browse_'.$dataType->name);

        $getter = $dataType->server_side ? 'paginate' : 'get';

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            $relationships = $this->getRelationships($dataType);

            if ($model->timestamps) {
                $dataTypeContent = call_user_func([$model->with($relationships)->where('category_id', $id)->latest(), $getter]);
            } else {
                $dataTypeContent = call_user_func([$model->with($relationships)->orderBy('id', 'DESC'), $getter]);
            }

            //Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name)->where('category_id', $id), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));

        // $dataType = Voyager::model('DataType')->where('slug', '=', "safetytips")->first();

        // // Check permission
        // Voyager::canOrFail('read_'.$dataType->name);

        // $relationships = $this->getRelationships($dataType);
        // if (strlen($dataType->model_name) != 0) {
        //     $model = app($dataType->model_name);
        //     $dataTypeContent = call_user_func([$model->with($relationships), 'findOrFail'], $id);
        // } else {
        //     // If Model doest exist, get data from table name
        //     $dataTypeContent = DB::table($dataType->name)->where('id', $id);
        // }

        // //Replace relationships' keys for labels and create READ links if a slug is provided.
        // $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // // Check if BREAD is Translatable
        // $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // $view = 'voyager::bread.browse';

        // if (view()->exists("voyager::$slug.browse")) {
        //     $view = "voyager::$slug.browse";
        // }

        // return view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }
}
