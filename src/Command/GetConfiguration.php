<?php namespace Visiosoft\DropboxFieldType\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;

class GetConfiguration
{

    /**
     * The config key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new GetConfiguration instance.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Handle the command.
     *
     * @param  Repository $cache
     * @return Collection
     */
    public function handle(Repository $cache)
    {
        return new Collection(
            array_merge($cache->get('visiosoft/dropbox-field_type::' . $this->key), ['key' => $this->key])
        );
    }
}
