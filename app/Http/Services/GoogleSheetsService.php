<?php

namespace App\Http\Services;

use Google\Client as GoogleClient;
use Google\Service\Sheets;

class GoogleSheetsService
{
    private GoogleClient $client;
    private Sheets $service;
    private string $spreadsheetId;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setApplicationName('Laravel Google Sheets');
        $this->client->setScopes(Sheets::SPREADSHEETS);

        $this->client->setAuthConfig(base_path(env('GOOGLE_SHEETS_CREDENTIALS')));

        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

        $this->service = new Sheets($this->client);
    }

    public function getOrders()
    {
        $range = 'Orders!A2:F';
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    }

    public function getProducts()
    {
        $range = 'Products!A2:D';
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    }
}