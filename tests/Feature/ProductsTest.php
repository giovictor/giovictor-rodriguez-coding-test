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
                'total',
                'pageTotal',
                'noOfPages',
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
                'total',
                'pageTotal',
                'noOfPages',
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
        $product = Product::factory()->count(100)->create();

        $page = 'test1';
        $recordsPerPage = 'test2';

        $response = $this->get('/api/products?page='.$page.'&limit='.$recordsPerPage);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['page', 'limit']);
    }


    public function test_fetching_a_single_product_by_valid_id()
    {
        $product = Product::factory()->create([
            'name' => 'Product XYZ',
            'description' => 'Best Product Ever',
            'price' => 23.24
        ]);

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
        $product = Product::factory()->create([
            'name' => 'Product XYZ',
            'description' => 'Best Product Ever',
            'price' => 23.24
        ]);

        $invalidId = 'randomtestid';

        $response = $this->get('/api/products/'.$invalidId);

        $response->assertStatus(200)
        ->assertJson([
            'data' => null
        ]);
    }
}
