<?php namespace ReaZzon\JWTAuth\Models;

use Model;

class BuddiesSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'reazzon_jwtauth_buddies_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
