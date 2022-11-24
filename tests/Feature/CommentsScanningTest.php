<?php

namespace Tests\Feature;

use App\Http\Controllers\Check;
use App\Http\Resources\CommentScanningResource;
use App\Mail\CommentScanningLogNotRecent;
use App\Models\CommentsScanning;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CommentsScanningTest extends TestCase
{
    use RefreshDatabase;

    private const TEST_RESPONSE = <<<JSON
{"Comments scanning":{"name":"Comments scanning","count":23893,"last":<last>,"next":1669163161}}
JSON;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_fetching_tasks_returns_a_successful_response()
    {
        Mail::fake();
        $difference = 100;
        $time = time() - $difference;
        Http::fake(fn () => Http::Response(str_replace('<last>', $time, self::TEST_RESPONSE)));
        $response = $this->get('/time-since-last-comments-scanning');

        $response->assertOk()->assertJsonFragment(['difference' => $difference]);
        $this->assertDatabaseHas('comments_scanning_log', [
            'status' => 200,
            'last' => $time
        ]);
        Mail::assertNothingSent();
    }

    public function test_mail_sent_when_no_last_scanning_found()
    {
        Mail::fake();
        $difference = 1000;

        $time = time() - $difference;
        Http::fake([
            Http::Response(str_replace('<last>', $time, self::TEST_RESPONSE))
        ]);

        $response = $this->get('/time-since-last-comments-scanning');
        $response->assertOk()->assertJsonFragment(['difference' => $difference]);

        Mail::assertSent(CommentScanningLogNotRecent::class);
    }

    public function test_fetching_last_comment_scanning_logs()
    {
        $logs = CommentsScanning::factory(4)->create();
        $response = $this->get('/recent-logs');
        $collection = CommentScanningResource::collection($logs);
        $response->assertOk()->assertJsonPath('data', json_decode($collection->toJson(), true));

    }
}
