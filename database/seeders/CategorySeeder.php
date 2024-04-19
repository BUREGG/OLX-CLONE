<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Categories with their Subcategories
        $categories = [
            'Motoryzacja' => [
                'Samochody osobowe',
                'Części samochodowe',
                'Motocykle i skutery',
                'Dostawcze i ciężarowe',
                'Przyczepy i Pojazdy użytkowe',
                'Jachty i łodzie',
                'Pojazdy elektryczne',
            ],
            'Dom i Ogród' => [
                'Meble',
                'Ogród',
                'Wyposażenie',
                'Budowa i akcesoria',
                'Środki czystości',
                'Ogrzewanie',
            ],
            'Elektronika' => [
                'Telefony i akcesoria',
                'Komputery i tablety',
                'Sprzęt audio i video',
                'Fotografia',
                'Gry i konsole',
                'Sprzęt AGD',
                'Kamery',
            ],
            'Moda' => [
                'Odzież damska',
                'Odzież męska',
                'Obuwie',
                'Dodatki',
                'Biżuteria',
                'Zegarki',
            ],
            'Rolnictwo' => [
                'Maszyny rolnicze',
                'Części do maszyn rolniczych',
                'Ciagniki',
                'Opryskiwacze',
                'Nawozy',
                'Siewniki',
                'Pompy i hydrofory',
            ],
            'Sport i Hobby' => [
                'Sporty zimowe',
                'Sporty wodne',
                'Rowery',
                'Fitness',
                'Wędkarstwo',
                'Myślistwo',
                'Kolarstwo',
            ],
            'Muzyka i Edukacja' => [
                'Instrumenty muzyczne',
                'Sprzęt estradowy',
                'Płyty',
                'Książki',
                'Edukacja',
                'Nuty',
                'Podręczniki',
            ],
            'Zwierzęta' => [
                'Psy',
                'Koty',
                'Rybki',
                'Ptaki',
                'Gryzonie',
                'Reptilia',
                'Akwarystyka',
            ],
            'Dla Dzieci' => [
                'Zabawki',
                'Odzież dziecięca',
                'Foteliki samochodowe',
                'Wózki dziecięce',
                'Łóżeczka',
                'Akcesoria dla niemowląt',
                'Karmniki',
            ],
            'Praca' => [
                'Oferty pracy',
                'Usługi',
                'Budowa',
                'Opieka',
                'Finanse',
                'Edukacja',
                'IT',
            ],
            'Nieruchomości' => [
                'Mieszkania',
                'Domy',
                'Działki',
                'Garaże',
                'Biura i lokale',
                'Inne nieruchomości',
                'Wakacje i turystyka',
            ],
            'Usługi i Firmy' => [
                'Finanse i księgowość',
                'Prawo i usługi prawne',
                'Reklama i marketing',
                'Budownictwo i remonty',
                'Transport i przeprowadzki',
                'Usługi dla firm',
                'Informatyka i telekomunikacja',
            ],
        ];

        foreach ($categories as $mainCategory => $subCategories) {
            $mainCategoryModel = Category::create([
                'name' => $mainCategory,
                'parent_id' => null, // Assuming 0 represents the root category
            ]);

            foreach ($subCategories as $subCategory) {
                Category::create([
                    'name' => $subCategory,
                    'parent_id' => $mainCategoryModel->id,
                ]);
            }
        }
    }
}
