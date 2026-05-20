<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $products = $this->getProducts();
        if ($category !== 'all') {
            $products = array_filter($products, fn($p) => $p['category'] === $category);
        }
        $products = array_values($products);
        return view('features.merchandise', compact('category', 'products'));
    }

    private function getProducts()
    {
        return [
            // ── APPAREL ──
            ['name'=>'PulseForce Compression Tee','category'=>'apparel','badge'=>'Bestseller',
             'desc'=>'Moisture-wicking performance fabric with reflective PulseForce logo. Ideal for high-intensity training.',
             'price'=>'₹1,499','original'=>'₹1,999','sizes'=>['S','M','L','XL'],
             'rating'=>4.8,'reviews'=>124,'img'=>'https://images.unsplash.com/photo-1682731500074-0a45a3408fc5?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fENvbXByZXNzaW9uJTIwVGVlfGVufDB8fDB8fHww'],
            ['name'=>'DryFit Training Tank','category'=>'apparel','badge'=>'New',
             'desc'=>'Ultralight sleeveless tank with mesh ventilation panels. Stays cool during the heaviest lifts.',
             'price'=>'₹999','original'=>'₹1,299','sizes'=>['S','M','L','XL','XXL'],
             'rating'=>4.6,'reviews'=>87,'img'=>'https://images.unsplash.com/photo-1765045768265-e3eb8471fce3?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8VHJhaW5pbmclMjBUYW5rfGVufDB8fDB8fHww'],
            ['name'=>'FlexFit Training Shorts','category'=>'apparel','badge'=>'',
             'desc'=>'4-way stretch shorts with zippered pocket. Built for squats, lunges, and everything in between.',
             'price'=>'₹1,299','original'=>'','sizes'=>['S','M','L','XL'],
             'rating'=>4.7,'reviews'=>156,'img'=>'https://media.istockphoto.com/id/698897772/photo/unrecognizable-afro-american-man-in-park-stretching-legs.webp?a=1&b=1&s=612x612&w=0&k=20&c=rPqlUiZBGOb7Lkp8aNhSntUIvfZCunq_Lh3TMtW9zNM='],
            ['name'=>'PulseForce Hoodie — Charcoal','category'=>'apparel','badge'=>'Limited',
             'desc'=>'Heavyweight French terry hoodie with embroidered logo. Perfect for post-workout or casual wear.',
             'price'=>'₹2,499','original'=>'₹2,999','sizes'=>['M','L','XL'],
             'rating'=>4.9,'reviews'=>203,'img'=>'https://images.unsplash.com/photo-1715229437397-4811ab7d902d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjN8fEhvb2RpZSUyMENoYXJjb2FsfGVufDB8fDB8fHww'],
            ['name'=>'Women\'s Seamless Leggings','category'=>'apparel','badge'=>'Trending',
             'desc'=>'High-waisted squat-proof leggings with contouring seams. Available in 4 colors.',
             'price'=>'₹1,799','original'=>'₹2,199','sizes'=>['XS','S','M','L'],
             'rating'=>4.8,'reviews'=>312,'img'=>'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=600&q=80&auto=format&fit=crop'],
            ['name'=>'Training Joggers — Slim Fit','category'=>'apparel','badge'=>'',
             'desc'=>'Tapered joggers with deep pockets and adjustable waistband. Gym-to-street versatility.',
             'price'=>'₹1,699','original'=>'','sizes'=>['S','M','L','XL'],
             'rating'=>4.5,'reviews'=>98,'img'=>'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=600&q=80&auto=format&fit=crop'],

            // ── SUPPLEMENTS ──
            ['name'=>'Whey Protein Isolate — 2kg','category'=>'supplement','badge'=>'Bestseller',
             'desc'=>'28g protein per scoop, low lactose, fast-absorbing. Available in Chocolate, Vanilla, and Mango.',
             'price'=>'₹3,499','original'=>'₹4,299','sizes'=>[],
             'rating'=>4.9,'reviews'=>540,'img'=>'https://images.unsplash.com/photo-1579722821273-0f6c7d44362f?w=600&q=80&auto=format&fit=crop'],
            ['name'=>'Pre-Workout Surge — 30 Servings','category'=>'supplement','badge'=>'',
             'desc'=>'200mg caffeine, beta-alanine, citrulline malate. Maximum focus and energy for intense sessions.',
             'price'=>'₹1,999','original'=>'₹2,499','sizes'=>[],
             'rating'=>4.6,'reviews'=>215,'img'=>'https://images.unsplash.com/photo-1704650311981-419f841421cc?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8UHJlLVdvcmtvdXQlMjBTdXJnZXxlbnwwfHwwfHx8MA%3D%3D'],
            ['name'=>'BCAA Recovery Powder','category'=>'supplement','badge'=>'New',
             'desc'=>'2:1:1 BCAA ratio with added electrolytes. Speeds up recovery and reduces muscle soreness.',
             'price'=>'₹1,299','original'=>'₹1,599','sizes'=>[],
             'rating'=>4.5,'reviews'=>178,'img'=>'https://images.unsplash.com/photo-1709976142774-ce1ef41a8378?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8QkNBQSUyMFJlY292ZXJ5JTIwUG93ZGVyfGVufDB8fDB8fHww'],
            ['name'=>'Creatine Monohydrate — 300g','category'=>'supplement','badge'=>'',
             'desc'=>'Pure micronized creatine. 5g daily for increased strength, power, and muscle volume.',
             'price'=>'₹899','original'=>'','sizes'=>[],
             'rating'=>4.8,'reviews'=>430,'img'=>'https://images.unsplash.com/photo-1724160167780-1aef4db75030?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fENyZWF0aW5lJTIwTW9ub2h5ZHJhdGV8ZW58MHx8MHx8fDA%3D'],

            // ── ACCESSORIES ──
            ['name'=>'PulseForce Gym Bag — 40L','category'=>'accessory','badge'=>'',
             'desc'=>'Water-resistant duffle with shoe compartment, wet pocket, and padded shoulder strap.',
             'price'=>'₹2,199','original'=>'₹2,699','sizes'=>[],
             'rating'=>4.7,'reviews'=>89,'img'=>'https://images.unsplash.com/photo-1715761195783-64f70b4608ad?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8R3ltJTIwQmFnfGVufDB8fDB8fHww'],
            ['name'=>'Lifting Belt — Leather','category'=>'accessory','badge'=>'Pro',
             'desc'=>'10mm genuine leather belt with double-prong buckle. Essential for heavy squats and deadlifts.',
             'price'=>'₹2,999','original'=>'₹3,499','sizes'=>['S','M','L','XL'],
             'rating'=>4.9,'reviews'=>267,'img'=>'https://images.unsplash.com/photo-1589819452224-bb076f42f65f?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8d2VpZ2h0bGlmdGluZyUyMGJlbHR8ZW58MHx8MHx8fDA%3D'],
            ['name'=>'Wrist Wraps — Heavy Duty','category'=>'accessory','badge'=>'',
             'desc'=>'18-inch wrist wraps with thumb loop. Superior wrist support for pressing movements.',
             'price'=>'₹599','original'=>'₹799','sizes'=>[],
             'rating'=>4.6,'reviews'=>345,'img'=>'https://images.unsplash.com/photo-1582852567809-a25c21a13ee6?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8V3Jpc3QlMjBXcmFwc3xlbnwwfHwwfHx8MA%3D%3D'],
            ['name'=>'Shaker Bottle — 700ml','category'=>'accessory','badge'=>'',
             'desc'=>'BPA-free shaker with wire whisk ball and measurement markings. Leak-proof lid.',
             'price'=>'₹399','original'=>'₹599','sizes'=>[],
             'rating'=>4.4,'reviews'=>520,'img'=>'https://images.unsplash.com/photo-1678875526436-fa7137a01413?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fFNoYWtlciUyMEJvdHRsZXxlbnwwfHwwfHx8MA%3D%3D'],
            ['name'=>'Resistance Bands Set — 5 Pack','category'=>'accessory','badge'=>'Bestseller',
             'desc'=>'5 resistance levels from light to extra-heavy. Perfect for warm-ups, rehab, and home training.',
             'price'=>'₹1,299','original'=>'₹1,799','sizes'=>[],
             'rating'=>4.7,'reviews'=>188,'img'=>'https://images.unsplash.com/photo-1598289431512-b97b0917affc?w=600&q=80&auto=format&fit=crop'],
        ];
    }
}
