<?php

namespace App\Traits;

use App\Services\ImageUploader\ImageUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Trait ImageUtilsTrait
 * @package App\Traits
 */
trait AdminImageTrait {
	/**
	 * @param $request
	 * @param string $storageDisk
	 * @param string $file_name
	 * @param string $isMulti
	 * @param string $index
	 *
	 * @return mixed
	 * @throws \App\Services\ImageUploader\Exceptions\FileExtensionInvalidException
	 * @throws \App\Services\ImageUploader\Exceptions\FileSizeException
	 * @throws \App\Services\ImageUploader\Exceptions\FileUploadFailedException
	 */
	public function storeImage( $request, string $storageDisk, $file_name, $isMulti = 0, $index = 0 ) {


		$imageUploader = new ImageUploader( $storageDisk, '', '', [ 'png', 'jpg', 'jpeg' ] );
		$customPath    = $request->model . '/';
		if ( $isMulti ) {
			$image = $imageUploader->uploadFile( $request->file( $file_name )[ $index ], '', '', $customPath );
		} else {
			$image = $imageUploader->uploadFile( $request->file( $file_name ), '', '', $customPath );

		}


		$destinationPath = Storage::disk( $storageDisk )->getDriver()->getAdapter()->getPathPrefix().$customPath;
		$urlPath         = Storage::disk( $storageDisk )->url( '' ) . $customPath;
		
		$imageData=[];

		foreach ( config( 'image.sizes.' . $request->type ) as $imageSize => $value ) {
			$imageName               = $image['originalFileName'] . $value['postfix'] . '.' . $image['extension'];
			$imageData[ $imageSize ] = $urlPath . $imageName;


			if ( $value['height'] ) {

				Image::make( $destinationPath . $image['name'] )
				     ->resize( $value['width'], $value['height'] )
				     ->save( $destinationPath . $imageName );
			} else {
				Image::make( $destinationPath . $image['name'] )
				     ->resize( $value['width'], null, function ( $constraint ) {
					     $constraint->aspectRatio();
				     } )
				     ->save( $destinationPath . $imageName );
			}


		}



		return $imageData;
	}

	/**
	 * @param Model $appModel
	 * @param string $model
	 * @param string $type
	 * @param array $newImages
	 * @param array $oldImages
	 *
	 * @throws \App\Services\ImageUploader\Exceptions\FileNotFoundException
	 */

	/**
	 * @param string $name
	 * @param string $ext
	 * @param string $postfix
	 *
	 * @return string
	 */
	public function makeImageName( string $name, string $ext, string $postfix = '' ) {
		$ext          = '.' . $ext;
		$originalName = str_replace( $ext, '', $name );

		return $originalName . $postfix . $ext;
	}

}
