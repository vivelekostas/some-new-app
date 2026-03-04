<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Метод handle слушателя выполняет любые действия,
 * необходимые для реагирования на событие.
 */
class NotifyAuthorAboutCommentListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    // todo добавить throttling (не более X писем в минуту) ?
    // todo сгруппировать несколько комментариев в одно письмо ?
    // todo добавить “не уведомлять, если уже есть непрочитанное” ?
    /**
     * Отправляет уведомления автору о новых комментариях к его постам.
     *
     * @param CommentCreatedEvent $event
     * @return void
     */
    public function handle(CommentCreatedEvent $event): void
    {
        $author = $event->comment->post->author;

        // Не уведомляем самого себя
        if ($author->id !== $event->comment->user_id) {
            $author->notify(
                new NewCommentNotification($event->comment)
            );
        }
    }
}
