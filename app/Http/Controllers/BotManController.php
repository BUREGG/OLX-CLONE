<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('start', function (BotMan $bot) {
            $bot->startConversation(new OrderConversation());
        });

        $botman->listen();
    }
}

class OrderConversation extends Conversation
{
    public function run()
    {
        $this->askCategory();
    }

    public function askCategory()
    {
        $question = Question::create("Witaj! W jakiej kategorii szukasz produktu?")
            ->addButtons([
                Button::create('Motoryzacja')->value('motoryzacja'),
                Button::create('Elektronika')->value('elektronika'),
                Button::create('Moda')->value('moda'),
                Button::create('Dom i Ogród')->value('dom_i_ogrod'),
                // Dodaj inne kategorie, które chcesz uwzględnić
            ]);
    
        $this->ask($question, function ($answer) {
            $category = $answer->getValue();
    
            switch ($category) {
                case 'motoryzacja':
                    $this->say("Szukasz w kategorii Motoryzacja.");
                    $this->askBrand();
                    break;
                case 'elektronika':
                    $this->say("Szukasz w kategorii Elektronika.");
                    $this->askCondition();
                    break;
                case 'moda':
                    $this->say("Szukasz w kategorii Moda.");
                    $this->askSize();
                    break;
                case 'dom_i_ogrod':
                    $this->say("Szukasz w kategorii Dom i Ogród.");
                    $this->askLocation();
                    break;
                default:
                    $this->say("Nie rozumiem tej kategorii. Spróbuj ponownie.");
                    $this->askCategory();
                    break;
            }
        });
    }
    
    public function askBrand()
    {
        $question = Question::create("Czy masz jakąś preferencję co do marki?")
            ->addButtons([
                Button::create('Tak')->value('tak'),
                Button::create('Nie')->value('nie'),
            ]);
    
        $this->ask($question, function ($answer) {
            $response = $answer->getValue();
    
            if ($response === 'tak') {
                $question = Question::create("Jaką markę preferujesz ?")
                ->addButtons([
                    Button::create('Audi')->value('audi'),
                    Button::create('BMW')->value('bmw'),
                    Button::create('Mazda')->value('mazda'),
                    Button::create('Nissan')->value('nissan'),            
                ]);
                $this->ask($question, function ($answer) {
                    $category = $answer->getValue();
            
                    switch ($category) {
                        case 'audi':
                            $this->say("Preferujesz markę audi");
                            break;
                        case 'bmw':
                            $this->say("Preferujesz markę bmw");
                            break;
                        case 'mazda':
                            $this->say("Preferujesz markę mazda");
                            break;
                        case 'nissan':
                            $this->say("Preferujesz markę nissan");
                            break;
                        default:
                            $this->say("Nie rozumiem tej kategorii. Spróbuj ponownie.");
                            $this->askCategory();
                            break;
                        }
                    });
                }else {
                $this->say("Nie masz preferencji co do marki.");
                // Tutaj możesz kontynuować konwersację, pytając użytkownika o inne cechy produktu
            }
        });
    }
    
    public function askCondition()
    {
        $question = Question::create("Czy preferujesz nowy czy używany produkt?")
            ->addButtons([
                Button::create('Nowy')->value('nowy'),
                Button::create('Używany')->value('uzywany'),
            ]);
    
        $this->ask($question, function ($answer) {
            $condition = $answer->getValue();
    
            if ($condition === 'nowy') {
                $this->say("Szukasz nowego produktu.");
                // Tutaj możesz kontynuować konwersację, pytając użytkownika o inne cechy nowego produktu
            } else {
                $this->say("Szukasz używanego produktu.");
                // Tutaj możesz kontynuować konwersację, pytając użytkownika o inne cechy używanego produktu
            }
        });
    }
    
    public function askSize()
    {
        $question = Question::create("Jaki rozmiar cię interesuje?")
            ->addButtons([
                Button::create('XS')->value('xs'),
                Button::create('S')->value('s'),
                Button::create('M')->value('m'),
                Button::create('L')->value('l'),
                Button::create('XL')->value('xl'),
                // Dodaj inne rozmiary, które są odpowiednie dla kategorii Moda
            ]);
    
        $this->ask($question, function ($answer) {
            $size = $answer->getValue();
            $this->say("Interesuje cię rozmiar $size.");
            // Tutaj możesz kontynuować konwersację, pytając użytkownika o inne cechy produktu
        });
    }
    
    public function askLocation()
    {
        $question = Question::create("W jakiej lokalizacji szukasz produktu?")
            ->addButtons([
                Button::create('Warszawa')->value('warszawa'),
                Button::create('Kraków')->value('krakow'),
                Button::create('Poznań')->value('poznan'),
                // Dodaj inne lokalizacje, które są odpowiednie dla kategorii Dom i Ogród
            ]);
    
        $this->ask($question, function ($answer) {
            $location = $answer->getValue();
            $this->say("Szukasz w lokalizacji $location.");
            // Tutaj możesz kontynuować konwersację, pytając użytkownika o inne cechy produktu
        });
    }
}