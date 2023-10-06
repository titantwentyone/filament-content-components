<?php

namespace Titantwentyone\FilamentContentComponents\Console\Commands;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\Fixtures\Models\Page;
use Titantwentyone\FilamentContentComponents\Contracts\ContentComponent;

class CorrectComponentTypeCommand extends \Illuminate\Console\Command
{
    protected $signature = 'fcc:correct {model} {field} {old} {new}';

    protected $description = 'Converts the key of a content builder type';

    public function handle()
    {
        /** @var $model Model */
        /** @var $new ContentComponent */
        extract($this->arguments());

        $this->checkArguments($model, $field, $old, $new);

        $model::all()->each(function(Model $model) use ($field, $old, $new) {

            $content = $model->$field;

            if($content && is_array($content)) {

                $this->recurse($content, function($value, $key, &$array) use ($old, $new) {

                    if($key == 'type' && $value == $old) {
                        //$array['type'] = Str::of($new)->replace("\\", ".");
                        $array['type'] = Str::of($new)->replaceStart('\\', '');
                    }

                });

            }

            $model->$field = $content;

            $model->save();

        });
    }

    public function checkArguments($model, $field, $old, $new)
    {
        if (!$model || !$field || !$old || !$new) {
           throw new \Exception("Please specify all arguments");
        }

        if(!class_exists($model)) {
            throw new \Exception("Model {$model} does not exist");
        }

        if(!in_array($field, Schema::getColumnListing((new $model)->getTable()))) {
            throw new \Exception("Field {$field} on {$model} does not exist");
        }

        if(!class_exists($new)) {
            throw new \Exception("Component {$new} does not exist");
        }
    }

    public function recurse(&$array, \Closure $callback) {

        foreach($array as $key => $value) {

            if(!is_array($value)) {
                $callback($value, $key, $array);
            } else {
                $this->recurse($value, $callback);
                $array[$key] = $value;
            }
        }
    }
}