<?php

namespace WebEd\Base\Core\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->_validator_UniqueMultiple();
        $this->_validator_DateMultiFormat();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function _validator_UniqueMultiple()
    {
        Validator::extend('unique_multiple', function ($attribute, $value, $parameters, $validator) {
            $table = array_shift($parameters);

            $query = \DB::table($table);

            foreach ($parameters as $i => $field) {
                $query->where($field, $validator->getData()[$field]);
            }

            // Validation result will be false if any rows match the combination
            return ($query->count() == 0);
        });
    }

    private function _validator_DateMultiFormat()
    {
        /**
         * @see http://stackoverflow.com/questions/32006092/laravel-5-1-date-format-validation-allow-two-formats
         */
        Validator::extend('date_multi_format', function ($attribute, $value, $formats) {
            // iterate through all formats
            foreach ($formats as $format) {
                // parse date with current format
                $parsed = date_parse_from_format($format, $value);

                // if value matches given format return true=validation succeeded
                if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                    return true;
                }
            }

            // value did not match any of the provided formats, so return false=validation failed
            return false;
        });
    }
}
