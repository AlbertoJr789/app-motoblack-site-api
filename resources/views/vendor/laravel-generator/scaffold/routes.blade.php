Route::group(['prefix' => '{{$config->modelNames->camel}}', 'as' => '{{$config->modelNames->camelPlural}}.', 'middleware' => 'permission:{{$config->modelNames->camel}}.view'],function(){
    Route::get('/', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class,'index'])->name('index');
    Route::get('dataTableData',[App\Http\Controllers\{{ $config->modelNames->name }}Controller::class,'dataTableData'])->name('dataTableData');
});