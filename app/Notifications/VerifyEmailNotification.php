<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $id;
    public $token;
    public $firstname;

    public function __construct($id, $token, $firstname)
    {
        //
        $this->id = $id;
        $this->token = $token;
        $this->firstname = $firstname;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Dear ' . $this->firstname)
                    ->subject('Welcome to BorrowMe!')
                    ->line("Thank you for signing up with BorrowMe, UAE's leading peer-to-peer lending and renting platform that connects individuals who own underused items with people who temporarily need them. You can also sell/buy items through BorrowMe.")
                    ->line("BorrowMe benefits everyone. Lenders make money, borrowers save money, and the Earth's toxic load is reduced – one platform to help them all. I hope you enjoy the experience.")
                    ->line('Here is your verification code: ' . $this->id)
                    ->salutation('Thank You,')
                    ->action('Verify here', url('/user/verify/' . $this->token));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
