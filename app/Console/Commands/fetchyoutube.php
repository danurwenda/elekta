<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Youtube;

class fetchyoutube extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:youtube';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching youtube data';

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
        $params = [
            'q' => 'khofifah',
            'type' => 'video',
            'part' => 'id, snippet',
            'order' => 'date',
            'maxResults' => 50
        ];
        $search = Youtube::searchAdvanced($params, true);

        foreach ($search['results'] as $data) {
            $newdata = json_encode($data);
            $newdata = json_decode($newdata, TRUE);
            $newdata['snippet']['publishedAt'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($newdata['snippet']['publishedAt']));
            \DB::connection('mongodb')->collection('youtubekhofifah')->where('id', $newdata['id'])->update($newdata, ['upsert' => true]);
        }

        $params = [
            'q' => 'gus ipul',
            'type' => 'video',
            'part' => 'id, snippet',
            'order' => 'date',
            'maxResults' => 50
        ];
        $search = Youtube::searchAdvanced($params, true);

        foreach ($search['results'] as $data) {
            $newdata = json_encode($data);
            $newdata = json_decode($newdata, TRUE);
            $newdata['snippet']['publishedAt'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($newdata['snippet']['publishedAt']));
            \DB::connection('mongodb')->collection('youtubegusipul')->where('id', $newdata['id'])->update($newdata, ['upsert' => true]);
        }

        $params = [
            'q' => 'emil dardak',
            'type' => 'video',
            'part' => 'id, snippet',
            'order' => 'date',
            'maxResults' => 50
        ];
        $search = Youtube::searchAdvanced($params, true);

        foreach ($search['results'] as $data) {
            $newdata = json_encode($data);
            $newdata = json_decode($newdata, TRUE);
            $newdata['snippet']['publishedAt'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($newdata['snippet']['publishedAt']));
            \DB::connection('mongodb')->collection('youtubeemil')->where('id', $newdata['id'])->update($newdata, ['upsert' => true]);
        }

        $params = [
            'q' => 'puti soekarno',
            'type' => 'video',
            'part' => 'id, snippet',
            'order' => 'date',
            'maxResults' => 50
        ];
        $search = Youtube::searchAdvanced($params, true);

        foreach ($search['results'] as $data) {
            $newdata = json_encode($data);
            $newdata = json_decode($newdata, TRUE);
            $newdata['snippet']['publishedAt'] = new \MongoDB\BSON\UTCDateTime(1000*strtotime($newdata['snippet']['publishedAt']));
            \DB::connection('mongodb')->collection('youtubeputi')->where('id', $newdata['id'])->update($newdata, ['upsert' => true]);
        }

        $this->info('Success!');
    }

}
