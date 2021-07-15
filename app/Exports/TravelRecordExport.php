<?php
namespace App\Exports;

use App\Models\PostLocation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TravelRecordExport implements FromCollection, WithHeadings

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function collection()

    {
        return PostLocation::all('id','description','location','latitude','longitude','post_id','country');

    }
    
    public function headings(): array
    {
        return [
            'Id',
            'Description',
            'Location',
            'Latitude',
            'Longitude',
            'post_id',
            'Country'
        ];
    }

}

