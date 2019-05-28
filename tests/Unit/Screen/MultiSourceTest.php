<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Tests\TestUnitCase;
use Orchid\Screen\AsMultiSource;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SourceTest.
 */
class MultiSourceTest extends TestUnitCase
{
    /**
     * @var Model
     */
    protected $model;

    protected function setUp(): void
    {
        $model = new class extends Model {
            use AsMultiSource;

            protected $fillable = [
                'content',
            ];

            protected $casts = [
                'options' => 'array',
            ];
        };

        $this->model = $model->fill([
            'content' => [
                'en' => [
                    'country' => [
                        'Russia',
                        'Ukraine',
                        'Spain',
                        'Egypt',
                        'Belorussia',
                        'Romania',
                        'Estonia',
                    ],
                ],
                'ru' => [
                    'country' => [
                        'Россия',
                        'Украина',
                        'Испания',
                        'Египет',
                        'Беларусь',
                        'Румыния',
                        'Эстония',
                    ],
                ],
            ],
        ]);
    }

    public function testMultiLanguageAttribute()
    {
        $this->assertContains('Russia', $this->model->getContent('country', 'en'));
        $this->assertContains('Россия', $this->model->getContent('country', 'ru'));
    }
}
