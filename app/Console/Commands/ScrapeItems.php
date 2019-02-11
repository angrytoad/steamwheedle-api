<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemRarity;
use App\Models\Risk;
use Goutte\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes items from the internet to update images etc.  Preserves rarity.  Providing an empty category selects previous answer.';

    protected $scraper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->scraper = new Client();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!file_exists(base_path() . '/data/items.csv')) {
            $this->error('No items csv found.');
            return false;
        }

        $csv = fopen(base_path() . '/data/items.csv', 'r');

        $this->info('Beginning scrape...');
        while (!feof($csv)) {
            $item = fgetcsv($csv);
            if (empty($item[0])) {
                continue;
            }
            $this->info('Fetching ' . $item[0] . '!');
            $data = $this->scrapePageData($item[2]);
            $data['name'] = $item[0];
            $data['description'] = $item[1];
            $data['category_id'] = Category::where('name', $item[3])->first()->id;

            if (!$this->validateData($data)) {
                $this->error('Error with this items data!  Skipping...');
                continue;
            }

            $record = Item::where('name', $data['name'])->first();
            if (empty($record)) {
                $record = new Item();
                foreach ($data as $key => $val) {
                    $record->$key = $val;
                }
                $record->risk_id = $this->generateRisk();
                $record->current_price = $record->base_price;

            } else {
                foreach ($data as $key => $val) {
                    $record->$key = $val;
                }
            }
            $record->save();
        }

        return true;
    }


    /**
     * Fetch and parse the specificed url for the items data
     *
     * @param $url
     * @return array
     */
    private function scrapePageData($url) :array
    {
        $data = [];
        $page = $this->scraper->request('GET', $url);
        $data['base_price'] = $this->fetchAndCalcPrice($page);
        $data['image'] = '/img/icons/' . $this->fetchImage($page);
        $data['rarity_id'] = $this->fetchRarity($page);
        return $data;
    }

    /**
     * Return the scraped image url from the page
     *
     * @param Crawler $page
     * @return string
     */
    private function fetchImage(Crawler $page) :string
    {
        $name = $page->filter('.text div')->eq(1)->attr('onclick');
        $name = str_replace('ShowIconName(\'', '', $name);
        $name = str_replace('\')', '', $name);
        $name = $name . '.jpg';

        $this->downloadImage("http://classicdb.ch/images/icons/large/$name", base_path() . "/public/img/icons/$name");
        return $name;

    }

    /**
     * Fetch the Rarity model based on scraped data
     *
     * @todo There is rarites in the html up to q10, do these need working out or are we not using any of them?
     *
     * @param Crawler $page
     * @return Mixed
     */
    private function fetchRarity(Crawler $page)
    {
        $classes = $page->filter('b')->extract(['class']);
        foreach ($classes as $code) {
            if (!empty($code)) {
                $class = $code;
            }
        }
        if (empty($class)) {
            return false;
        }
        switch ($class) {
            case "q0":
                return ItemRarity::where('name', 'Poor')->first()->id;
            case "q1":
                return ItemRarity::where('name', 'Common')->first()->id;
            case "q2":
                return ItemRarity::where('name', 'Uncommon')->first()->id;
            case "q3":
                return ItemRarity::where('name', 'Rare')->first()->id;
            case "q4":
                return ItemRarity::where('name', 'Epic')->first()->id;
            case "q5":
                return ItemRarity::where('name', 'Legendary')->first()->id;
        }
        return false;
    }

    /**
     * Fetches the items buy price in copper from the page
     *
     * @param Crawler $page
     * @return int
     */
    private function fetchAndCalcPrice(Crawler $page) :int
    {
        try {
            $gold = (int) $page->filter('.moneygold')->first()->text();
        } catch (\Exception $e) {
            $gold = 0;
        }

        try {
            $silver = (int) $page->filter('.moneysilver')->first()->text();
        } catch (\Exception $e) {
            $silver = 0;
        }

        try {
            $copper = (int) $page->filter('.moneycopper')->first()->text();
        } catch (\Exception $e) {
            $copper = 0;
        }

        return (($gold * 10000) + ($silver * 100) + $copper);
    }

    /**
     * Validates the data
     *
     * @param array $data
     * @return bool
     */
    private function validateData(array $data) :bool
    {
        if (!is_string($data['name']) || empty($data['name'])) {
            return false;
        }
        if (!is_string($data['description']) || empty($data['description'])) {
            return false;
        }
        if (!is_int($data['base_price']) || empty($data['base_price'])) {
            return false;
        }
        if (!is_string($data['category_id']) || empty($data['category_id'])) {
            return false;
        }
        if (!is_string($data['image']) || empty($data['image'])) {
            return false;
        }
        return true;
    }

    /**
     * Returns an appropriately generated risk id
     *
     * @return mixed
     */
    private function generateRisk()
    {
        $rng = rand(1, 100);
        if ($rng <= 30) {
            return Risk::where('name', 'Very Low')->first()->id;
        }
        if ($rng <= 55) {
            return Risk::where('name', 'Low')->first()->id;
        }
        if ($rng <= 75) {
            return Risk::where('name', 'Medium')->first()->id;
        }
        if ($rng <= 90) {
            return Risk::where('name', 'High')->first()->id;
        }
        return Risk::where('name', 'Very High')->first()->id;

    }

    private function downloadImage($url, $saveto){
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($saveto)){
            unlink($saveto);
        }
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
}
