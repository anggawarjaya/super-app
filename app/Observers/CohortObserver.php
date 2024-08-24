<?php

namespace App\Observers;

use App\Models\Cohort;

class CohortObserver
{
    /**
     * Handle the Cohort "created" event.
     */
    public function created(Cohort $cohort): void
    {
        if ($cohort->is_active) {
            Cohort::where('id', '!=', $cohort->id)->update(['is_active' => false]);
        }
    }

    /**
     * Handle the Cohort "updated" event.
     */
    public function updated(Cohort $cohort): void
    {
        if ($cohort->is_active) {
            Cohort::where('id', '!=', $cohort->id)->update(['is_active' => false]);
        }
    }

    /**
     * Handle the Cohort "deleted" event.
     */
    public function deleted(Cohort $cohort): void
    {
        if ($cohort->is_active) {
            $cohort->is_active = false;
            $cohort->saveQuietly();
        }
    }

    /**
     * Handle the Cohort "restored" event.
     */
    public function restored(Cohort $cohort): void
    {
        //
    }

    /**
     * Handle the Cohort "force deleted" event.
     */
    public function forceDeleted(Cohort $cohort): void
    {
        if ($cohort->is_active) {
            $cohort->is_active = false;
            $cohort->saveQuietly();
        }
    }
}
