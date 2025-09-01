## How to reproduce

1. Create a user
2. Visit the `theatres` colleciton in the CP
3. Create a new theatre -> notice the `Entry creating` instructions on the title field
4. Save entry with cmd + s -> Notice the instructions disappear instead of reading `Entry created`

https://github.com/user-attachments/assets/73600ad0-82f8-4658-bc2a-93cd5132f3e2

### What causes the bug

I tracked the issue down to a query in the `AppServiceProvider` of my site. If you remove the query, the blueprint fields are ensured as expected.

```php
Entry::query()
    ->where('collection', 'theatres')
    ->get()
    ->each(function ($entry) {
        //
    });
```

### A potential solution for this scenario

The bug can also be fixed by clearing the Blink cache directly in the service provider. But I'm not sure this is a good solution either.

```php
Entry::query()
    ->where('collection', 'theatres')
    ->get()
    ->each(function ($entry) {
        Blink::forget("entry-{$entry->id()}-blueprint");
    });
```

## A similar bug

I noticed a similar blueprint caching bug when a blueprint contains a `parent` field. This is the case with stuctured collections or if the blueprint contains a `parent` entries fieldtype.

Check out the `Pages` collection. The title instructions will always read `Entry creating`. Even when editing an existing entry. This is likely the underlying issue as in the theatres collection, as the pages collection is queried by the `parent` entries fieldtype.

https://github.com/user-attachments/assets/ad600002-f404-465b-9633-af8d091a8dd6

