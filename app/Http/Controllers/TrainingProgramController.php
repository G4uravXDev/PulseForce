<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class TrainingProgramController extends Controller
{
    public function index(Request $request)
    {
        $goal = $request->get('goal', 'bulk');
        $level = $request->get('level', 'beginner');

        // If member is logged in, check for assigned workout and default to it
        $activeAssignment = null;
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isCustomer()) {
            $activeAssignment = \App\Models\WorkoutAssignment::where('user_id', (string) \Illuminate\Support\Facades\Auth::user()->_id)
                ->where('status', 'active')->first();
            // If no goal/level in URL and member has assignment, default to their assigned program
            if ($activeAssignment && !$request->has('goal') && !$request->has('level')) {
                $goal = $activeAssignment->goal;
                $level = $activeAssignment->level;
            }
        }

        $plans = $this->getPlans();
        $current = $plans[$goal][$level] ?? $plans['bulk']['beginner'];
        return view('features.training-programs', compact('goal', 'level', 'current', 'activeAssignment'));
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
                'beginner' => $this->bulkBeginner(),
                'intermediate' => $this->bulkIntermediate(),
                'veteran' => $this->bulkVeteran(),
            ],
            'shredded' => [
                'beginner' => $this->shreddedBeginner(),
                'intermediate' => $this->shreddedIntermediate(),
                'veteran' => $this->shreddedVeteran(),
            ],
        ];
    }

    private function bulkBeginner() {
        return ['label'=>'Bulk — Beginner','weeks'=>8,'days_per_week'=>4,'rest_between'=>'90s','focus'=>'Strength Foundation',
        'days'=>[
            ['day'=>'Day 1','muscle'=>'Chest & Triceps','exercises'=>[
                ['name'=>'Flat Barbell Bench Press','target'=>'Chest','desc'=>'Lie flat, grip slightly wider than shoulders, lower to mid-chest','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Incline Dumbbell Press','target'=>'Upper Chest','desc'=>'30-degree incline, press dumbbells up with controlled motion','sets'=>'3','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Cable Flyes','target'=>'Inner Chest','desc'=>'Stand between cables, bring handles together in hugging motion','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
                ['name'=>'Tricep Rope Pushdown','target'=>'Triceps','desc'=>'Cable pushdown with rope attachment, squeeze at bottom','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 2','muscle'=>'Back & Biceps','exercises'=>[
                ['name'=>'Lat Pulldown','target'=>'Lats','desc'=>'Wide grip pulldown to upper chest, squeeze shoulder blades','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Seated Cable Row','target'=>'Mid Back','desc'=>'Pull handle to lower chest, keep back straight','sets'=>'3','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Dumbbell Rows','target'=>'Lats','desc'=>'One arm at a time on bench, pull to hip','sets'=>'3','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Barbell Bicep Curl','target'=>'Biceps','desc'=>'Standing curl with EZ bar, control the negative','sets'=>'3','reps'=>'10-12','rest'=>'60s'],
            ]],
            ['day'=>'Day 3','muscle'=>'Rest Day','rest'=>true],
            ['day'=>'Day 4','muscle'=>'Legs','exercises'=>[
                ['name'=>'Barbell Squat','target'=>'Quads/Glutes','desc'=>'Back squat with barbell, go parallel or below','sets'=>'4','reps'=>'8-10','rest'=>'120s'],
                ['name'=>'Leg Press','target'=>'Quads','desc'=>'45-degree leg press, full range of motion','sets'=>'3','reps'=>'10-12','rest'=>'90s'],
                ['name'=>'Romanian Deadlift','target'=>'Hamstrings','desc'=>'Hip hinge with barbell, feel stretch in hamstrings','sets'=>'3','reps'=>'10-12','rest'=>'90s'],
                ['name'=>'Calf Raises','target'=>'Calves','desc'=>'Standing calf raise machine, pause at top','sets'=>'4','reps'=>'15-20','rest'=>'45s'],
            ]],
            ['day'=>'Day 5','muscle'=>'Shoulders & Abs','exercises'=>[
                ['name'=>'Overhead Dumbbell Press','target'=>'Delts','desc'=>'Seated press, dumbbells from shoulder height to overhead','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Lateral Raises','target'=>'Side Delts','desc'=>'Light dumbbells raised to shoulder height, slight bend in elbow','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
                ['name'=>'Face Pulls','target'=>'Rear Delts','desc'=>'Cable rope pull to face level, external rotation','sets'=>'3','reps'=>'15','rest'=>'60s'],
                ['name'=>'Hanging Leg Raises','target'=>'Lower Abs','desc'=>'Hang from bar, raise legs to 90 degrees','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 6','muscle'=>'Rest Day','rest'=>true],
            ['day'=>'Day 7','muscle'=>'Rest Day','rest'=>true],
        ]];
    }

    private function bulkIntermediate() {
        return ['label'=>'Bulk — Intermediate','weeks'=>10,'days_per_week'=>5,'rest_between'=>'75s','focus'=>'Hypertrophy',
        'days'=>[
            ['day'=>'Day 1','muscle'=>'Chest','exercises'=>[
                ['name'=>'Barbell Bench Press','target'=>'Chest','desc'=>'Flat bench, controlled descent to chest, explosive push','sets'=>'5','reps'=>'5-8','rest'=>'120s'],
                ['name'=>'Incline Dumbbell Press','target'=>'Upper Chest','desc'=>'45-degree incline for upper pec emphasis','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Weighted Dips','target'=>'Lower Chest','desc'=>'Lean forward slightly, add weight belt','sets'=>'3','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Pec Deck Machine','target'=>'Inner Chest','desc'=>'Squeeze at peak contraction, slow negative','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 2','muscle'=>'Back','exercises'=>[
                ['name'=>'Barbell Deadlift','target'=>'Full Back','desc'=>'Conventional deadlift, maintain neutral spine','sets'=>'4','reps'=>'5-6','rest'=>'180s'],
                ['name'=>'Weighted Pull-ups','target'=>'Lats','desc'=>'Add weight via belt, full extension to chin over bar','sets'=>'4','reps'=>'6-8','rest'=>'90s'],
                ['name'=>'T-Bar Row','target'=>'Mid Back','desc'=>'Chest-supported or standing, pull to lower chest','sets'=>'3','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Straight Arm Pulldown','target'=>'Lats','desc'=>'Cable pulldown with straight arms for lat isolation','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 3','muscle'=>'Legs','exercises'=>[
                ['name'=>'Back Squat','target'=>'Quads/Glutes','desc'=>'Heavy squat, below parallel, brace core hard','sets'=>'5','reps'=>'5-8','rest'=>'180s'],
                ['name'=>'Bulgarian Split Squat','target'=>'Quads/Glutes','desc'=>'Rear foot elevated, dumbbell in each hand','sets'=>'3','reps'=>'10-12','rest'=>'90s'],
                ['name'=>'Leg Curl','target'=>'Hamstrings','desc'=>'Lying or seated hamstring curl, squeeze at top','sets'=>'4','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Standing Calf Raise','target'=>'Calves','desc'=>'Heavy weight, full range of motion, pause at top','sets'=>'4','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 4','muscle'=>'Shoulders & Arms','exercises'=>[
                ['name'=>'Military Press','target'=>'Front Delts','desc'=>'Standing barbell press, strict form no leg drive','sets'=>'4','reps'=>'6-8','rest'=>'120s'],
                ['name'=>'Arnold Press','target'=>'All Delts','desc'=>'Rotating dumbbell press for full delt activation','sets'=>'3','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Barbell Curl','target'=>'Biceps','desc'=>'Strict standing curl, no swinging','sets'=>'4','reps'=>'8-10','rest'=>'75s'],
                ['name'=>'Skull Crushers','target'=>'Triceps','desc'=>'Lying EZ bar extension behind head, elbows locked','sets'=>'4','reps'=>'8-10','rest'=>'75s'],
            ]],
            ['day'=>'Day 5','muscle'=>'Rest Day','rest'=>true],
            ['day'=>'Day 6','muscle'=>'Full Body Power','exercises'=>[
                ['name'=>'Power Clean','target'=>'Full Body','desc'=>'Explosive pull from floor to front rack position','sets'=>'4','reps'=>'5','rest'=>'120s'],
                ['name'=>'Front Squat','target'=>'Quads','desc'=>'Barbell in front rack, upright torso, deep squat','sets'=>'4','reps'=>'6-8','rest'=>'120s'],
                ['name'=>'Pendlay Row','target'=>'Back','desc'=>'Barbell row from floor, explosive pull, controlled lower','sets'=>'3','reps'=>'6-8','rest'=>'90s'],
                ['name'=>'Farmer Walks','target'=>'Grip/Core','desc'=>'Heavy dumbbells, walk 40m with tight core','sets'=>'3','reps'=>'40m','rest'=>'90s'],
            ]],
            ['day'=>'Day 7','muscle'=>'Rest Day','rest'=>true],
        ]];
    }

    private function bulkVeteran() {
        return ['label'=>'Bulk — Veteran','weeks'=>12,'days_per_week'=>6,'rest_between'=>'60-90s','focus'=>'Advanced Hypertrophy & Strength',
        'days'=>[
            ['day'=>'Day 1','muscle'=>'Chest & Triceps','exercises'=>[
                ['name'=>'Incline Barbell Press','target'=>'Upper Chest','desc'=>'Heavy incline press for upper pec thickness','sets'=>'5','reps'=>'4-6','rest'=>'180s'],
                ['name'=>'Flat Dumbbell Press','target'=>'Chest','desc'=>'Heavy dumbbells, deep stretch at bottom','sets'=>'4','reps'=>'6-8','rest'=>'120s'],
                ['name'=>'Cable Crossovers (3 angles)','target'=>'Full Chest','desc'=>'High, mid, low cable angles — drop set on last','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
                ['name'=>'Close Grip Bench Press','target'=>'Triceps','desc'=>'Hands shoulder-width, elbows tucked, heavy','sets'=>'4','reps'=>'6-8','rest'=>'90s'],
                ['name'=>'Overhead Rope Extension','target'=>'Tricep Long Head','desc'=>'Cable behind head, stretch and squeeze','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 2','muscle'=>'Back & Biceps','exercises'=>[
                ['name'=>'Rack Deadlift','target'=>'Upper Back','desc'=>'Pull from knee height for heavy upper back work','sets'=>'4','reps'=>'4-6','rest'=>'180s'],
                ['name'=>'Weighted Chin-ups','target'=>'Lats/Biceps','desc'=>'Supinated grip, heavy, full range','sets'=>'4','reps'=>'6-8','rest'=>'120s'],
                ['name'=>'Meadows Row','target'=>'Lats','desc'=>'Landmine one-arm row, John Meadows style','sets'=>'3','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Incline Dumbbell Curl','target'=>'Bicep Long Head','desc'=>'Incline bench curl for maximum stretch','sets'=>'4','reps'=>'8-10','rest'=>'75s'],
            ]],
            ['day'=>'Day 3','muscle'=>'Legs — Quad Focus','exercises'=>[
                ['name'=>'Back Squat','target'=>'Quads','desc'=>'ATG squat, heavy progressive overload','sets'=>'5','reps'=>'4-6','rest'=>'180s'],
                ['name'=>'Hack Squat','target'=>'Quads','desc'=>'Machine hack squat, close stance for outer sweep','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Walking Lunges','target'=>'Quads/Glutes','desc'=>'Dumbbell lunges 20 steps per leg','sets'=>'3','reps'=>'20 steps','rest'=>'90s'],
                ['name'=>'Leg Extension','target'=>'Quad Isolation','desc'=>'Squeeze at top, slow negative 3-second count','sets'=>'3','reps'=>'15-20','rest'=>'60s'],
            ]],
            ['day'=>'Day 4','muscle'=>'Shoulders','exercises'=>[
                ['name'=>'Seated Barbell OHP','target'=>'Front Delts','desc'=>'Heavy seated press from behind neck (to ear level)','sets'=>'5','reps'=>'5-8','rest'=>'120s'],
                ['name'=>'Cable Lateral Raise','target'=>'Side Delts','desc'=>'One arm at a time for maximum tension','sets'=>'4','reps'=>'12-15','rest'=>'60s'],
                ['name'=>'Reverse Pec Deck','target'=>'Rear Delts','desc'=>'Face the pad, squeeze rear delts hard','sets'=>'4','reps'=>'12-15','rest'=>'60s'],
                ['name'=>'Barbell Shrugs','target'=>'Traps','desc'=>'Heavy barbell shrugs, hold at top 2 seconds','sets'=>'4','reps'=>'10-12','rest'=>'75s'],
            ]],
            ['day'=>'Day 5','muscle'=>'Legs — Hamstring/Glute Focus','exercises'=>[
                ['name'=>'Sumo Deadlift','target'=>'Glutes/Hams','desc'=>'Wide stance, toes out, drive hips through','sets'=>'4','reps'=>'5-6','rest'=>'180s'],
                ['name'=>'Glute-Ham Raise','target'=>'Hamstrings','desc'=>'GHD machine, full extension to contraction','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Hip Thrust','target'=>'Glutes','desc'=>'Heavy barbell hip thrust, 2 sec squeeze at top','sets'=>'4','reps'=>'10-12','rest'=>'90s'],
                ['name'=>'Seated Leg Curl','target'=>'Hamstrings','desc'=>'Controlled tempo, full contraction','sets'=>'3','reps'=>'12-15','rest'=>'60s'],
            ]],
            ['day'=>'Day 6','muscle'=>'Arms','exercises'=>[
                ['name'=>'Weighted Dips','target'=>'Triceps','desc'=>'Upright torso for tricep focus, heavy','sets'=>'4','reps'=>'6-8','rest'=>'90s'],
                ['name'=>'Preacher Curl','target'=>'Bicep Short Head','desc'=>'EZ bar preacher for peak contraction','sets'=>'4','reps'=>'8-10','rest'=>'75s'],
                ['name'=>'Overhead Tricep Extension','target'=>'Long Head','desc'=>'Dumbbell overhead, deep stretch','sets'=>'3','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Hammer Curls','target'=>'Brachialis','desc'=>'Neutral grip, heavy for arm thickness','sets'=>'3','reps'=>'10-12','rest'=>'60s'],
            ]],
            ['day'=>'Day 7','muscle'=>'Rest Day','rest'=>true],
        ]];
    }

    private function shreddedBeginner() {
        return ['label'=>'Shredded — Beginner','weeks'=>8,'days_per_week'=>4,'rest_between'=>'45-60s','focus'=>'Fat Loss & Muscle Tone',
        'days'=>[
            ['day'=>'Day 1','muscle'=>'Full Body Circuit A','exercises'=>[
                ['name'=>'Goblet Squat','target'=>'Legs/Core','desc'=>'Hold dumbbell at chest, squat deep with upright torso','sets'=>'3','reps'=>'15','rest'=>'45s'],
                ['name'=>'Push-ups','target'=>'Chest','desc'=>'Full range push-ups, modify on knees if needed','sets'=>'3','reps'=>'12-15','rest'=>'45s'],
                ['name'=>'Dumbbell Row','target'=>'Back','desc'=>'One arm row, squeeze shoulder blade at top','sets'=>'3','reps'=>'12','rest'=>'45s'],
                ['name'=>'Mountain Climbers','target'=>'Core/Cardio','desc'=>'Fast alternating knee drives in plank position','sets'=>'3','reps'=>'30s','rest'=>'30s'],
            ]],
            ['day'=>'Day 2','muscle'=>'Cardio & Core','exercises'=>[
                ['name'=>'Treadmill Incline Walk','target'=>'Fat Burn','desc'=>'12% incline, 5.5 km/h speed, steady state','sets'=>'1','reps'=>'30 min','rest'=>'—'],
                ['name'=>'Plank Hold','target'=>'Core','desc'=>'Hold plank on forearms, keep hips level','sets'=>'3','reps'=>'45s','rest'=>'30s'],
                ['name'=>'Bicycle Crunches','target'=>'Obliques','desc'=>'Opposite elbow to knee, controlled tempo','sets'=>'3','reps'=>'20','rest'=>'30s'],
                ['name'=>'Jump Rope','target'=>'Cardio','desc'=>'Moderate pace skipping for conditioning','sets'=>'3','reps'=>'2 min','rest'=>'60s'],
            ]],
            ['day'=>'Day 3','muscle'=>'Rest Day','rest'=>true],
            ['day'=>'Day 4','muscle'=>'Full Body Circuit B','exercises'=>[
                ['name'=>'Dumbbell Lunges','target'=>'Legs','desc'=>'Alternating forward lunges with dumbbells','sets'=>'3','reps'=>'12/leg','rest'=>'45s'],
                ['name'=>'Dumbbell Shoulder Press','target'=>'Shoulders','desc'=>'Seated or standing, press overhead','sets'=>'3','reps'=>'12','rest'=>'45s'],
                ['name'=>'Lat Pulldown','target'=>'Back','desc'=>'Wide grip pulldown, lean back slightly','sets'=>'3','reps'=>'12-15','rest'=>'45s'],
                ['name'=>'Burpees','target'=>'Full Body','desc'=>'Squat thrust with jump, full range','sets'=>'3','reps'=>'10','rest'=>'60s'],
            ]],
            ['day'=>'Day 5','muscle'=>'HIIT Cardio','exercises'=>[
                ['name'=>'Sprint Intervals','target'=>'Fat Burn','desc'=>'30s all-out sprint, 60s walk recovery','sets'=>'8','reps'=>'30s on/60s off','rest'=>'—'],
                ['name'=>'Box Jumps','target'=>'Explosive Power','desc'=>'Jump onto 20-inch box, step down','sets'=>'3','reps'=>'10','rest'=>'60s'],
                ['name'=>'Battle Ropes','target'=>'Arms/Cardio','desc'=>'Alternating waves with thick ropes','sets'=>'3','reps'=>'30s','rest'=>'45s'],
            ]],
            ['day'=>'Day 6','muscle'=>'Rest Day','rest'=>true],
            ['day'=>'Day 7','muscle'=>'Rest Day','rest'=>true],
        ]];
    }

    private function shreddedIntermediate() {
        return ['label'=>'Shredded — Intermediate','weeks'=>10,'days_per_week'=>5,'rest_between'=>'30-60s','focus'=>'Fat Burn & Conditioning',
        'days'=>[
            ['day'=>'Day 1','muscle'=>'Push + HIIT','exercises'=>[
                ['name'=>'Barbell Bench Press','target'=>'Chest','desc'=>'Moderate weight, fast tempo, short rest','sets'=>'4','reps'=>'10-12','rest'=>'60s'],
                ['name'=>'DB Shoulder Press','target'=>'Shoulders','desc'=>'Standing for core activation, controlled reps','sets'=>'3','reps'=>'12','rest'=>'60s'],
                ['name'=>'Tricep Dips (Bodyweight)','target'=>'Triceps','desc'=>'Parallel bar dips, full range of motion','sets'=>'3','reps'=>'15','rest'=>'45s'],
                ['name'=>'Finisher: Rowing Machine','target'=>'Cardio','desc'=>'500m all-out row for time','sets'=>'3','reps'=>'500m','rest'=>'90s'],
            ]],
            ['day'=>'Day 2','muscle'=>'Pull + Core','exercises'=>[
                ['name'=>'Pull-ups','target'=>'Lats','desc'=>'Bodyweight pull-ups, full dead hang','sets'=>'4','reps'=>'10-12','rest'=>'60s'],
                ['name'=>'Cable Face Pulls','target'=>'Rear Delts','desc'=>'High cable pull to face, squeeze','sets'=>'3','reps'=>'15','rest'=>'45s'],
                ['name'=>'Dumbbell Curl','target'=>'Biceps','desc'=>'Alternating curls, slow negative','sets'=>'3','reps'=>'12','rest'=>'45s'],
                ['name'=>'Ab Wheel Rollout','target'=>'Core','desc'=>'Full extension from knees, squeeze abs','sets'=>'3','reps'=>'12','rest'=>'60s'],
            ]],
            ['day'=>'Day 3','muscle'=>'Legs + Plyometrics','exercises'=>[
                ['name'=>'Front Squat','target'=>'Quads','desc'=>'Barbell front rack, upright torso','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Walking Lunges','target'=>'Quads/Glutes','desc'=>'Dumbbell lunges 16 steps','sets'=>'3','reps'=>'16 steps','rest'=>'60s'],
                ['name'=>'Jump Squats','target'=>'Explosive','desc'=>'Bodyweight squat to max height jump','sets'=>'3','reps'=>'15','rest'=>'60s'],
                ['name'=>'Leg Curl','target'=>'Hamstrings','desc'=>'Slow eccentric, fast concentric','sets'=>'3','reps'=>'12-15','rest'=>'45s'],
            ]],
            ['day'=>'Day 4','muscle'=>'Rest Day','rest'=>true],
            ['day'=>'Day 5','muscle'=>'Full Body HIIT','exercises'=>[
                ['name'=>'Kettlebell Swings','target'=>'Posterior Chain','desc'=>'Russian style, hip snap at top','sets'=>'4','reps'=>'20','rest'=>'45s'],
                ['name'=>'Thrusters','target'=>'Full Body','desc'=>'Front squat to overhead press in one motion','sets'=>'3','reps'=>'12','rest'=>'60s'],
                ['name'=>'Box Jumps','target'=>'Explosive','desc'=>'24-inch box, step down between reps','sets'=>'3','reps'=>'12','rest'=>'45s'],
                ['name'=>'Plank to Push-up','target'=>'Core/Chest','desc'=>'Forearm plank to full push-up position','sets'=>'3','reps'=>'10','rest'=>'45s'],
            ]],
            ['day'=>'Day 6','muscle'=>'Steady State Cardio','exercises'=>[
                ['name'=>'Incline Treadmill Walk','target'=>'Fat Burn','desc'=>'15% incline, 6 km/h, heart rate zone 2','sets'=>'1','reps'=>'40 min','rest'=>'—'],
                ['name'=>'Stairmaster','target'=>'Legs/Cardio','desc'=>'Moderate pace, no holding rails','sets'=>'1','reps'=>'15 min','rest'=>'—'],
            ]],
            ['day'=>'Day 7','muscle'=>'Rest Day','rest'=>true],
        ]];
    }

    private function shreddedVeteran() {
        return ['label'=>'Shredded — Veteran','weeks'=>12,'days_per_week'=>6,'rest_between'=>'30-45s','focus'=>'Peak Conditioning & Definition',
        'days'=>[
            ['day'=>'Day 1','muscle'=>'Chest + HIIT Finisher','exercises'=>[
                ['name'=>'Incline Barbell Press','target'=>'Upper Chest','desc'=>'Superset with push-ups, moderate weight','sets'=>'4','reps'=>'10-12','rest'=>'45s'],
                ['name'=>'Cable Flye (Low to High)','target'=>'Upper Chest','desc'=>'Low cable to high squeeze, peak contraction','sets'=>'4','reps'=>'12-15','rest'=>'30s'],
                ['name'=>'Decline Push-ups','target'=>'Upper Chest','desc'=>'Feet elevated, bodyweight to failure','sets'=>'3','reps'=>'AMRAP','rest'=>'30s'],
                ['name'=>'Assault Bike Intervals','target'=>'Cardio','desc'=>'20s max effort / 40s recovery × 8 rounds','sets'=>'8','reps'=>'20s/40s','rest'=>'—'],
            ]],
            ['day'=>'Day 2','muscle'=>'Back + Core','exercises'=>[
                ['name'=>'Weighted Pull-ups','target'=>'Lats','desc'=>'Add weight, 6-8 strict reps','sets'=>'4','reps'=>'6-8','rest'=>'60s'],
                ['name'=>'Single-Arm DB Row','target'=>'Lats','desc'=>'High volume, squeeze at top','sets'=>'4','reps'=>'12-15','rest'=>'45s'],
                ['name'=>'Cable Pullover','target'=>'Lats','desc'=>'Straight arm cable pullover for stretch','sets'=>'3','reps'=>'15','rest'=>'45s'],
                ['name'=>'Hanging Windshield Wipers','target'=>'Obliques','desc'=>'Hang from bar, rotate legs side to side','sets'=>'3','reps'=>'10/side','rest'=>'60s'],
            ]],
            ['day'=>'Day 3','muscle'=>'Legs — High Volume','exercises'=>[
                ['name'=>'Squat (Pause Reps)','target'=>'Quads','desc'=>'2-second pause at bottom of each rep','sets'=>'4','reps'=>'8-10','rest'=>'90s'],
                ['name'=>'Romanian Deadlift','target'=>'Hamstrings','desc'=>'Deep stretch, squeeze glutes at top','sets'=>'4','reps'=>'10-12','rest'=>'75s'],
                ['name'=>'Leg Press (Narrow Stance)','target'=>'Outer Quads','desc'=>'Feet close together for outer quad sweep','sets'=>'3','reps'=>'15-20','rest'=>'60s'],
                ['name'=>'Jump Lunges','target'=>'Explosive','desc'=>'Alternating jump lunges for conditioning','sets'=>'3','reps'=>'20','rest'=>'45s'],
            ]],
            ['day'=>'Day 4','muscle'=>'Shoulders + Arms','exercises'=>[
                ['name'=>'Push Press','target'=>'Shoulders','desc'=>'Slight leg drive to press heavy overhead','sets'=>'4','reps'=>'8-10','rest'=>'75s'],
                ['name'=>'Superset: Curl + Extension','target'=>'Arms','desc'=>'DB curl immediately into overhead tricep ext','sets'=>'4','reps'=>'12+12','rest'=>'45s'],
                ['name'=>'Lateral Raise 21s','target'=>'Side Delts','desc'=>'7 bottom half, 7 top half, 7 full range','sets'=>'3','reps'=>'21','rest'=>'60s'],
                ['name'=>'Reverse Curl','target'=>'Forearms','desc'=>'Overhand grip barbell curl for forearm definition','sets'=>'3','reps'=>'12-15','rest'=>'45s'],
            ]],
            ['day'=>'Day 5','muscle'=>'Full Body Metabolic','exercises'=>[
                ['name'=>'Barbell Complex','target'=>'Full Body','desc'=>'Deadlift→Row→Clean→Press→Squat (6 reps each, no rest)','sets'=>'4','reps'=>'6 each','rest'=>'120s'],
                ['name'=>'Sled Push','target'=>'Legs/Cardio','desc'=>'Heavy sled push 30m, all out effort','sets'=>'4','reps'=>'30m','rest'=>'90s'],
                ['name'=>'Renegade Rows','target'=>'Core/Back','desc'=>'Plank position, alternating DB rows','sets'=>'3','reps'=>'10/arm','rest'=>'60s'],
            ]],
            ['day'=>'Day 6','muscle'=>'Active Recovery + Abs','exercises'=>[
                ['name'=>'Light Cycling','target'=>'Recovery','desc'=>'20 min easy spin, heart rate under 120bpm','sets'=>'1','reps'=>'20 min','rest'=>'—'],
                ['name'=>'Cable Crunch','target'=>'Upper Abs','desc'=>'Kneeling cable crunch, squeeze hard','sets'=>'4','reps'=>'15-20','rest'=>'45s'],
                ['name'=>'Pallof Press','target'=>'Anti-Rotation','desc'=>'Cable press and hold for core stability','sets'=>'3','reps'=>'12/side','rest'=>'45s'],
            ]],
            ['day'=>'Day 7','muscle'=>'Rest Day','rest'=>true],
        ]];
    }
}
