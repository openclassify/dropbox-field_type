<?php namespace Visiosoft\DropboxFieldType\Handler;

use Visiosoft\DropboxFieldType\DropboxFieldType;

/**
 * Class Assignments
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 */
class Assignments
{

    /**
     * Handle the options.
     *
     * @param  RelationshipFieldType $fieldType
     * @return array
     */
    public function handle(DropboxFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        $fieldType->setOptions(
            $query->get()->pluck(
                $model->getTitleName(),
                $model->getKeyName()
            )->all()
        );
    }
}
