<?php

return [
    'related'    => [
        'label' => 'İlgili Akış',
    ],
    'mode'       => [
        'label'  => 'Giriş modu',
        'option' => [
            'dropdown' => 'Yıkılmak',
            'lookup'   => 'Yukarı Bak',
            'search'   => 'Arama',
        ],
    ],
    'title_name' => [
        'label'        => 'Başlık Alanı',
        'placeholder'  => 'İsim',
        'instructions' => 'Belirtin <strong>slug</strong> Açılır menü / arama seçenekleri için gösterilecek alanın listesi.<br>
Gibi ayrıştırılabilir başlıkları belirleyebilirsiniz <strong>{entry.first_name} {entry.last_name}</strong><br>İlgili akışın başlık sütunu varsayılan olarak kullanılacaktır.',
    ],
];
