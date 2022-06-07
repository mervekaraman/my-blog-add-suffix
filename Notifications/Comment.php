<?php

namespace Modules\MyBlog\Notifications;

use App\Abstracts\Notification;
use App\Models\Setting\EmailTemplate;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\MyBlog\Models\Comment as Model;

class Comment extends Notification
{
    /**
     * The comment model.
     *
     * @var Model
     */
    public $comment;

    /**
     * The email template.
     *
     * @var EmailTemplate
     */
    public $template;

    public function __construct($comment = null, $template_alias = null)
    {
        parent::__construct();

        $this->comment = $comment;
        $this->template = EmailTemplate::alias($template_alias)->first();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $message = $this->initMailMessage();

        return $message;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        $this->initArrayMessage();

        return [
            'template_alias' => $this->template->alias,
            'title' => trans('my-blog::notifications.menu.' . $this->template->alias . '.title'),
            'description' => trans('my-blog::notifications.menu.' . $this->template->alias . '.description', $this->getTagsBinding()),
            'post_id' => $this->comment->post->id,
            'post_name' => $this->comment->post->name,
            'comment_id' => $this->comment->id,
            'comment_author' => $this->comment->owner->name,
        ];
    }

    public function getTags(): array
    {
        return [
            '{post_name}',
            '{post_author}',
            '{post_admin_link}',
            '{comment_author}',
            '{comment_description}',
            '{company_name}',
        ];
    }

    public function getTagsReplacement(): array
    {
        return [
            $this->comment->post->name,
            $this->comment->post->owner->name,
            route('my-blog.posts.show', $this->comment->post->id),
            $this->comment->owner->name,
            $this->comment->description,
            $this->comment->company->name,
        ];
    }
}
