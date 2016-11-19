<?php namespace WebEd\Base\Settings\Repositories\Contracts;

interface SettingContract
{
    /**
     * Get all settings
     * @return mixed
     */
    public function getAllSettings();

    /**
     * Get setting by key
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey);

    /**
     * Update all settings
     * @param array $settings
     * @return mixed
     */
    public function updateSettings($settings = []);

    /**
     * Update each setting
     * @param $key
     * @param $value
     * @return mixed
     */
    public function updateSetting($key, $value);
}
