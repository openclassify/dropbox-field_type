<?php namespace Visiosoft\DropboxFieldType\Table;

class LookupTableButtons
{

    /**
     * Handle the command.
     *
     * @param LookupTableBuilder $builder
     */
    public function handle(LookupTableBuilder $builder)
    {
        $builder->setButtons(
            [
                'select' => [
                    'data-entry' => 'entry.id',
                    'data-key'   => $builder->config('key'),
                ],
            ]
        );
    }
}
