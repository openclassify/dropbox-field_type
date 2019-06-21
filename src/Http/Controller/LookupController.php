<?php namespace Visiosoft\DropboxFieldType\Http\Controller;

use Visiosoft\DropboxFieldType\Command\GetConfiguration;
use Visiosoft\DropboxFieldType\Command\HydrateValueTable;
use Visiosoft\DropboxFieldType\Table\LookupTableBuilder;
use Visiosoft\DropboxFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class LookupController
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 * @package       Anomaly\RelationshipFieldType\Http\Controller
 */
class LookupController extends AdminController
{

    /**
     * Return an index of entries from related stream.
     *
     * @param Container $container
     * @param           $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Container $container, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $related = $container->make($config->get('related'));

        if ($table = $config->get('lookup_table')) {
            $table = $container->make($table);
        } else {
            $table = $related->newDropboxFieldTypeLookupTableBuilder();
        }

        /* @var LookupTableBuilder $table */
        $table->setConfig($config)
            ->setModel($related);

        return $table->render();
    }

    /**
     * Return the selected entries.
     *
     * @param Container $container
     * @param           $key
     * @return null|string
     */
    public function selected(Container $container, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $related = $container->make($config->get('related'));

        if ($table = $config->get('value_table')) {
            $table = $container->make($table);
        } else {
            $table = $related->newDropboxFieldTypeValueTableBuilder();
        }

        /* @var ValueTableBuilder $table */
        $table->setSelected($this->request->get('uploaded'))
            ->setConfig($config)
            ->setModel($related)
            ->build()
            ->load();

        return $table->getTableContent();
    }
}
