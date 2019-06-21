<?php namespace Visiosoft\DropboxFieldType\Support\Config;

use Anomaly\SelectFieldType\SelectFieldType;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class RelatedHandler
 *
 * @link   http://openclassify.com/
 * @author OpenClassify, Inc. <support@openclassify.com>
 * @author Visiosoft Inc <support@openclassify.com>
 */
class RelatedHandler
{

    /**
     * Handle the options.
     *
     * @param SelectFieldType $fieldType
     * @param StreamRepositoryInterface $streams
     */
    public function handle(SelectFieldType $fieldType, StreamRepositoryInterface $streams)
    {
        $options = [];

        /* @var StreamInterface as $stream */
        foreach ($streams->visible() as $stream) {
            $options[ucwords(str_replace('_', ' ', $stream->getNamespace()))][$stream->getEntryModelName(
            )] = $stream->getName();
        }

        foreach ($options as $namespace) {
            ksort($namespace);
        }

        ksort($options);

        $fieldType->setOptions($options);
    }
}
