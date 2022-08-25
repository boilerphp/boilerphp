<?php 

namespace App\Notifications;

use Boiler\Core\Messages\Mail\Mail;
use Boiler\Core\Messages\Notification\Notification;

class TestNotification extends Notification {

    public function __construct()
    {
        
    }
    
    public function build() 
    {
        return (new Mail)->from("email@example.com", "John Doe")
                ->to("user@example.com", "User Name")
                ->subject("BoilerPHP Notification")
                ->message("Hello, This is a boilerphp notication");
    }

}