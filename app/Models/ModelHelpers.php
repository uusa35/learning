<?php

/**
 * Created by PhpStorm.
 * User: usama
 * Date: 5/10/18
 * Time: 2:34 PM
 */

namespace App\Models;

use App\Services\Search\QueryFilters;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait ModelHelpers
{
    /**
     * @param $q
     * @return \Illuminate\Database\Eloquent\Builder
     * QueryFilters used within the search
     */
    public function scopeActive($q): void
    {

        $q->where("active", true);
    }

    public function scopeOnHome($q): void
    {
        $q->where("on_home", true);
    }

    public function scopeOnNew($q): void
    {
        $q->where("on_new", true);
    }

    public function scopeAvailable($q): void
    {
        $q->where("is_available", true);
    }

    public function scopeIsFeatured($q): void
    {
        $q->where(["is_featured" => true]);
    }

    public function scopeHasImage($q): void
    {
        $q->has("images", ">", 0);
    }

    public function scopeActiveUsers($q): void
    {
        $q->whereHas("user", function ($u) {
            return $u->active();
        });
    }

    /**
     * @param $q
     * @param QueryFilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     * QueryFilters used within the search
     */
    public function scopeFilters($q, QueryFilters $filters)
    {
        return $filters->apply($q);
    }

    public function getImageLargeAttribute()
    {
        if (env("FILESYSTEM_DISK") === "local") {
            return asset(env("LARGE") . $this->image);
        } else if (env("FILESYSTEM_DISK") === "do") {
            return env("DO_ROOT_URL") . "/" . (env("DO_BUCKET") . "/" . env("LARGE") . $this->image);
        }
    }

    public function getImageMediumAttribute()
    {

        if (env("FILESYSTEM_DISK") === "local") {

            return asset(env("MEDIUM") . $this->image);
        } else if (env("FILESYSTEM_DISK") === "do") {
            return env("DO_ROOT_URL") . "/" . (env("DO_BUCKET") . "/" . env("MEDIUM") . $this->image);
        }
    }

    public function getThumbAttribute()
    {
        if (!is_null($this->image)) {
            if (env("FILESYSTEM_DISK") === "local") {
                return asset(env("THUMBNAIL") . $this->image);
            } else if (env("FILESYSTEM_DISK") === "do") {
                return env("DO_ROOT_URL") . "/" . (env("DO_BUCKET") . "/" . env("THUMBNAIL") . $this->image);
            }
        }
    }

    public function getCurrentImageAttribute($colName = "image", $sizeType = "thumbnail")
    {
        if (env("FILESYSTEM_DISK") === "local") {
            return asset(env("THUMBNAIL") . $this->image);
        } else if (env("FILESYSTEM_DISK") === "do") {
            return env("DO_ROOT_URL") . "/" . (env("DO_BUCKET") . "/" . env("THUMBNAIL") . $this->{$colName});
        }
        // return $this->{$colName} ? asset(env(strtoupper($sizeType)) . $this->{$colName}) : "";
    }

    public function checkStorageSpaces()
    {
        return env("FILESYSTEM_DISK") === "do";
    }

    public function getStorageSpacesUrl($sizeType = "large")
    {
        return env("DO_ROOT_URL") . env(strtoupper("DO_" . $sizeType));
    }

    public function getPathLinkAttribute()
    {
        return asset(env("FILES") . $this->path);
    }

    public function getFileLinkAttribute()
    {
        return asset(env("FILES") . $this->file);
    }

    public function getTypeAttribute()
    {
        return strtolower(class_basename($this));
    }
}
