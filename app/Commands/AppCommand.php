<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AppCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'Read';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Read latest Techpoint headlines right from your terminal -by Adams Paul';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rss_url = 'https://techpoint.ng/rss';
        $api_endpoint = 'https://api.rss2json.com/v1/api.json?rss_url=';

        $data = json_decode( file_get_contents($api_endpoint . urlencode($rss_url)) , true );
        // Parses the response and build a table.
        $this->info("Hello Techie! Trending In Tech:");
        $bar = $this->output->createProgressBar(count($data['items']));

        foreach ($data['items'] as $item) {
            $this->newLine();
            echo "{$item['title']}";
            $this->newLine();

        }
        $headers = ['Name', 'Email'];

        $users = App\Models\User::all(['name', 'email'])->toArray();

        $this->table($headers, $users);

        // Notify the user on the Operating System that the weather arrived.
        $this->notify('News Alert!', 'Techpoint News just arrived!', 'icon.png');
    }



}
