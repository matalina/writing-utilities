<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utilities\WordUtility;
use Carbon\Carbon;

class ReportWordFrequency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:word-frequency {full_path_to_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a report of all word frequencies in a given document.';

    protected $utility;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WordUtility $utility)
    {
        parent::__construct();
        $this->utility = $utility;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->argument('full_path_to_file');

        $string = \File::get($path);

        $result = $this->utility->wordFrequency($string);

        $output = [];
        $string = 'Word,Count'.PHP_EOL;
        foreach($result as $word => $count) {
            $output[] = [$word, $count];
            $string .= $word.','.$count.PHP_EOL;
        }

        $filename = $this->getFilename($path);

        $this->table(['Word','Count'], $output);
        \File::put(
            storage_path('reports/'.$filename.'_'.Carbon::now()->format('YmdHis').'.csv'),
            $string
        );
    }

    private function getFilename($path) {
        $parts = explode('/',$path);
        $count = count($parts);

        $file = $parts[$count - 1];

        return (explode('.',$file))[0];
    }
}
