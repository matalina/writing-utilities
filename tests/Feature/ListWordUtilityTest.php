<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Utilities\WordUtility;

class ListWordUtilityTest extends TestCase
{
    /**
     * @test
     */
    public function strip_punctuation_returns_correct_string()
    {
        $string = 'This is a test sentence. And this is a second sentence.';

        $result = 'This is a test sentence And this is a second sentence';

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function to_lowercase_return_correct_string()
    {
        $string = 'This is a test sentence. And this is a second sentence.';

        $result = 'this is a test sentence. and this is a second sentence.';

        $utility = new WordUtility();
        $test =  $utility->stringToLowerCase($string);


        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function simple_sentence_returns_array_of_words_used_and_counts()
    {
        $string = 'This is a test sentence. And this is a second sentence.';

        $result = [
            'this' => 2,
            'is' => 2,
            'a' => 2,
            'test' => 1,
            'sentence' => 2,
            'and' => 1,
            'second' => 1,
        ];

        $utility = new WordUtility();
        $test =  $utility->wordFrequency($string);

        $this->assertEqualsCanonicalizing($result,$test);
        $this->assertEqualsCanonicalizing(array_keys($result), array_keys($test));

        foreach($test as $word =>$count) {
            $this->assertEquals($result[$word], $count);
        }

        foreach($result as $word =>$count) {
            $this->assertEquals($count, $test[$word]);
        }
    }

    /**
     * @test
     */
    public function contractions_are_not_stripped()
    {
        $string = "Please don't strip my apostrophey.";

        $result = "Please don't strip my apostrophey";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function single_quotes_around_words_are_stripped()
    {
        $string = "Please don't strip 'my' apostrophey.";

        $result = "Please don't strip my apostrophey";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function hypenated_words_are_not_stripped()
    {
        $string = "Please do not strip handy-man.";

        $result = "Please do not strip handy-man";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function double_dash_alone_is_stripped()
    {
        $string = "Please do not strip handy-man -- is okay though.";

        $result = "Please do not strip handy-man is okay though";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function single_dash_alone_is_stripped()
    {
        $string = "Please do not strip handy-man - is okay though.";

        $result = "Please do not strip handy-man is okay though";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function three_periods_at_end_of_line_is_stripped()
    {
        $string = "And we wait...";

        $result = "And we wait";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function quote_at_beginning_of_line_is_stripped()
    {
        $string = '"And we wait."';

        $result = "And we wait";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }


    /**
     * @test
     */
    public function multiline_strings_return_correct_stripped_string()
    {
        $string = "I am a sentence.\nI am a second line.\nAnd I'm a third.";

        $result = "I am a sentence\nI am a second line\nAnd I'm a third";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function quote_at_beginning_of_second_line_is_stripped()
    {
        $string = "I am a sentence.\n'I am a second line.'\nAnd I'm a third.";

        $result = "I am a sentence\nI am a second line\nAnd I'm a third";

        $utility = new WordUtility();
        $test =  $utility->stripPunctuation($string);

        $this->assertEquals($result, $test);
    }

    /**
     * @test
     */
    public function complex_multiline_string_returns_array_of_words_used_and_counts()
    {
        $string = \File::get(base_path('tests/stubs/test.txt'));

        $result = [
            "a" => 6,
            "warm" => 1,
            "westerly" => 1,
            "wind" => 1,
            "tossed" => 1,
            "brandon’s" => 1,
            "dark" => 1,
            "locks" => 1,
            "hint" => 1,
            "of" => 3,
            "magic" => 1,
            "and" => 4,
            "smoke" => 1,
            "where-no-fire-burned" => 1,
            "floated" => 1,
            "on" => 3,
            "the" => 14,
            "breeze" => 1,
            "whispering" => 1,
            "touched" => 1,
            "in" => 4,
            "womb" => 1,
            "brandon" => 4,
            "growled" => 1,
            "bolted" => 1,
            "out" => 2,
            "his" => 3,
            "purple" => 1,
            "velvet" => 1,
            "couch" => 1,
            "penthouse" => 2,
            "balcony" => 1,
            "overlooking" => 1,
            "tyrrhenian" => 1,
            "sea" => 1,
            "he" => 4,
            "grabbed" => 2,
            "black" => 2,
            "iron" => 1,
            "railing" => 1,
            "knuckles" => 1,
            "white" => 1,
            "from" => 1,
            "strain" => 1,
            "stared" => 1,
            "onto" => 1,
            "open" => 1,
            "water" => 1,
            "somewhere" => 1,
            "to" => 4,
            "west" => 1,
            "made" => 1,
            "another" => 1,
            "agent" => 1,
            "child" => 1,
            "yet" => 1,
            "be" => 1,
            "born" => 1,
            "sticking" => 1,
            "your" => 1,
            "fingers" => 1,
            "pie" => 1,
            "again" => 1,
            "i" => 2,
            "will" => 1,
            "see" => 1,
            "that" => 1,
            "said" => 1,
            "heavy" => 1,
            "italian" => 1,
            "accented" => 1,
            "english" => 1,
            "aether" => 1,
            "faster-than-human" => 1,
            "whirl" => 1,
            "strut" => 1,
            "inside" => 1,
            "modern" => 1,
            "kept" => 1,
            "ostia" => 1,
            "an" => 1,
            "old" => 1,
            "1920s-replica" => 1,
            "rotary" => 1,
            "phone" => 1,
            "sat" => 1,
            "nightstand" => 1,
            "perfectly" => 1,
            "polished" => 1,
            "handset" => 1,
            "dialed" => 1,
            "0" => 1,
            "soft" => 1,
            "hum" => 1,
            "dial" => 1,
            "ending" => 1,
            "with" => 1,
            "voice" => 1,
            "how" => 1,
            "many" => 1,
            "help" => 1,
            "you" => 1,
            "mr" => 1,
            "holt" => 1,
            "" => 1,
        ];

        $utility = new WordUtility();
        $test =  $utility->wordFrequency($string);

        $this->assertEqualsCanonicalizing($result,$test);
        $this->assertEqualsCanonicalizing(array_keys($result), array_keys($test));

        foreach($test as $word =>$count) {
            $this->assertEquals($result[$word], $count);
        }

        foreach($result as $word =>$count) {
            $this->assertEquals($count, $test[$word]);
        }
    }
}
