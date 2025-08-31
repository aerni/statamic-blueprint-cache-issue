<?php

namespace App\Listeners;

use Statamic\Events\EntryBlueprintFound;

class ModifyBlueprint
{
    public function handle(EntryBlueprintFound $event): void
    {
        if (! $event->entry) {
            $event->blueprint->ensureFieldHasConfig('title', [
                'instructions' => 'Entry creating',
            ]);

            return;
        }

        $event->blueprint->ensureFieldHasConfig('title', [
            'instructions' => 'Entry created',
        ]);
    }
}
