<?php

if(!function_exists('ImageResize')) {
	function ImageResize($path, $size, $imageData){
		$image = $imageData;
	    $uploadImage = date('YmdHis').rand(10,100).'.'.$image->getClientOriginalExtension();
	    $destinationPath = $path.'thumbnail/';
	    if (!is_dir($destinationPath)) {
	        mkdir($destinationPath, 0777, true);
	        chmod($destinationPath, 0777);
	    }
	    $img = Image::make($image->getRealPath());
	    $img->resize($size['width'], $size['height'], function ($constraint) {
	        $constraint->aspectRatio();
	    })->save($destinationPath.'/'.$uploadImage);
	    
	    $destinationPath = $path;
	    $image->move($destinationPath, $uploadImage);

	    return $uploadImage;
	}
	if (! function_exists('public_path')) {
		/**
		 * Get the path to the public folder.
		 *
		 * @param  string  $path
		 * @return string
		 */
		function public_path($path = '')
		{
			return app()->make('path.public').($path ? DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR) : $path);
		}
	}
}