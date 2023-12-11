<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    // ... other methods ...

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
<<<<<<< HEAD
        if ($request->expectsJson()) {
            // Handle validation exceptions
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }

            // Handle other HTTP exceptions
            if ($e instanceof HttpException) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }

            // Handle other types of exceptions
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }

        return parent::render($request, $e);
=======
        $this->reportable(function (Throwable $e) {
            try {
                return get_error_response([
                    'error' => $e->getMessage()
                ]);
            } catch (\Throwable $th) {
                return get_error_response([
                    'error' => $th->getMessage()
                ]);
            }
        });
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b
    }
}
