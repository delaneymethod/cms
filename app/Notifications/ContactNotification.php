<?php
/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactNotification extends Notification implements ShouldQueue
{
	use Queueable;
	
	/**
	 * Information about the form.
	 *
	 * @var string
	 */
	protected $form;
	
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($form)
	{
		$this->form = $form;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) : array
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
		$data = [
			'contactFirstName' => $this->form->first_name,
			'contactLastName' => $this->form->last_name,
			'contactEmail' => $this->form->email,
			'contactTelephone' => $this->form->telephone,
			'contactSubject' => $this->form->subject,
			'contactMessage' => $this->form->message,
		];
		
		return (new MailMessage)->view('emails.contact', $data)->subject($this->form->subject);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable) : array
	{
		$data = [
			'contactFirstName' => $this->form->first_name,
			'contactLastName' => $this->form->last_name,
			'contactEmail' => $this->form->email,
			'contactTelephone' => $this->form->telephone,
			'contactSubject' => $this->form->subject,
			'contactMessage' => $this->form->message,
		];
	}
}
