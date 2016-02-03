<?php

namespace Corcel;

use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Options class.
 *
 * @author José CI <josec89@gmail.com>
 */
class Options extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'options';
    /**
     * The primary key of the model.
     *
     * @var string
     */
    protected $primaryKey = 'option_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name',
        'option_value',
        'autoload',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['value'];

    /**
     * Gets the value.
     * Tries to unserialize the object and returns the value if that doesn't work.
     *
     * @return value
     */
    public function getValueAttribute()
    {
        try {
            return unserialize($this->option_value);
        } catch (Exception $ex) {
            return $this->option_value;
        }
    }

    /**
     * Gets option field by its name.
     *
     * @param string $name
     *
     * @return string|array
     */
    public static function get($name)
    {
        if ($option = self::where('option_name', $name)->first()) {
            return $option->value;
        }

        return;
    }

    /**
     * Gets all the options.
     *
     * @return array
     */
    public static function getAll()
    {
        $options = self::all();
        $result = [];
        foreach ($options as $option) {
            $result[$option->option_name] = $option->value;
        }

        return $result;
    }
}
