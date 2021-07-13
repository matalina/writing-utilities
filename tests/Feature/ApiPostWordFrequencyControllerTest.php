<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ApiPostWordFrequencyControllerTest extends TestCase
{
    /**
     * @test
     */
    public function route_exists()
    {
        $this->withoutExceptionHandling();

        $data = ['string' => 'test'];
        $response = $this->post(route('api.word-frequency.store', $data));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function string_or_file_passed_to_route_not_both()
    {        
        $path = base_path('tests/stubs/test.txt');
        $content = \File::get(base_path('tests/stubs/test.txt'));

        \Storage::fake('local');

        $file = UploadedFile::fake()->createWithContent('my_test_file.txt', $content);

        $test_data = [
            ['data' => ['string' => $content], 'status' => 200],
            ['data' => ['file' => $file], 'status' => 200],
            ['data' => ['string' => $content, 'file' => $file], 'status' => 302],
        ];
        
        foreach($test_data as $data) {
            $response = $this->post(route('api.word-frequency.store', $data['data']));
dump($response->dump());
            $response->assertStatus($data['status']);
            
            if($data['status'] !== 200) {
                $response->assertSessionHasErrors(['string','file']);
            }
        }
    }

    /**
     * @test
     */
    public function string_passed_to_route_is_valid_string()
    {        
        $path = base_path('tests/stubs/test.txt');
        $content = \File::get(base_path('tests/stubs/test.txt'));
        $data = ['string' => $content];
        
        $response = $this->post(route('api.word-frequency.store', $data));

        $response->assertStatus(200);
    
    }

    /**
     * @test
     */
    public function file_passed_to_route_is_valid_file_type()
    {        
        $path = base_path('tests/stubs/test.txt');
        $content = \File::get(base_path('tests/stubs/test.txt'));
        $data = ['file' => $content];
        
        $response = $this->post(route('api.word-frequency.store', $data));

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['file']);
    
    }
}
