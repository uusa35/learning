<?php

namespace App\Services\Traits;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

trait DashboardTrait
{
    public function changeLanguage()
    {
        app()->setLocale(request('locale'));
        session()->put('locale', request('locale'));
        return redirect()->back();
    }

    public function toggleActivate(Request $request)
    {
        $validate = validator($request->all(), [
            'model' => 'string|required',
            'id' => 'integer|required'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors()->first());
        }
        $className = 'App\Models\\' . ucfirst($request->model);
        $element = new $className();
        $element = $element->whereId($request->id)->first();
        $element->update([
            'active' => !$element->active
        ]);
        return redirect()->back()->with('success', trans('general.process_success'));
    }

    public function toggleFeatured(Request $request)
    {
        $className = '\App\Models\\' . Str::title($request->model);
        $element = new $className();
        $element = $element->withoutGlobalScopes()->whereId($request->id)->first();
        if (isset($element->featured)) {
            $element->update([
                'featured' => !$element->featured
            ]);
            return redirect()->back()->with('success', 'Process Success');
        }
        return redirect()->back()->with('error', 'Process Failure .. no such thing');
    }

    public function toggleOnHome(Request $request)
    {
        $className = '\App\Models\\' . Str::title($request->model);
        $element = new $className();
        $element = $element->withoutGlobalScopes()->whereId($request->id)->first();
        if (isset($element->on_home)) {
            $element->update([
                'on_home' => !$element->on_home
            ]);
            return redirect()->back()->with('success', 'Process Success');
        }
        return redirect()->back()->with('error', 'Process Failure .. no such thing');
    }

    public function toggleOnSale(Request $request)
    {
        $className = '\App\Models\\' . Str::title($request->model);
        $element = new $className();
        $element = $element->withoutGlobalScopes()->whereId($request->id)->first();
        if (isset($element->on_sale)) {
            $element->update([
                'on_sale' => !$element->on_sale
            ]);
            return redirect()->back()->with('success', 'Process Success');
        }
        return redirect()->back()->with('error', 'Process Failure .. no such thing');
    }

    public function toggleAccessDashBoard(Request $request)
    {
        $className = '\App\Models\\' . Str::title($request->model);
        $element = new $className();
        $element = $element->withoutGlobalScopes()->whereId($request->id)->first();
        $element->update([
            'access_dashboard' => !$element->access_dashboard
        ]);
        return redirect()->back()->with('success', 'Process Success');
    }


    public function clearElement(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'id' => 'required|integer',
            'colName' => 'required|string'
        ]);
        $className = '\App\Models\\' . Str::title($request->model);
        $element = new $className();
        $element = $element->withoutGlobalScopes()->whereId($request->id)->first();
        $element->update([
            $request->colName => ''
        ]);
        return redirect()->back()->with('success', 'Image Cleared!');
    }

    public function BackupDB()
    {
        Artisan::call('backup:db');
        return back()->with('success', 'db packed successfully');
    }

    public function exportTranslations()
    {
        Artisan::call('publish-trans');
        return redirect()->back()->with('success', 'translations exported');
    }

    public function createNotification($element)
    {
        $element = Product::active()->hasAttributes()->first();
        $this->notify(
            trans(
                'message.notification_message',
                [
                    'type' => 'testing',
                    'name' => $element->name,
                    'project_name' => $element->name
                ]
            ),
            '',
            [
                'file' => asset('storage/uploads/files/' . $element->path),
                'title' => $element->name,
                'type' => 'pdf'
            ]
        );
    }

    public function uploadImages(Request $request)
    {
        try {
            $validate = validator($request->all(), [
                'images' => 'array|required|between:0,3',
                'model' => 'string|required',
                'id' => 'integer'
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()->first()]);
            }
            $className = 'App\Models\\' . ucfirst($request->model);
            $element = new $className();
            if ($request->id) {
                $element = $element->whereId($request->id)->with('images')->first();
            } else {
                $element = $element->latest()->first();
            }
            //            $request->has('images') ? $this->saveGallery($element, $request, 'images', ['1500', '1080'], false) : null;;
            $result = $request->has('images') ? $this->saveGallery($element, $request, 'images', ['1080', '1440'], false) : null;
            return response()->json(['message' => trans('general.process_success')], 200);
        } catch (\Exception $e) {
            // return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function goBack(Request $request)
    {
        return request()->has('module') ? redirect()->route('backend.' . $request->module . '.index') : redirect()->back();
    }

    public function trashed(Request $request)
    {
        $validate = validator($request->all(), [
            'model' => 'string|required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors()->first());
        }
        $model = request()->model;
        $className = 'App\Models\\' . ucfirst($request->model);
        $element = new $className();
        $elements = $element->onlyTrashed()->paginate(Self::TAKE_LESS);
        return inertia('Backend/Trashed/TrashedIndex', compact('elements', 'model'));
    }

    public function restore(Request $request)
    {
        $validate = validator($request->all(), [
            'model' => 'string|required',
            'id' => 'integer|required'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors()->first());
        }
        $className = 'App\Models\\' . ucfirst($request->model);
        $element = new $className();
        $element = $element->withTrashed()->whereId($request->id)->first();
        if ($element->trashed()) {
            $element->restore();
        }
        return redirect()->back()->with('success', trans('general.progress_success'));
    }
}
