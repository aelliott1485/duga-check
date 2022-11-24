<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentScanningResource;
use App\Models\CommentsScanning;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class Check extends Controller
{
    /**
     * https://chat.stackexchange.com/transcript/8595?m=59528368#59528368
     *
     */
    public const TASKS_URL = 'https://duga.zomis.net/tasks';

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getRecentLogs()
    {
        $latest = CommentsScanning::latest()->take(20)->get();
        return CommentScanningResource::collection($latest);
    }
    /**
     * @return JsonResponse
     */
    public function getTimeSinceLastCommentsScanning(): JsonResponse
    {
        $response = $this->getTasksResponse();

        $body =  json_decode($response->getBody());
        $lastCommentsScanning = $body->{'Comments scanning'}->last;
        $difference = time() - $lastCommentsScanning;
        $this->logCommentsScanning($response->status(), $lastCommentsScanning, $difference);

        return response()->json(['difference' => $difference]);
    }

    /**
     * @return \Illuminate\Http\Client\Response
     */
    private function getTasksResponse(): \Illuminate\Http\Client\Response
    {
        return Http::get(self::TASKS_URL);
    }

    /**
     * @param int $status
     * @param int $last
     * @param int $difference
     * @return void
     */
    private function logCommentsScanning(int $status, int $last, int $difference)
    {
        $commentsScanning = new CommentsScanning([
            'status' => $status,
            'last' => $last,
            'difference' => $difference,
            'requestorIp' => request()->getClientIp()
        ]);
        $commentsScanning->save();

    }
}
