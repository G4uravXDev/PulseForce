<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $modules = [
            ['slug' => 'training-programs', 'icon' => '🏋️', 'num' => '01', 'name' => 'Training Programs', 'desc' => 'Explore expertly crafted workout routines. Whether building strength or endurance, find a program that fits your goals.'],
            ['slug' => 'diet-plans', 'icon' => '🥗', 'num' => '02', 'name' => 'Custom Diet Plans', 'desc' => 'Fuel your workouts with personalized nutrition. Access meal plans designed to complement your fitness journey.'],
            ['slug' => 'merchandise', 'icon' => '👕', 'num' => '03', 'name' => 'Premium Merchandise', 'desc' => 'Shop exclusive gym apparel and high-quality supplements directly from our built-in digital storefront.'],
        ];

        $techStack = [
            'Strength Training', 'Cardio Conditioning', 'Custom Meal Plans', 'Macro Tracking', 'Premium Supplements',
            'Performance Apparel', '1-on-1 Coaching', 'Group Classes', 'Recovery Protocols', 'Goal Setting',
        ];

        $marqueeItems = [
            'Premium Performance', 'Intelligent Scheduling', 'Role-Based Access Control', 'Manager Dashboard',
            'Customer Portal', 'Automated Reminders', 'Fee Management',
            'Progress Tracking', 'Merchandise Store',
        ];

        return view('landing', compact('modules', 'techStack', 'marqueeItems'));
    }

    public function trainingPrograms() { return view('features.training-programs'); }
    public function dietPlans() { return view('features.diet-plans'); }
    public function merchandise() { return view('features.merchandise'); }
    public function progressTracking() { return view('features.progress-tracking'); }
    public function classScheduling() { return view('features.class-scheduling'); }
    public function memberships() { return view('features.memberships'); }
}
