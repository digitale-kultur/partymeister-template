<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;

class ReleaseImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partymeister:competitions:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import releases from .csv';

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
        $filename = $this->argument('file');
        if (!file_exists($filename)) {
            $this->error('Unable to find file');
            return 1;
        }

        $fp = fopen($filename, "r");
        fgetcsv($fp, 1000, ",");
        while ($data = fgetcsv($fp, 1000, ",")) {
            $this->info('Importing: ' . $data['3']);

            $compo = Competition::where('name', $data[2])
                ->where('upload_enabled', 1)
                ->get();

            if (!$compo->containsOneItem()) {
                $this->error('Compo not found or upload not enabled');
                continue;
            }

            $uri = $this->getDownloadLink($data[8]);
            $this->comment('Download URI: ' . $uri);

            $client = new Client();
            $response = $client->get($uri);
            $filesize = (int)$response->getHeader('Content-Length')[0];

            $filename = $this->getFilenameFromHeader($response->getHeader('Content-Disposition'));
            $this->comment('Filename: ' . $filename);

            $entry = new Entry();
            $media = $entry->addMediaFromUrl($uri)->setFileName($filename)->toMediaCollection('file');
            $entry->competition_id = $compo->first()->id;
            $entry->title = $data[3];
            $entry->author = $data[4] . ' / ' . $data[5];
            $entry->description = $data[6];
            $entry->organizer_description = $data[7];
            $entry->author_email = $data[1];
            $entry->filesize = $filesize;
            $entry->save();

            $entry->final_file_media_id = $media->getAttribute('id');
            $entry->save();

            $this->info('Done Importing');
        }

        return 0;
    }

    private function getDownloadLink($url): ?string
    {
        parse_str($url, $queryData);
        return 'https://drive.google.com/uc?export=download&id=' . $queryData['id'];
    }

    private function getFilenameFromHeader(array $header)
    {
        foreach ($header as $headerLine) {
            $headerParts = explode(";", $headerLine);
            foreach ($headerParts as $headerPart) {
                $headerPart = trim($headerPart);
                $headerPartSegments = explode('"', $headerPart, 3);
                if (count($headerPartSegments) === 3 && $headerPartSegments[0] === 'filename=') {
                    return $headerPartSegments[1];
                }
            }
        }
        return null;
    }
}
