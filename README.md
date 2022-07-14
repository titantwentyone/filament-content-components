# Filament CMS

Very simple implementation to provide users with a way to manage content via Filament.


### Creating Components
Components must extend from
`Titantwentyone\FilamentContentComponents\Contracts\ContentComponent`

## String Components
String Components are the simplest of the components and will just output a string.

```
namespace Tests\Fixtures\Components\StringComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderString;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class SayHello extends ContentComponent
{
    use CanRenderString;

    public static function getField(): Block
    {
        return Block::make('simple-text-component')
            ->schema([
                TextInput::make('greeting'),
                TextInput::make('name')
            ]);
    }

    protected static function renderString($data): string
    {
        return "{$data['greeting']} {$data['name']}";
    }
}
```
In your Filament resource, you can use the `ContentBuilder` field to provide the interface to your component:

```
    public static function form(Form $form) : Form
    {
        return $form->schema([
            ContentBuilder::make('content')
        ]);
    }
```

Assuming a resource `Page` is making use of the `ContentBuilder` field bound to a
`content` field, you can access the content:

```
$page->parsedContent;
```

and your component must provide methods for `getField()` which should return an instance of `Filament\Forms\Components\Builder\Block`
and `render($data)` which should return a string.

`getField()` provides a way to define the fields required for a component. These are standard Filament fields so you can
use any that available to use to build out the backed interface,

```

class MyComponent implements Component
{
    use CanRenderString;

    public static function getField() : Block
    {
        return Block::make('mycontrol')
            ->schema([
                TextArea::make('text')
            ])
    }
    
    public function renderString($data) : string
    {
        return $data['text'];
    }
}
```

### Using Views
You can use a view to render your output by employing teh trait `CanRenderViews`;

```
namespace Tests\Fixtures\Components\ViewComponents;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Titantwentyone\FilamentContentComponents\Contracts\CanRenderView;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class MySimpleComponent extends ContentComponent
{
    use CanRenderView;

    public static function getField(): Block
    {
        return Block::make('simple-text-component')
                ->schema([
                    TextArea::make('text')
                ]);
    }
}
```
By default, this will use a view identified by `'my-simple-component'`. Namespaces of Components are respected
and should match the path of the component. For example, a component a `App\Components\MyComponents\MySimpleComponent`
would expect a view to exist at `'my-components.my-simple-component'`

You can manually change the view used by providing a view property:

```
class MySimpleComponent extends ContentComponent
{
    use CanRenderView;
    
    protected static string $view = 'some-other-view'
```
If you want to change the view that should be used dynamically, use the `getViewPath($data)` method:

```
class MySimpleComponent extends ContentComponent
{
    use CanRenderView;
    
    protected static function getViewPath($data)
    {
        return match($data['option') {
            'yes' => 'yes-view',
            'no' => 'no-view
        };
    }
    
    ...
```

You can also provide a `renderView($data)` method to completely override how the view is determined. This is useful
for injecting additional data from other sources or manipulating the data passed to the view

```
class MySimpleComponent extends ContentComponent
{
    use CanRenderView;
    
    protected static function renderView()
    {
        return view('some-other-view', [
            'colour' => $data['is_red'] ? 'bg-red-500' : 'bg-grey-500'
            'allowed' => auth()->check() 
        ]);
    }
    
    ...
```




## Usage
When creating forms use the field `Titantwentyone\FilamentCMS\Fields\ContentBuilder`. This
serves as a simple wrapper around Filaments own `Builder` field. You can specify the types of
components you want to allow by using the `blocks` method, specifying as follows:

```
ContentBuilder::make('content')
    ->blocks([
        MyComponent::getField()
    ])
```
The model to which the filament resource is applied should use the trait
`Titantwentyone\FilamentCMS\Concerns\HasContent`. In addition, you must supply a JSON
column in which we store the contents' data. You should also include a cast to `array` in the model.

In the example above, this would be `content`.

```
public $casts = [
    'content' => 'array'
]
```
To obtain the parsed content, you can use the magic property `parsed(field_name)`:

```
$this->parsedContent
```
