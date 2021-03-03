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
    protected $signature = 'get:token {app_type} {app_name} {app_domain} {app_ip_server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Get API token sample: get:token app_name app_domain app_ip_server';

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
        $curl->post('http://api.dzc.my.id/client', array(
            'app_type' =>  $this->argument('app_type'),
            'app_name' =>  $this->argument('app_name'),
            'app_domain' =>  $this->argument('app_domain'),
            'app_ip_server' =>  $this->argument('app_ip_server'),
        ));

        if ($curl->error) {
            echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
            die;
        } else {
        }
        $res =  $curl->response;

        # code...
        $key = $res->msg;

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
