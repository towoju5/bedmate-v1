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
    }
}
