# A trait to make Eloquent models handle flags in `number` column

This package contains a trait HasFlags to make Eloquent models able to handle multiple flag values using just integer column type. The column type can be any unsigned number type.

### Install

```
composer require andy-shi88/laravel-eloquent-flags
```

### Usages

```php
use AndyShi88\LaravelEloquentFlags\HasFlags;
use AndyShi88\LaravelEloquentFlags\Interfaces\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model implements Flagable
{
    use HasFactory;
    use HasFlags;

    public $table = 'person';

    public $flagableColumns = [
        'ownership' => ['car', 'bike', 'house', 'computer', 'phone', 'console'],
        'category' => ['asian', 'white', 'black', 'hispanic', 'middle-eastern'],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'ownership',
        'category',
    ];
}
```

- ## Query Usages

```php
$a = Person::factory()->create([
    'name' => 'a',
    'ownership' => ['car', 'house', 'phone'],
    'category' => ['asian', 'white'],
]);
$b = Person::factory()->create([
    'name' => 'b',
    'ownership' => ['car', 'bike', 'house', 'computer', 'phone', 'console'],
    'category' => ['white', 'hispanic'],
]);
$c =  Person::factory()->create([
    'name' => 'c',
    'ownership' => ['car', 'bike'],
    'category' => ['asian', 'middle-eastern'],
]);
$d = Person::factory()->create([
    'name' => 'd',
    'ownership' => ['computer', 'phone', 'console'],
    'category' => ['asian', 'middle-eastern'],
]);
```

- ### `whereSome()`, return data where the column have all of the values specified
```php
$resSome = Person::whereSome([
    'column' => 'ownership',
    'values' => ['car', 'bike']
])->get(); // return $b, $c
```

- ### `whereAll()`, return data where the column have exactly all of the values specified
```php
$resAll = Person::whereAll([
    'column' => 'ownership',
    'values' => ['car', 'house', 'phone']
])->get(); // return $a
```

- ### `whereIntersect()`, return data where the column have at least one of the specified value
```php
$resIntersect = Person::whereIntersect([
    'column' => 'ownership',
    'values' => ['car', 'house', 'phone']
])->get(); // return $a, $b, $c, $d
```

We'll also by default get the readable array of the fields:
```php
$a = Person::factory()->create([
    'name' => 'a',
    'ownership' => ['car', 'house', 'phone'],
    'category' => ['asian', 'white'],
]);
dd([
    'ownership' => $a->ownership,
    'category' => $a->category
]);

// we'll see
/**
 * array:2 [
 * "ownership" => array:3 [
 *   0 => "car"
 *   1 => "house"
 *  2 => "phone"
 * ]
 * "category" => array:2 [
 *   0 => "asian"
 *   1 => "white"
 * ]
*]
*/
```