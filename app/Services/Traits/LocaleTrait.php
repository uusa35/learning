<?php
namespace App\Services\Traits;

trait LocaleTrait
{

    /**
     * @param $name
     * @return localized string
     * Return Localized String
     */
    public function __get($name)
    {
        if (in_array($name, $this->localeStrings)) {

            $appLang = app()->getLocale();

            if ($appLang == 'en') {

                if (!is_null($this->{$name . '_en'})) {

                    return $this->{$name . '_en'};

                }

                return $this->{$name . '_ar'};

            } else {

                if (!is_null($this->{$name . '_ar'})) {

                    return $this->{$name . '_ar'};

                }

                return $this->{$name . '_en'};
            }
        }

        return parent::__get($name);
    }
}