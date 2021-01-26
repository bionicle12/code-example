<?php
/**
 * Class HMenuTest
 * @package Tests\Feature
 * @date: 05.11.2020
 */

namespace Tests\Feature;


use App\Models\User;
use Domain\Locale\Model\LocaleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HMenuTest extends BaseTestCase
{
    use RefreshDatabase;

    public function testIndexReturnSuccess()
    {
        $this->initUser();

        $response = $this->getJson('/api/hmenu');
        $response->assertStatus(200);
    }

    public function testListReturnSuccess()
    {
        $this->initUser();

        $response = $this->getJson('/api/hmenu/list');
        $response->assertStatus(200);
    }

    public function testStoreReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'title' => 'Title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ];

        $response = $this->postJson('/api/hmenu', $data);
        $response->assertStatus(200);
    }

    public function testStoreReturn404OnEmptyData()
    {
        $this->initUser();

        $response = $this->postJson('/api/hmenu');

        $response->assertStatus(222);

        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('title', $errors);
        $this->assertArrayHasKey('locale_id', $errors);
    }

    public function testStoreLocaleNotFound()
    {
        $this->initUser();

        $data = [
            'title' => 'Title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => 555,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ];

        $response = $this->postJson('/api/hmenu', $data);
        $response->assertStatus(404);
    }

    public function testIndexReturnAllData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $this->post('/api/hmenu', [
            'title' => 'Title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ]);

        $this->postJson('/api/hmenu', [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ]);

        $response = $this->getJson('/api/hmenu');
        $data = $response->json()['data'];

        $this->assertArrayHasKey('last_page', $response->json());
        $this->assertArrayHasKey('title', $data[0]);
        $this->assertArrayHasKey('status', $data[0]);
        $this->assertArrayHasKey('sort_order', $data[0]);
        $this->assertArrayHasKey('url', $data[0]);
        $this->assertArrayHasKey('locale', $data[0]);
        $this->assertEquals('Title', $data[0]['title']);
    }

    public function testEditReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $postResponse = $this->postJson('/api/hmenu', [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ]);

        $response = $this->get('/api/hmenu/' . $postResponse->getContent());
        $response->assertStatus(200);
    }

    public function testEditReturnNotFound()
    {
        $this->initUser();

        $response = $this->getJson('/api/hmenu/' . 5555);
        $response->assertStatus(404);
    }

    public function testEditReturnExpectedData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ];
        $postResponse = $this->postJson('/api/hmenu', $data);

        $response = $this->getJson('/api/hmenu/' . $postResponse->getContent());
        $this->assertEquals($data['title'], $response->decodeResponseJson()['title']);
    }

    public function testUpdateReturn404OnEmptyRequest()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $postResponse = $this->postJson('/api/hmenu', [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ]);

        $response = $this->patchJson('/api/hmenu/' . $postResponse->getContent());

        $errors = $response->decodeResponseJson()['errors'];

        $this->assertArrayHasKey('title', $errors);
        $this->assertArrayHasKey('locale_id', $errors);
    }

    public function testUpdateReturnCorrectData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $initData = [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ];
        $postResponse = $this->postJson('/api/hmenu', $initData);

        $newData = [
            'title' => 'new tmp title',
            'locale_id' => $locale->id
        ];
        $response = $this->patchJson('/api/hmenu/' . $postResponse->getContent(), $newData);
        $this->assertEquals($newData['title'], $response->decodeResponseJson()['title']);
        $this->assertEquals($initData['status'], $response->decodeResponseJson()['status']);
    }

    public function testUpdateReturnNotFound()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $newData = [
            'title' => 'new tmp title',
            'locale_id' => $locale->id
        ];

        $response = $this->patchJson('/api/hmenu/' . 5555, $newData);
        $response->assertStatus(404);
    }

    public function testDestroyReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $initData = [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ];
        $postResponse = $this->postJson('/api/hmenu', $initData);

        $response = $this->deleteJson('/api/hmenu/' . $postResponse->getContent());
        $response->assertStatus(200);
    }

    public function testDestroyReturn404OnEmptyId()
    {
        $this->initUser();

        $responseCategory = $this->deleteJson('/api/hmenu/' . 5555);
        $responseCategory->assertStatus(404);
    }

    public function testGetDestroyedItemReturn404()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $initData = [
            'title' => 'Big title',
            'url' => '/tmp',
            'status' => 1,
            'locale_id' => $locale->id,
            'parent_id' => 0,
            'sort_order' => 0,
            'class' => ''
        ];
        $postResponse = $this->postJson('/api/hmenu', $initData);

        $resp = $this->deleteJson('/api/hmenu/' . $postResponse->getContent());

        $response = $this->getJson('/api/hmenu/' . $postResponse->getContent());
        $response->assertStatus(404);
    }
}
