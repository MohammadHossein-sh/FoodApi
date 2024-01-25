<?php

namespace App\Traits;

trait ApiResponser
{


    protected function successPagintaeResponse($name, $data, $links, $meta, $paginate, $code = 200, $message = null)
    {
        $prevLink = $links->prev;
        $nextLink = $links->next;

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                $name => $data,
                "links" => [
                    'first' => $links->first . "&paginate=" . $paginate,
                    'last' => $links->last . "&paginate=" . $paginate,
                    'prev' => $prevLink ? $prevLink . "&paginate=" . $paginate : null,
                    'next' => $nextLink ? $nextLink . "&paginate=" . $paginate : null,
                ],
                "meta" => [
                    "current_page" => $meta->current_page,
                    "from" => $meta->from,
                    "last_page" => $meta->last_page,
                ]
            ],
        ], $code);
    }

    protected function successResponse($data, $code = 200, $message = null)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = null, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code);
    }
}
