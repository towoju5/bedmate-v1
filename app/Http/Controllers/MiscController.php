<?php

namespace App\Http\Controllers;

use App\Services\RekognitionService;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    protected $rekognitionService;

    public function __construct(RekognitionService $rekognitionService)
    {
        $this->rekognitionService = $rekognitionService;
    }

    public function compare(Request $request)
    {
        $request->validate([
            'image_1' => 'required',
            'image_2' => 'required'
        ]);

        $image1 = $request->file('image_1');
        $image2 = $request->file('image_2');
        $result = compare_image($image1, $image2);
        if (isset($result['isIdentical'])) {
            if ($result['isIdentical'] == 1) {
                echo "Same Person ";
            } else if ($result['isIdentical'] == 0) {
                echo "Different Person ";
            }
        }

        return response()->json($result);
    }


    /**
     * Amazon face rekognition API
     */
    public function verifyImages()
    {
        try {
            $compare = $this->rekognitionService->matchFaces(request());
            return response()->json($compare);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }
}
