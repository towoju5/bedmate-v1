<?php

use App\Models\Settings;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use SapientPro\ImageComparatorLaravel\Facades\Comparator;
use SapientPro\ImageComparator\Strategy\DifferenceHashStrategy;

if (!function_exists('getUsers')) {
    /*
     * @param array $options
     *
     */
    function getUsers($userId = null)
    {
        $user = $userId ?? auth()->id();
        return User::findorfail($user);
    }
}

if (!function_exists('save_image')) {
    /*
     * @param array $options
     *
     */
    function save_image($image, $path)
    {
        $image_path = '/storage/' . $path;
        $name = sha1(auth()->id() . time()) . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path($image_path);
        $image->move($destinationPath, $name);
        $paths = "$image_path/$name";
        return asset($paths);
    }
}

if (!function_exists('save_media')) {
    /*
     * @param array $options
     *
     */
    function save_media($videFile, $path)
    {
        $video = $videFile;
        $filename = sha1(auth()->id() . time()) . '.' . $video->getClientOriginalExtension();
        // $path = public_path("videos/$path/$filename");
        $storagePath = "videos/$path/resized_$filename";
        // Save the original video
        Storage::disk('public')->put($storagePath, file_get_contents($video));
        // Define a command to resize the video using FFmpeg
        $ffmpegCommand = "ffmpeg -i $path -vf 'scale=2556:1179' " . public_path($storagePath);
        // Execute the command
        Artisan::call('tinker', [
            'command' => $ffmpegCommand,
        ]);

        return asset($storagePath);
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
    function settings(string $key): string
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
    function per_page($per_page = 10): string
    {
        return $per_page;
    }
}

if (!function_exists('to_array')) {
    /**
     * convert object to array
     */
    function to_array($data): array
    {
        if (null == $data) {
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
    function get_error_response(array $arr, int $code = 400)
    {
        $data = [
            'status' => false,
            'message' => 'Please check your request',
            'errors' => $arr,
        ];
        return response()->json($data, $code);
    }
}

if (!function_exists('get_success_response')) {
    /**
     * Return success response for the requested action
     * @param boolen status true
     * @param string message
     * @param array data response
     */
    function get_success_response(array $arr, int $statusCode = 200)
    {
        $data = [
            'status' => true,
            'message' => 'Request successful',
            'data' => $arr,
        ];
        return response()->json($data, $statusCode);
    }
}

if (!function_exists('compare_image')) {
    /**
     * Compare the similarity between 2 different images
     */
    function compare_image($image1, $image2)
    {
        Comparator::setHashStrategy(new DifferenceHashStrategy());
        $similarity = Comparator::compare($image1, $image2);
        return $similarity;
    }
}

if (!function_exists('getUserByUsername')) {
    /**
     * Compare the similarity between 2 different images
     */
    function getUserByUsername($username)
    {
        $user = User::where('username', $username);
        if ($user->count() > 0) {
            return $user->first();
        }
        return false;
    }
}

if (!function_exists('getUserByMetaData')) {
    /**
     * Compare the similarity between 2 different images
     */
    function getUserByMetaData($userId, $key = null, $value = null)
    {
        $where['user_id'] = $userId;
        if (null != $key) {
            $where['key'] = $key;
        }

        if (null != $value) {
            $where['value'] = $value;
        }

        $user = UserMeta::where($where);
        if ($user->count() > 0) {
            return $user->get();
        }
        return false;
    }
}
