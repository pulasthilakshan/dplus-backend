<?php
Route::get('/greet', function() {
	return View::make('hello');
});

Route::get('/cat', function() {

	return View::make('category');
});

Route::get('/item', function() {

	return View::make('items');
});


Route::post('/cat', function() {
	//adding values to the database from the input fields
	$category = new Category;
	$category->cat_name = Input::get('cat_name');
	$category->description = Input::get('description');
	$category->image = time().'.jpeg';


	$data = Input::get('image_input');

	//decoding the image
	if($data){
		$imgstr = urldecode($data);
		$im = imagecreatefromjpeg($imgstr);
		imagejpeg($im, 'Uploads/graphics/categories/'.time().'.jpeg', 70);
		imagedestroy($im);
	}

	$saveFlag = $category->save();

	if($saveFlag) {
		return 'Category Added!!';
	}
});

Route::post('/add', function() {
	//adding values to the database from the input fields
	$item = new Item;
	$item->item_name = Input::get('item_name');
	$item->cat_id = Input::get('category');
	$item->description = Input::get('description');
	$item->image = time().'.jpeg';

	$data = Input::get('image_input');

	//decoding the image
	if($data){
		$imgstr = urldecode($data);
		$im = imagecreatefromjpeg($imgstr);
		imagejpeg($im, 'Uploads/graphics/items/'.time().'.jpeg', 70);
		imagedestroy($im);
	}

	$saveFlag = $item->save();

	if($saveFlag) {
		return 'Item Added!!';
	}
});

Route::get('/image','ImageController@addShow');

Route::post('/addImage', 'ImageController@add');


Route::post('/loadItem',function(){

	$cat_id = Input::get('cat_id');
	
	$items = Item::where('cat_id','=',$cat_id)->get();
	
	return Response::json($items);
});


Route::get('/getAllImages','ImageController@getAllImages');

Route::get('/getImageData','ImageController@getImageData');

//Comment