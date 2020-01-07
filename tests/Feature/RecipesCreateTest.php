<?php

namespace Tests\Feature;

use App\User;
use App\Recipe;
use App\Food;
use App\Ingredient;
use App\PreparationImage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipesCreateTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function a_user_can_post_a_recipe()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $this->prepareFoods();

        $response = $this->post('/api/recipes', [
            'data' => [
                'type' => 'recipes',
                'attributes' => [
                    'title' => 'Torta salata di verdure',
                    'presentation' => [
                        'description' => 'La torta salata di verdure è il piatto ideale da preparare per un pic-nic o un pranzo con gli amici.
                            La versione che vi proponiamo, oltre ad essere semplice e veloce, è anche molto gustosa perché fatta da un base di pasta sfoglia, una besciamella arricchita da uova e formaggio, verdurine croccanti tagliate a nastro e spennellate con olio di oliva extravergine.
                            La decorazione a cerchi concentrici rende la torta salata di verdure molto originale e di grande effetto!',
                        'photo' => 'https://www.giallozafferano.it/images/ricette/19/1903/foto_hd/hd450x300.jpg',
                    ],
                    'ingredients' => $this->getIngredientsForInput(),
                    'preparation' => [
                        'title' => 'Come preparare la torta salata di verdure',
                        'text' => 'Per preparare la torta salata di verdure, iniziate dalla besciamella: in un pentolino mettete a scaldare il latte con il pizzico di noce moscata 1 e lasciatelo sul fuoco fino a che non raggiungerà il bollore. Intanto in un altro pentolino preparate il roux di burro e farina: fate sciogliere il burro e aggiungete la farina setacciata e il sale 2. Mescolate per far addensare il roux 3
                            e versate il latte nel pentolino del roux 4, continuando a mescolare fino a che la besciamella non sarà addensata correttamente 5. Quando sarà pronta lasciatela raffreddare a temperatura ambiente e nel frattempo sbattete le uova e aggiungete il parmigiano 6.                       
                            Unite questo composto alla besciamella e amalgamate bene 7. Preparate ora la base della torta salata: stendete la pasta sfoglia con un mattarello seguendo la forma della vostra teglia; trasportatela nella teglia da 22 centimetri, e alta 5, precedentemente imburrata 8 e se è necessario tagliate i bordi in eccesso 9',
                        'images' => [
                            [
                                'url' => 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq1.jpg'
                            ],
                            [
                                'url' => 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq2.jpg'
                            ],
                            [
                                'url' => 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq3.jpg'
                            ],
                            [
                                'url' => 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq4.jpg'
                            ],
                            [
                                'url' => 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq5.jpg'
                            ],
                        ],
                    ],
                    'conservation' => 'Potete preparare la torta il giorno prima, riporla in frigo coperta da un foglio di pellicola e servirla il giorno dopo fredda o tiepida dopo una leggera scaldata in forno.'
                ]
            ]
        ]);

        $recipe = Recipe::first();
        $this->assertNotNull($recipe);
        $this->assertEquals($user->id, $recipe->idUser, "Una ricetta deve appartenere ad un utente");
        $this->assertEquals('Torta salata di verdure', $recipe->title, "Una ricetta deve avere un titolo");
        $this->assertNotEmpty($recipe->preparationText, "Una ricetta deve avere una procedura di preparazione");
        $this->assertNotEmpty($recipe->presentationDescription, "Questa ricetta ha dati di presentazione");
        $this->assertNotEmpty($recipe->presentationPhoto, "Questa ricetta ha dati di presentazione");
        $this->assertNotEmpty($recipe->preparationTitle, "Questa ricetta ha dati di preparazione");
        $this->assertNotEmpty($recipe->conservation, "Questa ricetta ha dati di conservazione");
        $this->assertEquals(5, $recipe->preparationImages()->count(), "Sono presenti immagini per la preparazione di questa ricetta");
        $this->assertEquals(12, $recipe->ingredients->count(), "Devono essere presenti ingredienti per la preparazione della ricetta");
               
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'recipes',
                    'id' => $recipe->id,
                    'attributes' => [
                        'presentation' => [
                            'description' => 'La torta salata di verdure è il piatto ideale da preparare per un pic-nic o un pranzo con gli amici.
                                La versione che vi proponiamo, oltre ad essere semplice e veloce, è anche molto gustosa perché fatta da un base di pasta sfoglia, una besciamella arricchita da uova e formaggio, verdurine croccanti tagliate a nastro e spennellate con olio di oliva extravergine.
                                La decorazione a cerchi concentrici rende la torta salata di verdure molto originale e di grande effetto!',
                            'photo' => 'https://www.giallozafferano.it/images/ricette/19/1903/foto_hd/hd450x300.jpg',
                        ],
                        'ingredients' => [
                            'data' => $this->getIngredients($recipe)
                        ],
                        'preparation' => [
                            'title' => 'Come preparare la torta salata di verdure',
                            'text' => 'Per preparare la torta salata di verdure, iniziate dalla besciamella: in un pentolino mettete a scaldare il latte con il pizzico di noce moscata 1 e lasciatelo sul fuoco fino a che non raggiungerà il bollore. Intanto in un altro pentolino preparate il roux di burro e farina: fate sciogliere il burro e aggiungete la farina setacciata e il sale 2. Mescolate per far addensare il roux 3
                                e versate il latte nel pentolino del roux 4, continuando a mescolare fino a che la besciamella non sarà addensata correttamente 5. Quando sarà pronta lasciatela raffreddare a temperatura ambiente e nel frattempo sbattete le uova e aggiungete il parmigiano 6.                       
                                Unite questo composto alla besciamella e amalgamate bene 7. Preparate ora la base della torta salata: stendete la pasta sfoglia con un mattarello seguendo la forma della vostra teglia; trasportatela nella teglia da 22 centimetri, e alta 5, precedentemente imburrata 8 e se è necessario tagliate i bordi in eccesso 9',
                            'images' => $this->getPreparationImages($recipe),
                        ],
                        'conservation' => 'Potete preparare la torta il giorno prima, riporla in frigo coperta da un foglio di pellicola e servirla il giorno dopo fredda o tiepida dopo una leggera scaldata in forno.'
                    ],
                    'links' => [
                        'self' => url('/recipes/' . $recipe->id)
                    ]
                ]
            ]);
    }

    private function prepareFoods()
    {
        factory(Food::class)->create(['name' => 'Pasta sfoglia']);
        factory(Food::class)->create(['name' => 'Carote']);
        factory(Food::class)->create(['name' => 'Olio extravergine d\'oliva']);
        factory(Food::class)->create(['name' => 'Zucchine']);
        factory(Food::class)->create(['name' => 'Sale fino']);
        factory(Food::class)->create(['name' => 'Latte intero']);
        factory(Food::class)->create(['name' => 'Burro']);
        factory(Food::class)->create(['name' => 'Parmigiano Reggiano DOP']);
        factory(Food::class)->create(['name' => 'Farina 00']);
        factory(Food::class)->create(['name' => 'Noce moscata']);
        factory(Food::class)->create(['name' => 'Uova']);
    }

    private function getFood($name)
    {
        return Food::where('name', $name)->first();
    }

    private function getIngredients($recipe)
    {
        return [
            $this->getIngredient(
                $recipe,
                'Pasta sfoglia', 
                'Ingredienti per una teglia da 22 cm', 
                '(1 rotolo)', 
                '230 g'
            ),
            $this->getIngredient(
                $recipe,
                'Carote',
                'Ingredienti per una teglia da 22 cm',
                null, 
                '350 g'
            ),
            $this->getIngredient(
                $recipe,
                'Olio extravergine d\'oliva',
                'Ingredienti per una teglia da 22 cm',
                null,
                '40 g'
            ),
            $this->getIngredient(
                $recipe,
                'Zucchine',
                'Ingredienti per una teglia da 22 cm',
                null,
                '350 g'
            ),
            $this->getIngredient(
                $recipe,
                'Sale fino',
                'Ingredienti per una teglia da 22 cm',
                null,
                'q.b.'
            ),
            $this->getIngredient(
                $recipe,
                'Latte intero',
                'Per la besciamella',
                null,
                '300 ml'
            ),
            $this->getIngredient(
                $recipe,
                'Burro',
                'Per la besciamella',
                null,
                '25 g'
            ),
            $this->getIngredient(
                $recipe,
                'Parmigiano Reggiano DOP',
                'Per la besciamella',
                '(da grattugiare)',
                '40 g'
            ),
            $this->getIngredient(
                $recipe,
                'Sale fino',
                'Per la besciamella',
                null,
                'q.b.'
            ),
            $this->getIngredient(
                $recipe,
                'Farina 00',
                'Per la besciamella',
                null,
                '25 g'
            ),
            $this->getIngredient(
                $recipe,
                'Noce moscata',
                'Per la besciamella',
                null,
                'q.b.'
            ),
            $this->getIngredient(
                $recipe,
                'Uova',
                'Per la besciamella',
                'medie',
                '2'
            ),
        ];
    }

    private function getIngredient($recipe, $name, $preparation, $notes, $quantity)
    {
        $food = $this->getFood($name);
        return [
            'data' => [
                'type' => 'ingredients',
                'attributes' => [
                    'idFood' => $food->id,
                    'preparation' => $preparation,
                    'name' => $name,
                    'notes' => $notes, 
                    'quantity' => $quantity,
                ],
            ],
            'link' => [
                'self' => url('/recipes/' . $recipe->id)
            ]
        ];
    }

    private function getIngredientsForInput()
    {
        return [
            $this->getIngredientForInput(
                'Pasta sfoglia', 
                'Ingredienti per una teglia da 22 cm', 
                '(1 rotolo)', 
                '230 g'
            ),
            $this->getIngredientForInput(
                'Carote',
                'Ingredienti per una teglia da 22 cm',
                null, 
                '350 g'
            ),
            $this->getIngredientForInput(
                'Olio extravergine d\'oliva',
                'Ingredienti per una teglia da 22 cm',
                null,
                '40 g'
            ),
            $this->getIngredientForInput(
                'Zucchine',
                'Ingredienti per una teglia da 22 cm',
                null,
                '350 g'
            ),
            $this->getIngredientForInput(
                'Sale fino',
                'Ingredienti per una teglia da 22 cm',
                null,
                'q.b.'
            ),
            $this->getIngredientForInput(
                'Latte intero',
                'Per la besciamella',
                null,
                '300 ml'
            ),
            $this->getIngredientForInput(
                'Burro',
                'Per la besciamella',
                null,
                '25 g'
            ),
            $this->getIngredientForInput(
                'Parmigiano Reggiano DOP',
                'Per la besciamella',
                '(da grattugiare)',
                '40 g'
            ),
            $this->getIngredientForInput(
                'Sale fino',
                'Per la besciamella',
                null,
                'q.b.'
            ),
            $this->getIngredientForInput(
                'Farina 00',
                'Per la besciamella',
                null,
                '25 g'
            ),
            $this->getIngredientForInput(
                'Noce moscata',
                'Per la besciamella',
                null,
                'q.b.'
            ),
            $this->getIngredientForInput(
                'Uova',
                'Per la besciamella',
                'medie',
                '2'
            ),
        ];
    }

    private function getIngredientForInput($name, $preparation, $notes, $quantity)
    {
        $food = $this->getFood($name);
        return [
            'idFood' => $food->id,
            'preparation' => $preparation,
            'name' => $name,
            'notes' => $notes, 
            'quantity' => $quantity,
        ];
    }

    private function getPreparationImages($recipe)
    {
        return [
            $this->getImage($recipe, 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq1.jpg'),
            $this->getImage($recipe, 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq2.jpg'),
            $this->getImage($recipe, 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq3.jpg'),
            $this->getImage($recipe, 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq4.jpg'),
            $this->getImage($recipe, 'https://ricette.giallozafferano.it/images/ricette/19/1903/Torta-salata-di-verdure_Seq5.jpg'),
        ];
    }

    private function getImage($recipe, $url)
    {
        return [
            'data' => [
                'type' => 'preparationImage',
                'attributes' => [
                    'url' => $url,
                ],
            ],
            'link' => [
                'self' => url('/recipes/' . $recipe->id)
            ]
        ];
    }
}
