<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetching_products_without_pagination_query_params()
    {
        $product = Product::factory()->count(100)->create();

        // Records per page will have 10 records per page by default if no given query params are present
        $defaultRecordsPerPage = 10;

        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount($defaultRecordsPerPage, 'data')
            ->assertJsonStructure([
                'page',
                'limit',
                'noOfPages',
                'total',
                'pageTotal',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_fetching_products_with_valid_pagination_query_params()
    {
        $product = Product::factory()->count(100)->create();

        // Records per page should match the number of data returned in the 'data' array
        $page = 1;
        $recordsPerPage = 25;

        $response = $this->get('/api/products?page='.$page.'&limit='.$recordsPerPage);

        $response->assertStatus(200)
            ->assertJsonCount($recordsPerPage, 'data')
            ->assertJsonStructure([
                'page',
                'limit',
                'noOfPages',
                'total',
                'pageTotal',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_fetching_products_with_invalid_pagination_query_params()
    {
        $page = 'test1';
        $recordsPerPage = 'test2';

        $response = $this->get('/api/products?page='.$page.'&limit='.$recordsPerPage);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['page', 'limit']);
    }


    public function test_fetching_a_single_product_by_valid_id()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/products/'.$product->id);

        $response->assertStatus(200)
        ->assertJsonCount(1)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'price',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_fetching_a_single_product_by_invalid_id()
    {
        $invalidId = 'randomtestid';

        $response = $this->get('/api/products/'.$invalidId);

        $response->assertStatus(404)
            ->assertJsonPath('message', 'Product was not found.');
    }

    public function test_creating_a_product_with_valid_data()
    {
        $data = [
            'name' => 'Product ABC',
            'description' => 'Best product ever.',
            'price' => 123.45
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'Product was created successfully.')
            ->assertJsonStructure([
                'message',
                'data' => [
                    'name',
                    'description',
                    'price',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    public function test_creating_a_product_with_invalid_data()
    {
        $data = [
            'name' => '',
            'description' => '',
            'price' => '123abc'
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'description', 'price']);
    }

    public function test_updating_a_product_with_valid_data()
    {
        $product = Product::factory()->create([
            'name' => 'Product ABC',
            'description' => 'Best product ever.',
            'price' => 123.45
        ]);

        $data = [
            'name' => 'Product XYZ',
            'description' => 'The real best product ever.',
            'price' => 678.90
        ];

        $response = $this->patchJson('/api/products/'.$product->id, $data);

        $response->assertStatus(200)
        ->assertJsonPath('message', 'Product was updated successfully.')
        ->assertJsonStructure([
            'message',
            'data' => [
                'name',
                'description',
                'price',
                'updated_at',
                'created_at',
                'id'
            ]
        ]);
    }

    public function test_updating_a_product_with_invalid_data()
    {
        $product = Product::factory()->create([
            'name' => 'Product ABC',
            'description' => 'Best product ever.',
            'price' => 123.45
        ]);

        $data = [
            'name' => '',
            'description' => '',
            'price' => 'testprice'
        ];

        $response = $this->patchJson('/api/products/'.$product->id, $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'description', 'price']);
    }

    public function test_updating_a_product_with_invalid_id()
    {
        $data = [
            'name' => 'Product XYZ',
            'description' => 'The real best product ever.',
            'price' => 678.90
        ];

        $invalidId = 'randomtestid';

        $response = $this->patchJson('/api/products/'.$invalidId, $data);

        $response->assertStatus(404)
            ->assertJsonPath('message', 'Product was not found.');
    }

    public function test_deleting_a_product_with_valid_id()
    {
        $product = Product::factory()->create([
            'name' => 'Product ABC',
            'description' => 'Best product ever.',
            'price' => 123.45
        ]);

        $response = $this->deleteJson('/api/products/'.$product->id);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Product was successfully deleted.');
    }

    public function test_deleting_a_product_with_invalid_id()
    {
        $invalidId = 'randomtestid';

        $response = $this->deleteJson('/api/products/'.$invalidId);

        $response->assertStatus(404)
            ->assertJsonPath('message', 'Product was not found.');
    }
}
