<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Curl\Curl;

class getapi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Get API token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $curl = new Curl();
        $curl->post('http://service-jbap.test/tes.php', array(
            'app_type' => 'WEB',
            'app_name' => 'TEST',
            'app_domain' => "xx.domain",
            'app_ip_server' => '127.0.0.1',
        ));

        if ($curl->error) {
            echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
            die;
        } else {

            $key = $curl->response;
        }

        if (file_exists($envFilePath = $this->getPathToEnvFile()) === false) {
            $this->info("Could not find env file! Key: $key");
        }

        if ($this->updateEnvFile($envFilePath, $key)) {
            $this->info("Token Tersimpan Dengan Key: $key");
        }
    }
    private function getPathToEnvFile()
    {
        return base_path('.env');
    }

    private function updateEnvFile($path, $key)
    {
        if (file_exists($path)) {

            $oldContent = file_get_contents($path);
            $search = 'API_TES=' . env('API_TES');

            if (!str_contains($oldContent, $search)) {
                $search = 'API_TES=';
            }

            $newContent = str_replace($search, 'API_TES=' . $key, $oldContent);

            return file_put_contents($path, $newContent);
        }

        return false;
    }
}
