<?php

namespace App\Services\Traits;

/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 2/6/17
 * Time: 8:21 AM
 */

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageHelpers
{
    /**
     * @param  Model  $model
     * @param  Request  $request
     * @param  array  $inputNames
     * @param  array  $sizes
     * @param  array  $dimensions
     * @param  boolean  $ratio
     * @return null
     */
    public function saveMimes(
        Model $model,
        Request $request,
        $inputNames = ['pdf'],
        $dimensions = ['1052', '1320'],
        $ratio = true,
        $enableBg = false,
        $sizes = ['large', 'medium', 'thumbnail']
    ) {
        try {

            foreach ($inputNames as $key => $inputName) {
                if ($request->hasFile($inputName)) {
                    if (in_array($request->file($inputName)->extension(), ['pdf', 'ppt'], true)) {
                        $path = $request->$inputName->store('public/uploads/files');
                        $path = str_replace('public/uploads/files/', '', $path);
                        $model->update([
                            $inputName => $path,
                        ]);
                    } else {
                        if (in_array($request->file($inputName)->extension(), ['gif'], true)) {
                            if (env('FILESYSTEM_DISK') === 'do') {
                                $this->checkImageSize($request->$inputName);
                                $imagePath = $request->$inputName->storePublicly('storage/uploads/images/thumbnail');
                                $request->$inputName->storePublicly('storage/uploads/images/large');
                                $request->$inputName->storePublicly('storage/uploads/images/medium');
                                $path = str_replace('storage/uploads/images/thumbnail/', '', $imagePath);
                            } else {
                                $this->checkImageSize($request->$inputName);
                                $request->$inputName->storePublicly('public/uploads/images/thumbnail');
                                $request->$inputName->storePublicly('public/uploads/images/medium');
                                $path = $request->$inputName->storePublicly('public/uploads/images/large');
                                $path = str_replace('public/uploads/images/large/', '', $path);
                            }
                            $model->update([
                                $inputName => $path,
                            ]);
                        } else {
                            if (env('FILESYSTEM_DISK') === 'do') {
                                $this->checkImageSize($request->$inputName);
                                $imagePath = $request->$inputName->storePublicly('storage/uploads/images/thumbnail');
                                $request->$inputName->storePublicly('storage/uploads/images/large');
                                $request->$inputName->storePublicly('storage/uploads/images/medium');
                                $imagePath = str_replace('storage/uploads/images/thumbnail/', '', $imagePath);
                            } else {
                                $this->checkImageSize($request->$inputName);
                                $imagePath = $request->$inputName->storePublicly('public/uploads/images');
                                $imagePath = str_replace('public/uploads/images/', '', $imagePath);
                                if ($enableBg) {
                                    $this->saveImageVersionsWithBg($imagePath, $ratio, $dimensions);
                                } else {
                                    $this->saveImageVersionsWithResize($imagePath, $ratio, $dimensions);
                                }
                            }
                            $model->update([
                                $inputName => $imagePath,
                            ]);
                            Storage::delete('public/uploads/images/' . $imagePath);
                        }
                    }
                } else {
                    // in case there is no file
                    return response()->json(['message' => 'else case for image'], 400);
                }
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }


    public function checkImageSize($img)
    {
        if (filesize($img) > 450000) {
            abort(404, 'image is large. reduce image size to (450kb)');
        }
    }
    /**
     * @param  Request  $request
     * @param  array  $inputNames
     * @param  string  $width
     * @param  string  $height
     */
    public function saveImage(
        Request $request,
        $inputNames = 'image',
        $dimensions = ['1200', '560'],
        $sizes = ['large', 'medium', 'thumbnail']
    ) {
        try {
            foreach ($inputNames as $inputName) {
                if ($request->hasFile($inputName)) {
                    if (in_array($request->file($inputName)->extension(), ['pdf', 'ppt'], true)) {
                        $pdfPath = $request->$inputName->store('public/uploads/files');
                        $pdfPath = str_replace('public/', '', $pdfPath);
                        return $pdfPath;
                    } else {
                        if (env('FILESYSTEM_DISK') === 'do') {
                            $imagePath = $request->$inputName->storePublicly('storage/uploads/images/thumbnail');
                            $request->$inputName->storePublicly('storage/uploads/images/large');
                            $request->$inputName->storePublicly('storage/uploads/images/medium');
                            $imagePath = str_replace('storage/uploads/images/thumbnail/', '', $imagePath);
                            return $imagePath;
                        } else {
                            $imagePath = $request->$inputName->store('public/uploads/images');
                            $imagePath = str_replace('public/uploads/images/', '', $imagePath);
                            $img = Image::make(storage_path('app/public/uploads/images/' . $imagePath));
                            foreach ($sizes as $key => $value) {
                                switch ($value) {
                                    case $value === 'large':
                                        $this->saveIt($img, $dimensions[0], $value, $imagePath);
                                        break;
                                    case $value === 'medium':
                                        $this->saveIt($img, $dimensions[0] / 2, $value, $imagePath);
                                        break;
                                    case $value === 'thumbnail':
                                        $this->saveIt($img, $dimensions[0] / 3, $value, $imagePath);
                                        break;
                                    default:
                                        $this->saveIt($img, $dimensions[0] / 2, $value, $imagePath);
                                }
                            }
                            Storage::delete('public/uploads/images/' . $imagePath);
                            return $imagePath;
                        }
                    }
                } else {
                    // in case there is no file
                    return null;
                }
            }
        } catch (\Exception $e) {
            abort(404, 'save Image Error : ' . $e->getMessage());
        }
    }

    /**
     * @param  Model  $model
     * @param  Request  $request
     * @param  string  $inputName
     * @param  array  $dimensions
     * @param  bool  $ratio
     * @param  array  $sizes
     */
    public function saveGallery(
        Model $model,
        Request $request,
        $inputName = 'images',
        $dimensions = ['1052', '1320'],
        $ratio = true,
        $sizes = ['large', 'medium', 'thumbnail']
    ) {

        try {
            if ($request->hasFile($inputName)) {
                if (count($request[$inputName]) > 1) {
                    foreach ($request[$inputName] as $image) {
                        // if (env('FILESYSTEM_DISK') === 'do') {
                        //     try {
                        //         $path = $image->storePublicly('public/uploads/images', 'do');
                        //         $imagePath = str_replace('public/uploads/images/', '', $path);
                        //         foreach ($sizes as $k => $value) {
                        //             //                                    $image->storePublicly('public/uploads/images/' . $value . '', 'do');
                        //             Storage::disk('do')->copy(
                        //                 $path,
                        //                 'public/uploads/images/' . $value . '/' . $imagePath
                        //             );
                        //         }
                        //     } catch (\Exception $e) {
                        //         return $e->getMessage();
                        //     }
                        // } else {

                        if (env('FILESYSTEM_DISK') === 'do') {
                            $this->checkImageSize($image);
                            $imagePath = $image->storePublicly('storage/uploads/images/thumbnail');
                            $image->storePublicly('storage/uploads/images/large');
                            $image->storePublicly('storage/uploads/images/medium');
                            $imagePath = str_replace('storage/uploads/images/thumbnail/', '', $imagePath);
                        } else {

                            $imagePath = $this->saveImageForGallery($image, $dimensions, $ratio, $sizes, $model);
                        }
                        $model->images()->create([
                            'image' => $imagePath,
                        ]);
                    }
                } else {
                    if (env('FILESYSTEM_DISK') === 'do') {
                        $this->checkImageSize($request[$inputName][0]);
                        $imagePath = $request[$inputName][0]->storePublicly('storage/uploads/images/thumbnail');
                        $request[$inputName][0]->storePublicly('storage/uploads/images/large');
                        $request[$inputName][0]->storePublicly('storage/uploads/images/medium');
                        $imagePath = str_replace('storage/uploads/images/thumbnail/', '', $imagePath);
                    } else {
                        $imagePath = $this->saveImageForGallery(
                            $request[$inputName][0],
                            $dimensions,
                            $ratio,
                            $sizes,
                            $model
                        );
                    }
                    return $model->images()->create([
                        'image' => $imagePath,
                    ]);
                }
            } else {
                return null;
            }
        } catch (\Exception $e) {
            abort(403, 'save Error : ' . $e->getMessage());
        }
    }

    public function saveIt($img, $width, $sizeType, $imagePath)
    {
        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(
            storage_path('app/public/uploads/images/' . $sizeType . '/' . $imagePath),
            env('IMAGE_QUALITY'),
            'jpg'
        );
        if (env('FILESYSTEM_DISK') === 'do') {
            try {
                $fullPath = 'public/uploads/images/' . $sizeType . '/' . $imagePath;
                $contents = Storage::disk('local')->get($fullPath);
                Storage::disk('do')->put($fullPath, $contents, 'public');
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function saveImageForGallery($image, $dimensions, $ratio, $sizes, $model)
    {
        try {
            $this->checkImageSize($image);
            $imagePath = $image->store('public/uploads/images');
            $imagePath = str_replace('public/uploads/images/', '', $imagePath);
            $this->saveImageVersionsWithBg($imagePath, $ratio);
            Storage::delete(public_path('storage/uploads/images/' . $imagePath));
            return $imagePath;
        } catch (\Exception $e) {
            return $e;
        }
    }


    /**
     * @param  Model  $model
     * @param  Request  $request
     * @param  array  $inputNames
     * @param  array  $sizes
     * @param  array  $dimensions
     * @param  boolean  $ratio
     * @return null
     */
    public function saveMimesGroup(
        Model $model,
        Request $request,
        $inputNames = 'images',
        $dimensions = ['1052', '1320'],
        $ratio = true,
        $sizes = ['large', 'medium', 'thumbnail']
    ) {
        try {
            if ($request->has($inputNames)) {
                foreach ($request->$inputNames as $k => $v) {
                    $imagePath = $request->$inputNames[$k]->store('public/uploads/images');
                    $imagePath = str_replace('public/uploads/images/', '', $imagePath);
                    $img = Image::make(storage_path('app/public/uploads/images/' . $imagePath));
                    foreach ($sizes as $key => $value) {
                        if ($value === 'large') {
                            if ($ratio) {
                                $img->resize($dimensions[0], null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            } else {
                                $img->resize($dimensions[0], $dimensions[1]);
                            }
                            $img->save(
                                storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                                env('IMAGE_QUALITY'),
                                'jpg'
                            );
                        } elseif ($value === 'medium') {
                            if ($ratio) {
                                $img->resize($dimensions[0], null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            } else {
                                $img->resize($dimensions[0] / 2, $dimensions[1] / 2);
                            }
                            $img->save(
                                storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                                env('IMAGE_QUALITY'),
                                'jpg'
                            );
                        }
                        if ($value === 'thumbnail') {
                            if ($ratio) {
                                $img->resize('300', null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            } else {
                                $img->resize($dimensions[0] / 3, $dimensions[1] / 3);
                            }
                            $img->save(
                                storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                                env('IMAGE_QUALITY'),
                                'jpg'
                            );
                        }
                    }
                    $newImage = \App\Models\Image::create(['user_id' => $model->id, 'name' => $imagePath]);
                    $newImage ? Storage::delete('public/uploads/images/' . $imagePath) : null;
                }
            } else {
                return new \Excption('no values [] !!');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function savePath($element, Request $request, $colName = 'file')
    {
        try {
            if ($request->hasFile($colName)) {
                $path = $request->file($colName)->store('public/uploads/files');
                $path = str_replace('public/uploads/files/', '', $path);
                if (env('FILESYSTEM_DISK') === 'do') {
                    try {
                        $fullPath = 'public/uploads/files/' . $path;
                        $contents = Storage::disk('local')->get($fullPath);
                        Storage::disk('do')->put($fullPath, $contents, 'public');
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
                $element->update([$colName => $path]);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveImageVersionsWithBg(
        $imagePath,
        $ratio = true,
        $dimensions = ['1080', '1440'],
        $sizes = ['large', 'medium', 'thumbnail'],
        $bg = '#ffffff'
    ) {
        try {
            $img = Image::make(storage_path('app/public/uploads/images/' . $imagePath));
            $background = Image::canvas($dimensions[0], $dimensions[1], $bg);
            foreach ($sizes as $key => $value) {
                if ($value === 'large') {
                    if ($ratio) {
                        $large = Image::make($background);
                        $large->insert($img->resize($dimensions[0], null, function ($constraint) {
                            $constraint->aspectRatio();
                        }), 'center');
                        $large->save(
                            storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                            env('IMAGE_QUALITY'),
                            'jpg'
                        );
                    } else {
                        $img->resize($dimensions[0], $dimensions[1]);
                        $img->save(
                            storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                            env('IMAGE_QUALITY'),
                            'jpg'
                        );
                    }
                } elseif ($value === 'medium') {
                    if ($ratio) {
                        $medium = Image::make($background)->resize($dimensions[0] / 2, $dimensions[1] / 2);
                        $medium->insert($img->resize($dimensions[0] / 2, null, function ($constraint) {
                            $constraint->aspectRatio();
                        }), 'center');
                        $medium->save(
                            storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                            env('IMAGE_QUALITY'),
                            'jpg'
                        );
                    } else {
                        $img->resize(
                            $dimensions[0] / 2,
                            $dimensions[1] / 2
                        )->save(
                            storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                            env('IMAGE_QUALITY'),
                            'jpg'
                        );
                    }
                } elseif ($value === 'thumbnail') {
                    if ($ratio) {
                        $thumbnail = Image::make($background)->resize($dimensions[0] / 3, $dimensions[1] / 3);
                        $thumbnail->insert($img->resize($dimensions[0] / 3, null, function ($constraint) {
                            $constraint->aspectRatio();
                        }), 'center');
                        $thumbnail->save(
                            storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                            env('IMAGE_QUALITY'),
                            'jpg'
                        );
                    } else {
                        $img->resize(
                            $dimensions[0] / 3,
                            $dimensions[1] / 3
                        )->save(
                            storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                            env('IMAGE_QUALITY'),
                            'jpg'
                        );
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }

    public function saveImageVersionsWithResize(
        $imagePath,
        $ratio = true,
        $dimensions = ['1080', '1440'],
        $sizes = ['large', 'medium', 'thumbnail'],
        $bg = '#ffffff'
    ) {
        try {
            $img = Image::make(storage_path('app/public/uploads/images/' . $imagePath));
            foreach ($sizes as $key => $value) {
                if ($value === 'large') {
                    if ($ratio) {
                        $img->resize($dimensions[0], null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $img->resize($dimensions[0], $dimensions[1]);
                    }
                    $img->save(
                        storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                        env('IMAGE_QUALITY'),
                        'jpg'
                    );
                } elseif ($value === 'medium') {
                    if ($ratio) {
                        $img->resize($dimensions[0] / 2, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $img->resize(
                            $dimensions[0] / 2,
                            $dimensions[1] / 2
                        );
                    }
                    $img->save(
                        storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                        env('IMAGE_QUALITY'),
                        'jpg'
                    );
                } elseif ($value === 'thumbnail') {
                    if ($ratio) {
                        $img->resize($dimensions[0] / 3, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $img->resize($dimensions[0] / 3, $dimensions[1] / 3);
                    }
                    $img->save(
                        storage_path('app/public/uploads/images/' . $value . '/' . $imagePath),
                        env('IMAGE_QUALITY'),
                        'jpg'
                    );
                }
            }
        } catch (\Exception $e) {
        }
    }
}
