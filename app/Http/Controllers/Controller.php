<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *      @OA\Info(
 *          version="1.0.0",
 *          title="Note Taking",
 *          description="Note Taking"
 *      ),
 *     @OA\Server(
 *          description="Local development server",
 *          url="http://127.0.0.1:8000"
 *      ),
 *      @OA\Components(
 *          @OA\SecurityScheme(
 *              securityScheme="bearerAuth",
 *              type="http",
 *              scheme="bearer",
 *              bearerFormat="JWT"
 *          ),
 *          @OA\Schema(
 *              schema="NewNote",
 *              required={"title", "content"},
 *              @OA\Property(
 *                  property="title",
 *                  type="string",
 *                  description="Title of the note"
 *              ),
 *              @OA\Property(
 *                  property="content",
 *                  type="string",
 *                  description="Content of the note"
 *              )
 *          ),
 *          @OA\Schema(
 *              schema="UpdateNote",
 *              @OA\Property(
 *                  property="title",
 *                  type="string",
 *                  description="Title of the note"
 *              ),
 *              @OA\Property(
 *                  property="content",
 *                  type="string",
 *                  description="Content of the note"
 *              )
 *          ),
 *          @OA\Schema(
 *              schema="Note",
 *              required={"id", "user_id", "title", "content", "created_at", "updated_at"},
 *              @OA\Property(
 *                  property="id",
 *                  type="integer",
 *                  description="Note ID"
 *              ),
 *              @OA\Property(
 *                  property="user_id",
 *                  type="integer",
 *                  description="ID of the user who owns the note"
 *              ),
 *              @OA\Property(
 *                  property="title",
 *                  type="string",
 *                  description="Title of the note"
 *              ),
 *              @OA\Property(
 *                  property="content",
 *                  type="string",
 *                  description="Content of the note"
 *              ),
 *              @OA\Property(
 *                  property="created_at",
 *                  type="string",
 *                  format="date-time",
 *                  description="Creation time of the note"
 *              ),
 *              @OA\Property(
 *                  property="updated_at",
 *                  type="string",
 *                  format="date-time",
 *                  description="Update time of the note"
 *              )
 *          )
 *      )
 * )
 */


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
