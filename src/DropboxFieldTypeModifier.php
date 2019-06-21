<?php namespace Visiosoft\DropboxFieldType;

use Visiosoft\DropboxFieldType\Command\SetRelation;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class RelationshipFieldTypeModifier
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 * @package       Anomaly\RelationshipFieldType
 */
class DropboxFieldTypeModifier extends FieldTypeModifier
{

    use DispatchesJobs;

    /**
     * The field type instance.
     * This is for IDE support.
     *
     * @var DropboxFieldType
     */
    protected $fieldType;

    /**
     * Modify the value.
     *
     * @param $value
     * @return integer
     */
    public function modify($value)
    {
        if ($value instanceof EloquentModel) {

            $this->dispatch(new SetRelation($this->fieldType, $value));

            return $value->getId();
        }

        return $value === null ? $value : (int)$value;
    }

    /**
     * Restore the value from storage format.
     *
     * @param  $value
     * @return mixed
     */
    public function restore($value)
    {
        return $value ?: null;
    }
}
