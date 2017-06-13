## About Kendo

Kendo Libraries are support kendo libraries backend in PHP/Laravel

## Installation

composer require willypuzzle/kendo

## Service providers to add

Willypuzzle\Helpers\GeneralServiceProvider::class
Willypuzzle\Kendo\KendoServiceProvider::class

## Configuration Publishing

For Grid:
php artisan vendor:publish --tag=kendo_grid

## Use:

```php
use Willypuzzle\Kendo\Facades\Grid;

// Using Eloquent
return Grid::eloquent(User::query())->make(true);

// Using Query Builder
return Grid::queryBuilder(DB::table('users'))->make(true);

// Using Collection or Array
return Grid::collection(User::all())->make(true);
return Grid::collection([
    ['id' => 1, 'name' => 'Foo'],
    ['id' => 2, 'name' => 'Bar'],
])->make(true);

// Using the Engine Factory
return Grid::of(User::query())->make(true);
return Grid::of(DB::table('users'))->make(true);
return Grid::of(User::all())->make(true);
return Grid::of(DB::select('select * from users'))->make(true);
```

## License

The Kendo Libraries is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
