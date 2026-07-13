<?php

namespace App\Console\Commands;

use App\Models\Breed;
use App\Models\Cow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateCowBreeds extends Command
{
    protected $signature = 'app:migrate-cow-breeds';

    protected $description = 'Seed breeds table from existing cows.breed values and update cows.breed_id';

    public function handle()
    {
        if (Breed::count() > 0) {
            $this->warn('Breeds table already has data ('.Breed::count().' records). Nothing to migrate.');
            $this->table(
                ['ID', 'Name', 'Cow Count'],
                Breed::withCount('cows')->get()->map(fn($b) => [$b->id, $b->name, $b->cows_count])->toArray()
            );
            return Command::SUCCESS;
        }

        $this->info('Step 1: Extracting unique breed values from cows.breed...');
        $uniqueBreeds = Cow::select('breed')->distinct()->pluck('breed')->toArray();

        if (empty($uniqueBreeds) || (count($uniqueBreeds) === 1 && $uniqueBreeds[0] === null)) {
            $this->warn('No breed values found in cows table. Nothing to migrate.');
            return Command::SUCCESS;
        }

        $this->info('Found ' . count($uniqueBreeds) . ' unique breed values:');
        foreach ($uniqueBreeds as $breed) {
            $this->line("  - '{$breed}'");
        }

        $this->newLine();
        $this->info('Step 2: Creating Breed records...');

        $breedMap = [];
        DB::transaction(function () use ($uniqueBreeds, &$breedMap) {
            foreach ($uniqueBreeds as $breedName) {
                if ($breedName === null) continue;
                $breed = Breed::create(['name' => $breedName]);
                $breedMap[$breed->name] = $breed->id;
                $this->line("  ✓ Created breed: {$breed->name} (ID: {$breed->id})");
            }
        });

        $this->newLine();
        $this->info('Step 3: Updating cows.breed_id from breed name mapping...');

        $updatedCount = 0;
        DB::transaction(function () use ($breedMap, &$updatedCount) {
            foreach ($breedMap as $breedName => $breedId) {
                $affected = Cow::where('breed', $breedName)->update(['breed_id' => $breedId]);
                $this->line("  → {$affected} cow(s) for breed '{$breedName}' (ID: {$breedId})");
                $updatedCount += $affected;
            }
        });

        $this->newLine();
        $this->info('Step 4: Verification');
        $totalCows = Cow::count();
        $mappedCows = Cow::whereNotNull('breed_id')->count();
        $unmappedCows = Cow::whereNull('breed_id')->count();

        $this->line("  Total cows:   {$totalCows}");
        $this->line("  Mapped cows:  {$mappedCows}");
        $this->line("  Unmapped:     {$unmappedCows}");

        if ($mappedCows === $totalCows) {
            $this->newLine();
            $this->info('✅ ALL COWS SUCCESSFULLY MAPPED to breed_id.');
        } else {
            $this->newLine();
            $this->warn("⚠️  {$unmappedCows} cow(s) still have NULL breed_id. Check for breed values that weren't matched.");
        }

        return Command::SUCCESS;
    }
}
