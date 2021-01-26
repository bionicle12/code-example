<?php
/**
 * Class PageTest
 * @date: 05.11.2020
 */

namespace Tests\Feature;

use App\Models\User;
use Domain\Locale\Model\LocaleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends BaseTestCase
{
    use RefreshDatabase;

    private $userId;

    public function testIndexReturnSuccess()
    {
        $this->initUser();

        $response = $this->getJson('/api/pages');
        $response->assertStatus(200);
    }

    public function testIndexReturnAllData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page1',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $this->postJson('/api/pages',$data);

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];
        $this->post('/api/pages', $data);

        $response = $this->getJson('/api/pages');

        $data = $response->json();

        $this->assertArrayHasKey('slug', $data[0]);
        $this->assertArrayHasKey('category', $data[0]);
        $this->assertEquals('Page1', $data[0]['title']);
    }

    public function testStoreReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $response = $this->postJson('/api/pages',$data);

        $response->assertStatus(200);
    }

    public function testStoreReturn222OnEmptyData()
    {
        $this->initUser();

        $response = $this->postJson('/api/pages');
        $response->assertStatus(222);

        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('slug', $errors);
        $this->assertArrayHasKey('data.1.title', $errors);
    }

    public function testStoreReturn222OnExistingSlug()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'slug',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $response = $this->postJson('/api/pages',$data);

        $data = [
            'slug' => 'slug',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $response = $this->postJson('/api/pages',$data);
        $response->assertStatus(222);
        $this->assertArrayHasKey('slug', $response->json()['errors']);
    }

    public function testEditReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $postResponse = $this->postJson('/api/pages', $data)->json();

        $response = $this->getJson('/api/pages/' . $postResponse['id']);
        $response->assertStatus(200);
    }

    public function testEditReturnNotFound()
    {
        $this->initUser();

        $response = $this->getJson('/api/pages/' . 5555);
        $response->assertStatus(404);
    }

    public function testEditReturnExpectedData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $postResponse = $this->postJson('/api/pages', $data)->json();

        $response = $this->getJson('/api/pages/' . $postResponse['id']);
        $this->assertEquals($data['slug'], $response->decodeResponseJson()['slug']);
    }

    public function testUpdateReturn404OnEmptyRequest()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $postResponse = $this->postJson('/api/pages', $data)->json();

        $response = $this->patchJson('/api/pages/' . (int)$postResponse['id']);

        $errors = $response->decodeResponseJson()['errors'];
        $this->assertArrayHasKey('slug', $errors);
        $this->assertArrayHasKey('data.1.title', $errors);
    }

    public function testUpdateReturnCorrectData()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                    'status' => 1
                ]
            ]
        ];

        $postResponse = $this->postJson('/api/pages', $data)->json();

        $newData = [
            'slug' => 'New Page2',
            'category' => 'pages',
            'data' => [
                $locale->id => [
                    'title' => 'Page2',
                ]
            ]
        ];
        $response = $this->patchJson('/api/pages/' . (int)$postResponse['id'], $newData);
        $response->assertStatus(200);
    }

    public function testUpdateReturnNotFound()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $newData = [
            'slug' => 'New Page2',
            'category' => 'pages',
            'data' => [
                $locale->id => [
                    'title' => 'Page1',
                ]
            ]
        ];

        $response = $this->patchJson('/api/pages/' . 5555, $newData);
        $response->assertStatus(404);
    }

    public function testDestroyReturnSuccess()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page2',
                ]
            ]
        ];

        $postResponse = $this->postJson('/api/pages', $data);

        $response = $this->deleteJson('/api/pages/' . (int)$postResponse->json()['id']);
        $response->assertStatus(200);
    }

    public function testDestroyReturn404OnEmptyId()
    {
        $this->initUser();

        $responseCategory = $this->deleteJson('/api/pages/' . 5555);
        $responseCategory->assertStatus(404);
    }

    public function testGetDestroyedPageReturn404()
    {
        $this->initUser();

        $locale = LocaleModel::where('code', 'en')->first();

        $data = [
            'slug' => 'page2',
            'user_id' => $this->userId,
            'category' => '/',
            'data' => [
                $locale->id => [
                    'title' => 'Page2',
                ]
            ]
        ];

        $postResponse = $this->postJson('/api/pages', $data);

        $responsePage = $this->deleteJson('/api/pages/' . $postResponse->json()['id']);

        $response = $this->getJson('/api/pages/' . $postResponse->json()['id']);
        $response->assertStatus(404);
    }
}
