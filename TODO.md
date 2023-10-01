### TO DO

 -[ ] Add correct namespace for component concerns when generation via console command - e.g. Can `RenderView` etc - These also need prefixing with a '\'
 -[ ] Make config publishable
 -[ ] Add correct namespace for component itself when generating via command
 -[ ] Fix template for `getField` method in stub - should return `array` not a `Block`
 -[ ] Fix stub for `renderField` - signature should be `protected static function renderView(ContentComponent $component): View`
 -[ ] Possibly look at providing a method to amend data without having to amend
render method - i.e. I want to change the data but don't want to have to rewrite
the `renderView` method.<br/><br/>
Something simple like `public function data(Contentcomponent $component): array`<br/><br/>
```php
public function data(Contentcomponent $component): array {
    return array_merge($component->getData(), [
        'data_to_be_changed' => 'changed'
    ]);
}
```
This would also allow just changing one array item.