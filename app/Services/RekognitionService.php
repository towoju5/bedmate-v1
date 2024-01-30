<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RekognitionService
{
    protected $rekognition;

    public function __construct()
    {
        $this->rekognition = new RekognitionClient(config('services.rekognition'));
    }

    public function compareFaces($sourceImage, $targetImage)
    {
        $arr = [
            'SourceImage' => [
                'Bytes' => file_get_contents($sourceImage),
            ],
            'TargetImage' => [
                'Bytes' => file_get_contents($targetImage),
            ],
        ];
        // return $arr;
        $result = $this->rekognition->compareFaces($arr);

        return $result;
    }

    /**
     * Compare faces using azure
     */
    public function matchFaces(Request $request)
    {
        $image1 = $request->file('image1')->get();
        $image2 = $request->file('image2')->get();

        $subscriptionKey = env('AZURE_FACE_SUBSCRIPTION_KEY');
        $endpoint = env('AZURE_FACE_ENDPOINT');

        $url = "$endpoint/verify";

        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
            'Content-Type' => 'application/octet-stream',
        ])->attach('faceId1', $this->detectFace($image1))->attach('faceId2', $this->detectFace($image2))->post($url);
        // Log::info(json_encode(['log-1' => $response]));
        $result = $response->json();

        // Process the result as needed
        return response()->json($result);
    }

    private function detectFace($image)
    {
        $subscriptionKey = env('AZURE_FACE_SUBSCRIPTION_KEY');
        $endpoint = env('AZURE_FACE_ENDPOINT');

        $url = "$endpoint/detect";

        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
            'Content-Type' => 'application/octet-stream',
        ])->attach('image', $image, 'image.jpg')->post($url);
        
        Log::info(json_encode(['log-2' => $response]));
        $result = $response->json();

        // Assuming the first face in the result is the one we want to use
        if (!empty($result) && isset($result[0]['faceId'])) {
            return $result[0]['faceId'];
        }

        return null;
    }
}
