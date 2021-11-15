<?php

namespace App\Listeners;

use App\Events\ViewPost;
use App\Services\ViewService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePostView implements ShouldQueue
{
    public $connection = 'redis';

    public function __construct(private ViewService $viewService)
    {
    }

    /**
     * Handle the event.
     *
     * @param  ViewPost  $event
     * @return void
     */
    public function handle(ViewPost $event)
    {
        $this->viewService->view($event->post, $event->user);
    }
}
