<?php namespace Visiosoft\DropboxFieldType;

use Visiosoft\DropboxFieldType\Command\GetLookupTable;
use Visiosoft\DropboxFieldType\Handler\Related;
use Visiosoft\DropboxFieldType\Table\LookupTableBuilder;
use Visiosoft\DropboxFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Contracts\Container\Container;

/**
 * Class RelationshipFieldTypeServiceProvider
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 * @package       Anomaly\RelationshipFieldType
 */
class DropboxFieldTypeServiceProvider extends AddonServiceProvider
{

    /**
     * The singleton bindings.
     *
     * @var array
     */
    protected $singletons = [
        'Visiosoft\DropboxFieldType\DropboxFieldTypeModifier' => 'Visiosoft\DropboxFieldType\DropboxFieldTypeModifier'
    ];

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'streams/dropbox-field_type/index/{key}'    => 'Visiosoft\DropboxFieldType\Http\Controller\LookupController@index',
        'streams/dropbox-field_type/selected/{key}' => 'Visiosoft\DropboxFieldType\Http\Controller\LookupController@selected'
    ];

    /**
     * Register the addon.
     *
     * @param EloquentModel $model
     */
    public function register(EloquentModel $model)
    {
        $model->bind(
            'new_dropbox_field_type_lookup_table_builder',
            function (Container $container) {

                if ($this instanceof EntryInterface) {

                    $builder = $this->getBoundModelNamespace() . '\\Support\\DropboxFieldType\\LookupTableBuilder';

                    if (class_exists($builder)) {
                        return $container->make($builder);
                    }
                }

                return $container->make(LookupTableBuilder::class);
            }
        );

        $model->bind(
            'new_dropbox_field_type_value_table_builder',
            function (Container $container) {

                if ($this instanceof EntryInterface) {

                    $builder = $this->getBoundModelNamespace() . '\\Support\\DropboxFieldType\\ValueTableBuilder';

                    if (class_exists($builder)) {
                        return $container->make($builder);
                    }
                }

                return $container->make(ValueTableBuilder::class);
            }
        );

        $model->bind(
            'get_dropbox_field_type_options_handler',
            function () {

                if ($this instanceof EntryInterface) {

                    $handler = $this->getBoundModelNamespace() . '\\Support\\DropboxFieldType\\OptionsHandler';

                    if (class_exists($handler)) {
                        return $handler;
                    }
                }

                return Related::class;
            }
        );
    }

}