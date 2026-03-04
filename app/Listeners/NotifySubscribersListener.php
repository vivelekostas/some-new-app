<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PostPublishedEvent;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Метод handle слушателя выполняет любые действия,
 * необходимые для реагирования на событие.
 */
class NotifySubscribersListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    // todo отдельно реализовать уведомление автора о том, что на него подписался новый читатель ?

    /**
     * Отправляет уведомления подписчикам автора о его новых постах.
     *
     * @param PostPublishedEvent $event
     * @return void
     */
    public function handle(PostPublishedEvent $event): void
    {
        $author = $event->post->author();

        $author->subscribers->each(function ($subscriber) use ($event) {
            $subscriber->notify(
                new NewPostNotification($event->post)
            );
        });
    }
}
