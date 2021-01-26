<?php

namespace Tests\Feature;

use App\Models\User;
use Domain\Locale\Model\LocaleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class LocaleTest
 * @package Tests\Feature
 * @date: 03.11.2020
 */
class LocaleTest extends BaseTestCase
{
    use RefreshDatabase;

    public function testIndexReturnSuccess()
    {
        $this->initUser();

        $response = $this->getJson('/api/locales');
        $response->assertStatus(200);
    }

    public function testActiveReturnSuccess()
    {
        $this->initUser();

        $response = $this->getJson('/api/locales/active');
        $response->assertStatus(200);
    }

    public function testActiveReturnActive()
    {
        $this->initUser();

        $this->post('/api/locales', [
            'title' => 'Kazakh',
            'status' => 0,
            'code' => 'kz',
        ]);
        $response = $this->getJson('/api/locales/active')->json();

        foreach ($response as $data) {
            $this->assertEquals(1, $data['status']);
        }
        $this->assertEquals(2, count($response));
    }

    public function testStoreReturnSuccess()
    {
        $this->initUser();

        $response = $this->postJson('/api/locales', [
            'title' => 'Francais',
            'status' => 1,
            'code' => 'fr',
        ]);

        $response->assertStatus(200);
    }

    public function testStoreFailOnEmptyRequest()
    {
        $this->initUser();

        $response = $this->postJson('/api/locales');
        $response->assertStatus(222);

        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('title', $errors);
        $this->assertArrayHasKey('code', $errors);
    }

    public function testStoreFailOnNotUniqueCode()
    {
        $this->initUser();

        $response = $this->postJson('/api/locales', [
            'title' => 'English',
            'status' => 1,
            'code' => 'en',
        ]);

        $response->assertStatus(222);
        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('code', $errors);
    }

    public function testStoreFailOnCodeLongerThan3Symbols()
    {
        $this->initUser();

        $response = $this->postJson('/api/locales', [
            'title' => 'English',
            'status' => 1,
            'code' => 'enenene',
        ]);

        $response->assertStatus(222);
        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('code', $errors);
    }

    public function testUpdateReturn404OnEmptyRequest()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $response = $this->patchJson('/api/locales/' . $locale->id);

        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('title', $errors);
        $this->assertArrayHasKey('code', $errors);
    }

    public function testUpdateReturnCorrectData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $newData = [
            'title' => 'British',
            'code' => $locale->code,
            'status' => $locale->status
        ];
        $response = $this->patchJson('/api/locales/' . $locale->id, $newData);
        $this->assertEquals($newData['title'], $response->decodeResponseJson()['title']);
        $this->assertEquals($locale->code, $response->decodeResponseJson()['code']);
    }

    public function testUpdateReturnNotFoundOnNonExistsId()
    {
        $this->initUser();

        $newData = [
            'title' => 'new tmp title',
            'code' => 'dd'
        ];

        $response = $this->patchJson('/api/locales/' . 5555, $newData);

        $response->assertStatus(404);
    }

    public function testEditReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $response = $this->getJson('/api/locales/' . $locale->id);
        $response->assertStatus(200);
    }

    public function testEditFailOnNotExistsId()
    {
        $this->initUser();

        $response = $this->getJson('/api/locales/' . 555);
        $response->assertStatus(404);
    }
}
