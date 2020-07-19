<?php

namespace App\Traits;

trait ApiResponse
{
    /*
     *  1xx: Informational	Communicates transfer protocol-level information.
        2xx: Success	Indicates that the client’s request was accepted successfully.
        3xx: Redirection	Indicates that the client must take some additional action in order to complete their request.
        4xx: Client Error	This category of error status codes points the finger at clients.
        5xx: Server Error	The server takes responsibility for these error status codes.

        1×× Informational

        100 Continue
        101 Switching Protocols
        102 Processing

        2×× Success

        200 OK
        201 Created
        202 Accepted
        203 Non-authoritative Information
        204 No Content
        205 Reset Content
        206 Partial Content
        207 Multi-Status
        208 Already Reported
        226 IM Used

        3×× Redirection

        300 Multiple Choices
        301 Moved Permanently
        302 Found
        303 See Other
        304 Not Modified
        305 Use Proxy
        307 Temporary Redirect
        308 Permanent Redirect

        4×× Client Error

        400 Bad Request
        401 Unauthorized
        402 Payment Required
        403 Forbidden
        404 Not Found
        405 Method Not Allowed
        406 Not Acceptable
        407 Proxy Authentication Required
        408 Request Timeout
        409 Conflict
        410 Gone
        411 Length Required
        412 Precondition Failed
        413 Payload Too Large
        414 Request-URI Too Long
        415 Unsupported Media Type
        416 Requested Range Not Satisfiable
        417 Expectation Failed
        418 I’m a teapot
        421 Misdirected Request
        422 Unprocessable Entity
        423 Locked
        424 Failed Dependency
        426 Upgrade Required
        428 Precondition Required
        429 Too Many Requests
        431 Request Header Fields Too Large
        444 Connection Closed Without Response
        451 Unavailable For Legal Reasons
        499 Client Closed Request

        5×× Server Error

        500 Internal Server Error
        501 Not Implemented
        502 Bad Gateway
        503 Service Unavailable
        504 Gateway Timeout
        505 HTTP Version Not Supported
        506 Variant Also Negotiates
        507 Insufficient Storage
        508 Loop Detected
        510 Not Extended
        511 Network Authentication Required
        599 Network Connect Timeout Error
     */

    protected function successResponse($data)
    {
        return response()->json(['data' => $data], 200);
    }

    protected function successTokenResponse($data)
    {
        return response()->json($data, 200);
    }

    protected function createdResponse($data)
    {
        return response()->json(['data' => $data], 201);
    }

    private function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function badRequestResponse($message)
    {
        return $this->errorResponse($message,400);
    }

    protected function unauthorizedResponse($message)
    {
        return $this->errorResponse($message,401);
    }

    protected function forbiddenResponse($message)
    {
        return $this->errorResponse($message,403);
    }

    protected function notFoundResponse($message)
    {
        return $this->errorResponse($message,404);
    }

    protected function methodNotAllowedResponse($message)
    {
        return $this->errorResponse($message,405);
    }

    protected function NotAcceptableResponse($message)
    {
        return $this->errorResponse($message,406);
    }

    protected function conflictResponse($message)
    {
        return $this->errorResponse($message,409);
    }

    protected function unprocessableEntityResponse($message)
    {
        return $this->errorResponse($message,422);
    }

    protected function internalServerErrorResponse($message)
    {
        return $this->errorResponse($message,500);
    }
}
