<?php

use App\Helpers\ImageHelper;
use App\Models\Settings;
use App\Models\User;

if (!function_exists('getUsers')) {
    /* 
     * @param array $options
     *
     */
    function getUsers($userId = null)
    {
        $user = $userId ?? auth()->id();
        return  User::findorfail($user);
    }
}

if (!function_exists('save_image')) {
    /* 
     * @param array $options
     *
     */
    function save_image($image, $path)
    {
        $upload = ImageHelper::save_image($image, 'uploads');
        return  $upload;
    }
}

if (!function_exists('get_commision')) {
    /* 
     * @param array $options
     *
     */
    function get_commision($amount, $percentage)
    {
        $commission = (($amount / 100) * $percentage);
        return $commission;
    }
}

if (!function_exists('settings')) {
    /**
     * Gera a paginação dos itens de um array ou collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return Strings
     */
    function settings(string $key):string
    {
        $setting = Settings::where('key', $key)->first();
        if (!empty($setting)) {
            $setting = $setting->value;
        } else {
            return "$key not Found!";
        }

        return $setting;
    }
}

if (!function_exists('per_page')) {
    /**
     * Gera a paginação dos itens de um array ou collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return Strings
     */
    function per_page($per_page = 5):string
    {
        return $per_page;
    }
}

if (!function_exists('to_array')) {
    /**
     * convert object to array
     */
    function to_array($data) : array
    {
        if(null == $data){
            return [];
        }
        if (is_array($data)) {
            return $data;
        } else if (is_object($data)) {
            return json_decode(json_encode($data), true);
        } else {
            return json_decode($data, true);
        }
    }
}

if (!function_exists('get_error_response')) {
    /**
     * Return success response for the requested action
     * @param boolen status false
     * @param string Error message
     * @param array error response
     */
    function get_error_response($msg, $code = 400)
    {
        $msg = [
            'status' => false,
            'message' => 'Please check your request',
            'errors' => $msg
        ];
        return response()->json($msg, $code);
    }
}

if (!function_exists('get_success_response')) {
    /**
     * Return success response for the requested action
     * @param boolen status true
     * @param string message
     * @param array data response
     */
    function get_success_response($msg)
    {
        $msg = [
            'status'    => true,
            'message'   => 'Request successful',
            'data'      => $msg
        ];
        return response()->json($msg, 200);
    }
}