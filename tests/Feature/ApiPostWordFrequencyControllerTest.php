<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

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
            $response->assertStatus($data['status']);
            
            if($data['status'] !== 200) {
                $response->assertSessionHasErrors(['string','file']);
            }
        }
    }

     /**
     * @test
     */
    public function post_to_route_returns_expected_results()
    {
        $this->withoutExceptionHandling();

        $path = base_path('tests/stubs/test.txt');
        $content = \File::get(base_path('tests/stubs/test.txt'));

        \Storage::fake('local');

        $file = UploadedFile::fake('local')->createWithContent('my_test_file.txt', $content);

        $result = [
            ["a",6],
            ["warm",1],
            ["westerly",1],
            ["wind",1],
            ["tossed",1],
            ["brandon’s",1],
            ["dark",1],
            ["locks",1],
            ["hint",1],
            ["of",3],
            ["magic",1],
            ["and",4],
            ["smoke",1],
            ["where-no-fire-burned",1],
            ["floated",1],
            ["on",3],
            ["the",14],
            ["breeze",1],
            ["whispering",1],
            ["touched",1],
            ["in",4],
            ["womb",1],
            ["brandon",4],
            ["growled",1],
            ["bolted",1],
            ["out",2],
            ["his",3],
            ["purple",1],
            ["velvet",1],
            ["couch",1],
            ["penthouse",2],
            ["balcony",1],
            ["overlooking",1],
            ["tyrrhenian",1],
            ["sea",1],
            ["he",4],
            ["grabbed",2],
            ["black",2],
            ["iron",1],
            ["railing",1],
            ["knuckles",1],
            ["white",1],
            ["from",1],
            ["strain",1],
            ["stared",1],
            ["onto",1],
            ["open",1],
            ["water",1],
            ["somewhere",1],
            ["to",4],
            ["west",1],
            ["made",1],
            ["another",1],
            ["agent",1],
            ["child",1],
            ["yet",1],
            ["be",1],
            ["born",1],
            ["sticking",1],
            ["your",1],
            ["fingers",1],
            ["pie",1],
            ["again",1],
            ["i",2],
            ["will",1],
            ["see",1],
            ["that",1],
            ["said",1],
            ["heavy",1],
            ["italian",1],
            ["accented",1],
            ["english",1],
            ["aether",1],
            ["faster-than-human",1],
            ["whirl",1],
            ["strut",1],
            ["inside",1],
            ["modern",1],
            ["kept",1],
            ["ostia",1],
            ["an",1],
            ["old",1],
            ["1920s-replica",1],
            ["rotary",1],
            ["phone",1],
            ["sat",1],
            ["nightstand",1],
            ["perfectly",1],
            ["polished",1],
            ["handset",1],
            ["dialed",1],
            ["0",1],
            ["soft",1],
            ["hum",1],
            ["dial",1],
            ["ending",1],
            ["with",1],
            ["voice",1],
            ["how",1],
            ["many",1],
            ["help",1],
            ["you",1],
            ["mr",1],
            ["holt",1],
           //["" => 1],
        ];

        $knownDate = Carbon::create(2001, 5, 21, 12);
        Carbon::setTestNow($knownDate); 

        $response = $this->post(route('api.word-frequency.store', ['string' => $content]));
        $response->assertStatus(200);
        $response->assertJsonPath('data.a',6);
        $response->assertJsonPath('data.where-no-fire-burned',1);

        $response = $this->post(route('api.word-frequency.store', ['file' => $file]));
        $response->assertStatus(200);
        $response->assertJsonPath('data.a',6);
        $response->assertJsonPath('data.where-no-fire-burned',1);
    }
}
