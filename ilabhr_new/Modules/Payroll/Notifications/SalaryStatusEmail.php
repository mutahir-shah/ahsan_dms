<?php

namespace Modules\Payroll\Notifications;

use App\Notifications\BaseNotification;
use Carbon\Carbon;
use Modules\Payroll\Entities\SalarySlip;

class SalaryStatusEmail extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $salary;

    public function __construct(SalarySlip $salary)
    {
        $this->salary = $salary;
        $this->company = $this->salary->company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // phpcs:ignore
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
        $url = route('payroll.show', [$this->salary->id]);
        $url = getDomainSpecificUrl($url, $this->company);

        return parent::build()
            // phpcs:ignore
            ->subject(__('payroll::modules.payroll.salarySlip').' '.__('payroll::modules.payroll.'.$this->salary->status).' '.Carbon::parse($this->salary->year.'-'.$this->salary->month.'-01')->format('F Y'))
            ->greeting(__('email.hello').' '.$notifiable->name.'!')
            // phpcs:ignore
            ->line(__('payroll::email.salaryStatus.text').' '.__('payroll::modules.payroll.'.$this->salary->status))
            // phpcs:ignore
            ->line(__('app.month').' - '.Carbon::parse($this->salary->year.'-'.$this->salary->month.'-01')->format('F Y'))
            ->action(__('app.view').' '.__('payroll::modules.payroll.salarySlip'), $url)
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // phpcs:ignore
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
