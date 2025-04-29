<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class SendEmailForm extends Component
{
    public $name;
    public $email;
    public $message;

    public function sendEmail()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $details = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];

        Mail::to('notify@uic.edu.ph')->send(new ContactFormMail($details));

        session()->flash('success', 'Email sent successfully!');
        $this->reset();
    }


    public function render()
    {
        return view('livewire.send-email-form');
    }
}
