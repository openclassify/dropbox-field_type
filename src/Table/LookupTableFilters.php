<?php namespace Visiosoft\DropboxFieldType\Table;

class LookupTableFilters
{

    /**
     * Handle the command.
     *
     * @param LookupTableBuilder $builder
     */
    public function handle(LookupTableBuilder $builder)
    {
        $stream = $builder->getTableStream();
        $filter = $stream->getTitleColumn();

        if ($filter == 'id') {
            $builder->setFilters([]);

            return;
        }

        $builder->setFilters(
            [
                'search' => [
                    'fields' => [
                        $filter,
                    ],
                ],
            ]
        );
    }
}
