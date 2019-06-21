<?php namespace Visiosoft\DropboxFieldType\Command;

use Visiosoft\DropboxFieldType\DropboxFieldType;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class SetRelation
 *
 * @link   http://openclassify.com/
 * @author OpenClassify, Inc. <support@openclassify.com>
 * @author Visiosoft Inc <support@openclassify.com>
 */
class SetRelation
{

    /**
     * The field type.
     *
     * @var DropboxFieldType
     */
    protected $fieldType;

    /**
     * The related model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new SetRelation instance.
     *
     * @param DropboxFieldType $fieldType
     * @param EloquentModel         $model
     */
    public function __construct(DropboxFieldType $fieldType, EloquentModel $model)
    {
        $this->model     = $model;
        $this->fieldType = $fieldType;
    }

    /**
     * Hand the command.
     */
    public function handle()
    {
        if (!$entry = $this->fieldType->getEntry()) {
            return;
        }

        $entry->setRelation($this->fieldType->getField(), $this->model);
    }
}
