<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->hears('{message}', function($botman, $message) {

            if ($message == 'cześć') {
                $this->askItem($botman);
            } else {
                $botman->reply("Napisz 'cześć', aby rozpocząć rozmowę...");
            }
        });

        $botman->listen();
    }

    /**
     * Ask for the item the user wants to sell.
     */
    public function askItem($botman)
    {
        $botman->ask('Cześć! Jaki przedmiot chcesz sprzedać?', function(Answer $answer) use ($botman) {
            $item = $answer->getText();

            $botman->say('Chcesz sprzedać: ' . $item);
            $this->askPrice($botman, $item);
        });
    }

    /**
     * Ask for the price of the item.
     */
    public function askPrice($botman, $item)
    {
        $botman->ask('Jaka jest cena za ' . $item . '?', function(Answer $answer) use ($botman, $item) {
            $price = $answer->getText();

            $botman->say('Cena za ' . $item . ' to ' . $price . ' zł.');
            $this->askLocation($botman, $item, $price);
        });
    }

    /**
     * Ask for the location of the item.
     */
    public function askLocation($botman, $item, $price)
    {
        $botman->ask('Gdzie znajduje się ' . $item . '? Podaj lokalizację.', function(Answer $answer) use ($botman, $item, $price) {
            $location = $answer->getText();

            $botman->say($item . ' znajduje się w ' . $location . '.');
            $this->askContact($botman, $item, $price, $location);
        });
    }

    /**
     * Ask for the contact details of the user.
     */
    public function askContact($botman, $item, $price, $location)
    {
        $botman->ask('Jak możemy się z Tobą skontaktować? Podaj numer telefonu lub adres e-mail.', function(Answer $answer) use ($botman, $item, $price, $location) {
            $contact = $answer->getText();

            $botman->say('Dziękujemy! Twoje dane kontaktowe: ' . $contact);
            $this->summary($botman, $item, $price, $location, $contact);
        });
    }

    /**
     * Provide a summary of the details collected.
     */
    public function summary($botman, $item, $price, $location, $contact)
    {
        $botman->say('Oto podsumowanie:');
        $botman->say('Przedmiot: ' . $item);
        $botman->say('Cena: ' . $price . ' zł');
        $botman->say('Lokalizacja: ' . $location);
        $botman->say('Kontakt: ' . $contact);
        $botman->say('Dziękujemy za skorzystanie z naszej platformy!');
    }
}
