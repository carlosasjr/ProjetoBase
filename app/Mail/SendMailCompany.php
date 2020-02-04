<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailCompany extends Mailable
{
    use Queueable, SerializesModels;

    private $company;
    private $senha;

    /**
     * SendMailCompany constructor.
     * @param Company $company
     * @param $senha
     */
    public function __construct(Company $company, $senha)
    {
        $this->company = $company;
        $this->senha = $senha;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('tenants.companies.mail.bemvindo')
                    ->with([
                        'company' => $this->company,
                        'senha' => $this->senha
                    ]);
    }
}
