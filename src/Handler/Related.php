<?php namespace Visiosoft\DropboxFieldType\Handler;

use Visiosoft\DropboxFieldType\DropboxFieldType;
use Anomaly\Streams\Platform\Support\Value;
use Visiosoft\PackagesModule\PackageEntry\Contract\PackageEntryRepositoryInterface;

/**
 * Class Related
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 */
class Related
{

    private $packageEntryRepository;

    public function __construct(PackageEntryRepositoryInterface $packageEntryRepository)
    {
        $this->packageEntryRepository = $packageEntryRepository;
    }

    /**
     * Handle the options.
     *
     * @param  DropboxFieldType $fieldType
     * @param Value $value
     * @return array
     */
    public function handle(DropboxFieldType $fieldType, Value $value)
    {
        $model = $fieldType->getRelatedModel();

        $query   = $model->newQuery()
        ->where('parent_category_id',NULL);//Main Categories
        $results = $query->orderBy('id')->get();

        try {

            /**
             * Try and use a non-parsing pattern.
             */
            if (strpos($fieldType->config('title_name', $model->getTitleName()), '{') === false) {
                $categories = $results->pluck(
                    $fieldType->config('title_name', $model->getTitleName()),
                    $fieldType->config('key_name', $model->getKeyName())
                )->all();
                $packageEntries = $this->packageEntryRepository->newQuery()
                    ->whereIn('cat_id', array_keys($categories))->where('package_id', $fieldType->getEntry()->id)
                    ->orderBy('cat_id')->get()->keyBy('cat_id');
                $options = array();
                foreach ($categories as $id => $category) {
                    $options[$id] = [
                        'name' => $category,
                        'ad_limit' => $packageEntries[$id]->ad_limit,
                        'time_limit' => $packageEntries[$id]->time_limit,
                        'commission' => $packageEntries[$id]->commission,
                    ];
                }
                $fieldType->setOptions($options);
            }

            /**
             * Try and use a parsing pattern.
             */
            if (strpos($fieldType->config('title_name', $model->getTitleName()), '{') !== false) {
                $fieldType->setOptions(
                    array_combine(
                        $results->map(
                            function ($item) use ($fieldType, $model) {
                                return data_get($item, $fieldType->config('key_name', $model->getKeyName()));
                            }
                        )->all(),
                        $results->map(
                            function ($item) use ($fieldType, $model, $value) {
                                return $value->make($fieldType->config('title_name', $model->getTitleName()), $item);
                            }
                        )->all()
                    )
                );
            }
        } catch (\Exception $e) {
            $fieldType->setOptions(
                $results->pluck(
                    $model->getTitleName(),
                    $model->getKeyName()
                )->all()
            );
        }
    }
}
