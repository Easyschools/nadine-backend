<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\ProductsExport;
use App\Exports\ProductsExportAr;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class HandleSheetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-sheet-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = 'unitArtDataEn.csv'; // Specify the desired file name
        $filePath = 'exports/unitArtDataEn.csv'; // Specify the file path

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            info('yes');
            $path = Excel::store(new ProductsExport, 'exports/' . $fileName, 'public');
        } else {
            $path = Excel::store(new ProductsExport, 'exports/' . $fileName, 'public');
        }


        $fileName = 'unitArtDataAr.csv'; // Specify the desired file name
        $filePath = 'exports/unitArtDataAr.csv'; // Specify the file path

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            info('yes');
            $path = Excel::store(new ProductsExportAr, 'exports/' . $fileName, 'public');
        } else {
            $path = Excel::store(new ProductsExportAr, 'exports/' . $fileName, 'public');
        }
    }
}
