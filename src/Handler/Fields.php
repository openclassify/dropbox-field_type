<?php namespace Visiosoft\DropboxFieldType\Handler;

use Visiosoft\DropboxFieldType\DropboxFieldType;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class Fields
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 */
class Fields
{

    /**
     * Handle the options.
     *
     * @param  DropboxFieldType     $fieldType
     * @param  FieldRepositoryInterface  $fields
     * @param  StreamRepositoryInterface $streams
     * @return array
     */
    public function handle(
        DropboxFieldType $fieldType,
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams
    ) {
        $stream    = array_get($fieldType->getConfig(), 'stream');
        $unlocked  = array_get($fieldType->getConfig(), 'unlocked');
        $namespace = array_get($fieldType->getConfig(), 'namespace');

        $fields = $fields->findAllByNamespace($namespace);

        if ($stream && $stream = $streams->findBySlugAndNamespace($stream, $namespace)) {
            $fields = $fields->assignedTo($stream);
        }

        if ($unlocked) {
            $fields = $fields->unlocked();
        }

        $fieldType->setOptions(
            array_combine(
                $fields->pluck('id')->toArray(),
                $fields->pluck('name')->toArray()
            )
        );
    }
}
