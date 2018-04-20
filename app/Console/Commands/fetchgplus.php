<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class fetchgplus extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:gplus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Gplus';

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
        $client = new \Google_Client();
        $client->setApplicationName("My Application");
        $client->setDeveloperKey("AIzaSyCKFVgc164K3mXFGjY2A1z6rVMnHvRVtzA");


        $plus = new \Google_Service_Plus($client);
        $params = array(
            'orderBy' => 'recent',
            'maxResults' => '20',
            'language' => 'id'
        );

        $json = $plus->activities->search('khofifah', $params);
        $json = json_encode($json['items']);
        $json = json_decode($json, TRUE);

        foreach ($json as $data) {
            $data['updated'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['updated']));
            $data['published'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['published']));
            \DB::connection('mongodb')->collection('gpluskhofifah')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $json = $plus->activities->search('gus ipul', $params);
        $json = json_encode($json['items']);
        $json = json_decode($json, TRUE);
        foreach ($json as $data) {
            $data['updated'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['updated']));
            $data['published'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['published']));
            \DB::connection('mongodb')->collection('gplusgusipul')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $json = $plus->activities->search('emil dardak', $params);
        $json = json_encode($json['items']);
        $json = json_decode($json, TRUE);
        foreach ($json as $data) {
            $data['updated'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['updated']));
            $data['published'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['published']));
            \DB::connection('mongodb')->collection('gplusemil')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $json = $plus->activities->search('puti soekarno', $params);
        $json = json_encode($json['items']);
        $json = json_decode($json, TRUE);
        foreach ($json as $data) {
            $data['updated'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['updated']));
            $data['published'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($data['published']));
            \DB::connection('mongodb')->collection('gplusputi')->where('id', $data['id'])->update($data, ['upsert' => true]);
        }

        $this->info('Success!');
    }

}
