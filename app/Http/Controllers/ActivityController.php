<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

/**
 * @OA\Info(title="Activity API", version="0.1")
 */
class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recomended",
     *     summary="Get a list of users recomendation",
     *     tags={"Activity"},
     *     @OA\Response(response=200, description="Successful operation"),
     * )
     */
    public function index(Request $request)
    {
        $recomended = User::paginate(10);
        return $recomended;
    }

    /**
     * @OA\Post(
     *     path="/api/activity",
     *     summary="Store Like or dislike",
     *     tags={"Activity"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="from_profile_id",
     *                     description="id logged in user",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="to_profile_id",
     *                     description="id liked by logged in user",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="activity",
     *                     description="like or dislike",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function giveActivity(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'from_profile_id' => 'required',
            'to_profile_id' => 'required',
            'activity' => 'required',
        ]);

        $newActivity = new Activity([
            'from_profile_id' => $request->from_profile_id,
            'to_profile_id' => $request->to_profile_id,
            'activity' => $request->activity,
        ]);

        $newActivity->save();

        return $newActivity;
    }

    /**
     * @OA\Get(
     *     path="/api/liked/{from_profile_id}",
     *     summary="Get a list of users liked",
     *     tags={"Activity"},
     *     @OA\Parameter(
     *         name="from_profile_id",
     *         in="path",
     *         description="Profile ID of user to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     * )
     */
    public function viewLiked(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'from_profile_id' => 'required',
        ]);
        $likedPeoples = Activity::where('activity','like')
            ->where('from_profile_id',$request->from_profile_id)
            ->get();
        return $likedPeoples;
    }
}
