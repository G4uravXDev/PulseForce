<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DietPlanController extends Controller
{
    public function index(Request $request)
    {
        $goal = $request->get('goal', 'bulk');
        $type = $request->get('type', 'nonveg');

        // If member is logged in, check for assigned diet and default to it
        $activeAssignment = null;
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isCustomer()) {
            $activeAssignment = \App\Models\DietAssignment::where('user_id', (string) \Illuminate\Support\Facades\Auth::user()->_id)
                ->where('status', 'active')->first();
            if ($activeAssignment && !$request->has('goal') && !$request->has('type')) {
                $goal = $activeAssignment->goal;
                $type = $activeAssignment->type;
            }
        }

        $plans = $this->getPlans();
        $current = $plans[$goal][$type] ?? $plans['bulk']['nonveg'];

        return view('features.diet-plans', compact('goal', 'type', 'current', 'activeAssignment'));
    }

    private function getPlans()
    {
        return $this->buildPlans();
    }

    /**
     * Public accessor for plan data (used by DashboardController).
     */
    public function getAllPlans()
    {
        return $this->buildPlans();
    }

    private function buildPlans()
    {
        return [
            'bulk' => [
                'veg' => [
                    'label' => 'Bulk — Vegetarian', 'calories' => 3200, 'protein' => '140g', 'carbs' => '420g', 'fat' => '95g',
                    'meals' => [
                        ['slot' => 'Breakfast', 'icon' => '', 'time' => '7:00 AM', 'items' => [
                            ['name' => 'Paneer Paratha (3 pcs)', 'desc' => 'Whole wheat parathas stuffed with spiced paneer, served with curd', 'p' => '28g', 'c' => '85g', 'f' => '22g'],
                            ['name' => 'Banana Peanut Butter Shake', 'desc' => '2 bananas, 2 tbsp peanut butter, 300ml whole milk, oats', 'p' => '18g', 'c' => '65g', 'f' => '16g'],
                        ]],
                        ['slot' => 'Lunch', 'icon' => '', 'time' => '1:00 PM', 'items' => [
                            ['name' => 'Rajma Chawal (Brown Rice)', 'desc' => 'Kidney bean curry with 2 cups brown rice and mixed salad', 'p' => '22g', 'c' => '95g', 'f' => '8g'],
                            ['name' => 'Palak Paneer + Roti (3)', 'desc' => 'Spinach paneer curry with whole wheat rotis and raita', 'p' => '26g', 'c' => '70g', 'f' => '18g'],
                        ]],
                        ['slot' => 'Snack', 'icon' => '', 'time' => '5:00 PM', 'items' => [
                            ['name' => 'Trail Mix & Fruit Bowl', 'desc' => 'Almonds, walnuts, dried figs, dates with seasonal fruits', 'p' => '12g', 'c' => '45g', 'f' => '18g'],
                            ['name' => 'Whey Protein Smoothie', 'desc' => 'Whey protein, mango, yogurt, honey blend', 'p' => '30g', 'c' => '35g', 'f' => '5g'],
                        ]],
                        ['slot' => 'Dinner', 'icon' => '', 'time' => '8:30 PM', 'items' => [
                            ['name' => 'Chole with Rice & Salad', 'desc' => 'Chickpea curry, basmati rice, cucumber-tomato salad', 'p' => '20g', 'c' => '80g', 'f' => '10g'],
                            ['name' => 'Paneer Bhurji + Multigrain Roti', 'desc' => 'Scrambled paneer with veggies, 2 multigrain rotis', 'p' => '24g', 'c' => '50g', 'f' => '14g'],
                        ]],
                    ],
                ],
                'nonveg' => [
                    'label' => 'Bulk — Non-Vegetarian', 'calories' => 3500, 'protein' => '200g', 'carbs' => '400g', 'fat' => '105g',
                    'meals' => [
                        ['slot' => 'Breakfast', 'icon' => '', 'time' => '7:00 AM', 'items' => [
                            ['name' => 'Egg Omelette (5 eggs) + Toast', 'desc' => '5-egg omelette with cheese, peppers, 3 whole wheat toasts with butter', 'p' => '38g', 'c' => '60g', 'f' => '28g'],
                            ['name' => 'Chicken Keema Paratha (2)', 'desc' => 'Stuffed parathas with minced chicken, served with green chutney', 'p' => '32g', 'c' => '70g', 'f' => '20g'],
                        ]],
                        ['slot' => 'Lunch', 'icon' => '', 'time' => '1:00 PM', 'items' => [
                            ['name' => 'Grilled Chicken Breast (250g)', 'desc' => 'Herb-seasoned chicken with brown rice and steamed broccoli', 'p' => '55g', 'c' => '80g', 'f' => '12g'],
                            ['name' => 'Fish Curry + Rice', 'desc' => 'Rohu fish curry with basmati rice and dal on the side', 'p' => '35g', 'c' => '85g', 'f' => '14g'],
                        ]],
                        ['slot' => 'Snack', 'icon' => '', 'time' => '5:00 PM', 'items' => [
                            ['name' => 'Boiled Eggs (4) + Nuts', 'desc' => '4 boiled eggs with a handful of almonds and walnuts', 'p' => '30g', 'c' => '10g', 'f' => '22g'],
                            ['name' => 'Whey Protein + Banana', 'desc' => 'Double scoop whey shake with banana and peanut butter', 'p' => '42g', 'c' => '40g', 'f' => '12g'],
                        ]],
                        ['slot' => 'Dinner', 'icon' => '', 'time' => '8:30 PM', 'items' => [
                            ['name' => 'Butter Chicken + Naan (2)', 'desc' => 'Rich butter chicken gravy with 2 garlic naans', 'p' => '40g', 'c' => '65g', 'f' => '24g'],
                            ['name' => 'Mutton Biryani (Hyderabadi)', 'desc' => 'Slow-cooked mutton biryani with raita and boiled egg', 'p' => '38g', 'c' => '90g', 'f' => '20g'],
                        ]],
                    ],
                ],
                'vegan' => [
                    'label' => 'Bulk — Vegan', 'calories' => 3100, 'protein' => '120g', 'carbs' => '440g', 'fat' => '90g',
                    'meals' => [
                        ['slot' => 'Breakfast', 'icon' => '', 'time' => '7:00 AM', 'items' => [
                            ['name' => 'Tofu Scramble + Avocado Toast', 'desc' => 'Spiced tofu scramble with 2 slices avocado sourdough toast', 'p' => '22g', 'c' => '55g', 'f' => '20g'],
                            ['name' => 'Overnight Oats Bowl', 'desc' => 'Oats soaked in almond milk with chia, berries, maple syrup', 'p' => '14g', 'c' => '75g', 'f' => '12g'],
                        ]],
                        ['slot' => 'Lunch', 'icon' => '', 'time' => '1:00 PM', 'items' => [
                            ['name' => 'Chickpea Buddha Bowl', 'desc' => 'Roasted chickpeas, quinoa, sweet potato, tahini dressing', 'p' => '24g', 'c' => '95g', 'f' => '16g'],
                            ['name' => 'Soy Chunk Pulao', 'desc' => 'Soy granules cooked with basmati rice, peas, and spices', 'p' => '28g', 'c' => '85g', 'f' => '8g'],
                        ]],
                        ['slot' => 'Snack', 'icon' => '', 'time' => '5:00 PM', 'items' => [
                            ['name' => 'Peanut Butter Energy Balls (4)', 'desc' => 'Rolled oats, peanut butter, dark chocolate chips, flax seeds', 'p' => '16g', 'c' => '40g', 'f' => '18g'],
                            ['name' => 'Plant Protein Shake', 'desc' => 'Pea protein powder, soy milk, banana, spinach', 'p' => '32g', 'c' => '35g', 'f' => '6g'],
                        ]],
                        ['slot' => 'Dinner', 'icon' => '', 'time' => '8:30 PM', 'items' => [
                            ['name' => 'Dal Makhani (Vegan) + Roti', 'desc' => 'Creamy black lentils made with coconut cream, 3 rotis', 'p' => '22g', 'c' => '80g', 'f' => '14g'],
                            ['name' => 'Mushroom & Tofu Stir Fry', 'desc' => 'Mixed mushrooms and tofu with jasmine rice and soy sauce', 'p' => '20g', 'c' => '70g', 'f' => '12g'],
                        ]],
                    ],
                ],
            ],
            'slim' => [
                'veg' => [
                    'label' => 'Slim — Vegetarian', 'calories' => 1800, 'protein' => '90g', 'carbs' => '200g', 'fat' => '60g',
                    'meals' => [
                        ['slot' => 'Breakfast', 'icon' => '', 'time' => '7:30 AM', 'items' => [
                            ['name' => 'Moong Dal Chilla (2)', 'desc' => 'Thin lentil crepes with mint chutney and sliced cucumber', 'p' => '16g', 'c' => '30g', 'f' => '4g'],
                            ['name' => 'Greek Yogurt Parfait', 'desc' => 'Low-fat yogurt, granola, mixed berries, honey drizzle', 'p' => '14g', 'c' => '35g', 'f' => '6g'],
                        ]],
                        ['slot' => 'Lunch', 'icon' => '', 'time' => '12:30 PM', 'items' => [
                            ['name' => 'Mixed Vegetable Salad Bowl', 'desc' => 'Grilled paneer cubes, quinoa, chickpeas, greens, lemon dressing', 'p' => '22g', 'c' => '40g', 'f' => '12g'],
                            ['name' => 'Roti (1) + Lauki Sabzi', 'desc' => 'Single roti with bottle gourd curry and cucumber raita', 'p' => '8g', 'c' => '35g', 'f' => '6g'],
                        ]],
                        ['slot' => 'Snack', 'icon' => '', 'time' => '4:30 PM', 'items' => [
                            ['name' => 'Roasted Makhana (Fox Nuts)', 'desc' => 'Dry-roasted makhana with a pinch of black salt and turmeric', 'p' => '4g', 'c' => '20g', 'f' => '2g'],
                            ['name' => 'Green Tea + Apple', 'desc' => 'Unsweetened green tea with a medium-sized apple', 'p' => '1g', 'c' => '25g', 'f' => '0g'],
                        ]],
                        ['slot' => 'Dinner', 'icon' => '', 'time' => '7:30 PM', 'items' => [
                            ['name' => 'Clear Vegetable Soup + Salad', 'desc' => 'Light broth with seasonal vegetables and a side green salad', 'p' => '6g', 'c' => '18g', 'f' => '3g'],
                            ['name' => 'Grilled Paneer Tikka (6 pcs)', 'desc' => 'Tandoori-style paneer with bell peppers and onions', 'p' => '24g', 'c' => '12g', 'f' => '14g'],
                        ]],
                    ],
                ],
                'nonveg' => [
                    'label' => 'Slim — Non-Vegetarian', 'calories' => 2000, 'protein' => '150g', 'carbs' => '180g', 'fat' => '55g',
                    'meals' => [
                        ['slot' => 'Breakfast', 'icon' => '', 'time' => '7:30 AM', 'items' => [
                            ['name' => 'Egg White Omelette (5 whites)', 'desc' => '5 egg whites with spinach, tomato, and mushroom', 'p' => '25g', 'c' => '5g', 'f' => '2g'],
                            ['name' => 'Whole Wheat Toast + Avocado', 'desc' => '1 toast with mashed avocado and a boiled egg', 'p' => '10g', 'c' => '25g', 'f' => '12g'],
                        ]],
                        ['slot' => 'Lunch', 'icon' => '', 'time' => '12:30 PM', 'items' => [
                            ['name' => 'Grilled Chicken Salad (200g)', 'desc' => 'Chicken breast strips on mixed greens, olive oil dressing', 'p' => '45g', 'c' => '15g', 'f' => '10g'],
                            ['name' => 'Tandoori Fish + Brown Rice', 'desc' => 'Grilled fish tikka with half cup brown rice and steamed veggies', 'p' => '35g', 'c' => '40g', 'f' => '8g'],
                        ]],
                        ['slot' => 'Snack', 'icon' => '', 'time' => '4:30 PM', 'items' => [
                            ['name' => 'Boiled Eggs (2) + Cucumber', 'desc' => '2 boiled eggs with sliced cucumber and black pepper', 'p' => '14g', 'c' => '4g', 'f' => '10g'],
                            ['name' => 'Protein Bar (Low Sugar)', 'desc' => 'A 20g protein bar with less than 5g sugar', 'p' => '20g', 'c' => '18g', 'f' => '7g'],
                        ]],
                        ['slot' => 'Dinner', 'icon' => '', 'time' => '7:30 PM', 'items' => [
                            ['name' => 'Chicken Soup (Clear Broth)', 'desc' => 'Light chicken broth with shredded chicken, carrots, celery', 'p' => '22g', 'c' => '12g', 'f' => '4g'],
                            ['name' => 'Grilled Prawns + Veggies', 'desc' => 'Lemon-herb prawns with grilled zucchini and bell peppers', 'p' => '28g', 'c' => '10g', 'f' => '6g'],
                        ]],
                    ],
                ],
                'vegan' => [
                    'label' => 'Slim — Vegan', 'calories' => 1700, 'protein' => '80g', 'carbs' => '220g', 'fat' => '50g',
                    'meals' => [
                        ['slot' => 'Breakfast', 'icon' => '', 'time' => '7:30 AM', 'items' => [
                            ['name' => 'Smoothie Bowl', 'desc' => 'Frozen acai, banana, almond milk, topped with granola and seeds', 'p' => '10g', 'c' => '55g', 'f' => '8g'],
                            ['name' => 'Sprouts Salad', 'desc' => 'Mixed sprouts with lemon, onion, tomato, and chaat masala', 'p' => '12g', 'c' => '25g', 'f' => '2g'],
                        ]],
                        ['slot' => 'Lunch', 'icon' => '', 'time' => '12:30 PM', 'items' => [
                            ['name' => 'Quinoa Tabbouleh Bowl', 'desc' => 'Quinoa with parsley, tomato, cucumber, lemon-olive oil dressing', 'p' => '12g', 'c' => '45g', 'f' => '10g'],
                            ['name' => 'Lentil Soup + Multigrain Roti', 'desc' => 'Yellow dal soup with 1 roti and a side of raw veggies', 'p' => '14g', 'c' => '40g', 'f' => '6g'],
                        ]],
                        ['slot' => 'Snack', 'icon' => '', 'time' => '4:30 PM', 'items' => [
                            ['name' => 'Hummus + Veggie Sticks', 'desc' => 'Classic hummus with carrot, celery, and bell pepper sticks', 'p' => '8g', 'c' => '20g', 'f' => '8g'],
                            ['name' => 'Herbal Tea + Mixed Seeds', 'desc' => 'Chamomile tea with a small handful of pumpkin and sunflower seeds', 'p' => '6g', 'c' => '8g', 'f' => '10g'],
                        ]],
                        ['slot' => 'Dinner', 'icon' => '', 'time' => '7:30 PM', 'items' => [
                            ['name' => 'Stir-Fried Tofu (150g)', 'desc' => 'Tofu cubes with broccoli, snap peas, soy-ginger sauce', 'p' => '18g', 'c' => '15g', 'f' => '10g'],
                            ['name' => 'Mixed Bean Salad', 'desc' => 'Kidney beans, black beans, corn, cilantro, lime dressing', 'p' => '14g', 'c' => '30g', 'f' => '4g'],
                        ]],
                    ],
                ],
            ],
        ];
    }
}
