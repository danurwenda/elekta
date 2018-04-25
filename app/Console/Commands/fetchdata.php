<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class fetchdata extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:galert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Galert fetching data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        foreach (config('galert.objects') as $p => $url) {
            $xml_string = file_get_contents($url);
            $xml = simplexml_load_string($xml_string);
            $json = json_encode($xml);
            $json = json_decode($json, TRUE);
            foreach ($json['entry'] as $data) {
                $media = str_after($data['link']['@attributes']['href'], 'https://www.google.com/url?rct=j&sa=t&url=');
                $media = str_after($media, '://');
                $media = str_before($media, '/');
                $data['media'] = $media;
                $data['published']=new \MongoDB\BSON\UTCDateTime(1000* strtotime($data['published']));
                $data['updated']=new \MongoDB\BSON\UTCDateTime(1000* strtotime($data['updated']));
                \DB::connection('mongodb')->collection('galert' . $p)->where('id', $data['id'])->update($data, ['upsert' => true]);
            }
        }
        $this->info('Success!');
    }

}
