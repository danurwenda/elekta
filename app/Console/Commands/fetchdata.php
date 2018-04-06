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
        //
        $url = 'https://www.google.com/alerts/feeds/17433293890439964009/8778119014002706904'; //khof
        $xml_string = file_get_contents($url);
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json, TRUE);
        foreach ($json['entry'] as $data) {
            $media = str_after($data['link']['@attributes']['href'], 'https://www.google.com/url?rct=j&sa=t&url=');
            $media = str_after($media, '://');
            $media = str_before($media, '/');
            $data['media'] = $media;
            \DB::connection('mongodb')->collection('khofifah')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $url = 'https://www.google.com/alerts/feeds/17433293890439964009/14634290886364729844'; //ipul
        $xml_string = file_get_contents($url);
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json, TRUE);
        foreach ($json['entry'] as $data) {
            $media = str_after($data['link']['@attributes']['href'], 'https://www.google.com/url?rct=j&sa=t&url=');
            $media = str_after($media, '://');
            $media = str_before($media, '/');
            $data['media'] = $media;
            \DB::connection('mongodb')->collection('gusipul')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $url = 'https://www.google.com/alerts/feeds/00126744657586499831/9896309034371372850'; //emil
        $xml_string = file_get_contents($url);
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json, TRUE);
        foreach ($json['entry'] as $data) {
            $media = str_after($data['link']['@attributes']['href'], 'https://www.google.com/url?rct=j&sa=t&url=');
            $media = str_after($media, '://');
            $media = str_before($media, '/');
            $data['media'] = $media;
            \DB::connection('mongodb')->collection('emil')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $url = 'https://www.google.com/alerts/feeds/00126744657586499831/16017706715267162769'; //puti
        $xml_string = file_get_contents($url);
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json, TRUE);
        foreach ($json['entry'] as $data) {
            $media = str_after($data['link']['@attributes']['href'], 'https://www.google.com/url?rct=j&sa=t&url=');
            $media = str_after($media, '://');
            $media = str_before($media, '/');
            $data['media'] = $media;
            \DB::connection('mongodb')->collection('puti')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }
        $this->info('Success!');
    }

}
