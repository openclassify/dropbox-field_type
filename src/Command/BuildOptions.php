<?php namespace Visiosoft\DropboxFieldType\Command;

use Visiosoft\DropboxFieldType\DropboxFieldType;
use Illuminate\Container\Container;

class BuildOptions
{

    /**
     * The field type instance.
     *
     * @var DropboxFieldType
     */
    protected $fieldType;

    /**
     * Create a new BuildOptions instance.
     *
     * @param DropboxFieldType $fieldType
     */
    public function __construct(DropboxFieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Handle the command.
     *
     * @param Container $container
     */
    public function handle(Container $container)
    {
        $model   = $this->fieldType->getRelatedModel();
        $handler = $this->fieldType->config('handler', $model->getDropboxFieldTypeOptionsHandler());

        if (!class_exists($handler) && !str_contains($handler, '@')) {
            $handler = array_get($this->fieldType->getHandlers(), $handler);
        }

        if (is_string($handler) && !str_contains($handler, '@')) {
            $handler .= '@handle';
        }

        $container->call($handler, ['fieldType' => $this->fieldType]);
    }
}
