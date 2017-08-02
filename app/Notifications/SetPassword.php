<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SetPassword extends Notification implements ShouldQueue
{
    use Queueable;
	
	protected $appName;
	
	protected $appUrl;
	
	protected $firstName;
	
	protected $token;
	
	protected $subject;
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, string $firstName, string $subject = 'Set Password')
    {
		$this->appName = config('app.name');
		
		$this->appUrl = config('app.url');
		
		$this->token = $token;
		
		$this->firstName = $firstName;
		
		$this->subject = $subject;
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
		$data = array(
			'appName' => $this->appName,
			'firstName' => $this->firstName, 
			'setPasswordUrl' => url('/password/reset', $this->token)
		);
            
		return (new MailMessage)->view('emails.passwords.create', $data)->subject($this->subject);
	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
