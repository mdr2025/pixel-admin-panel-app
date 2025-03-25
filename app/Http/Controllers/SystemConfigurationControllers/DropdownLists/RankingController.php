<?php

namespace App\Http\Controllers\SystemConfigurationControllers\DropdownLists;

use App\Exports\BranchFormatExcel;
use App\Http\Requests\File\ImportExcelRequest;
use App\Models\SystemConfigurationModels\Ranking;
use App\Services\SystemConfigurationServices\DropdownLists\RankingOperations\RankingDeletingService;
use App\Services\SystemConfigurationServices\DropdownLists\RankingOperations\RankingStoringService;
use App\Services\SystemConfigurationServices\DropdownLists\RankingOperations\RankingUpdatingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\QueryBuilder\QueryBuilder;
use PixelApp\Http\Resources\SingleResource;
use Illuminate\Support\Facades\Response;
use PixelApp\Models\SystemConfigurationModels\Branch;
use PixelApp\Http\Resources\SystemConfigurationResources\DropdownLists\Branches\BranchResource;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as WriteTypeExcel;

class RankingController extends Controller
{
    protected $filterable = [
        'name',
        'status'
    ];

    public function index(Request $request)
    {
        $data = QueryBuilder::for(Ranking::class)

            ->allowedFilters($this->filterable)
            ->datesFiltering()
            ->customOrdering('created_at', 'asc')
            ->paginate($request->pageSize ?? 10);

        return Response::success(['list' => $data]);
    }


    public function show(Ranking $ranking)
    {
        return new SingleResource($ranking);
    }

    function list()
    {
        $data = QueryBuilder::for(Ranking::class)
            ->scopes("active")
            ->allowedFilters(['name' ])
            ->customOrdering('created_at', 'desc')
            ->get(['id', 'name']);
        return BranchResource::collection($data);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store()
    {
        return (new RankingStoringService())->create();
    }

    /**
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(Ranking $ranking): JsonResponse
    {

        return (new RankingUpdatingService($ranking))->update();
    }

    /**
     * @param Branch $branch
     * @return JsonResponse
     */
    public function destroy(Ranking $ranking): JsonResponse
    {

        return (new RankingDeletingService($ranking))->delete();
    }

    public function import( $request)
    {

        // $file = $request->file('file');
        // $rules = [
        //     'Name' => 'required|string|unique:branches,name',
        // ];

        // $columnHeaders =  ['Name'];
        // $needed_columns = ['Name' => 'name']; // Dynamic array of column headers
        // $relationNames = []; // Dynamic array of relation names

        // try{
        //     $this->excelService->import($file, $rules,$needed_columns ,new Branch() ,$columnHeaders,$relationNames );
        //     return response()->json(['message' => "data imported successfully"]);
        // } catch (\Exception $e) {

        //     return response()->json(['message' => $e->getMessage()], 406);
        // }
    }
    public static function export()
    {
        // $columnHeaders =   ['Name', 'Status'];

        // $request = request();
        // $data = QueryBuilder::for(Branch::class)
        //     ->allowedFilters(['name'])
        //     ->get();

        // $exportData = [];

        // $exportData[] = $columnHeaders;

        // // Add data rows to the export data
        // foreach ($data as $row) {

        //     $rowData = [
        //         $row->name,
        //         $row->status ==1?"Active" :"In Active",

        //     ];
        //     $exportData[] = $rowData;
        // }

        // // Generate a filename for the exported file
        // $filename = 'exported_data_' . time() . '.xlsx';

        // // Export the data to an Excel file
        // (new FastExcel($exportData))->withoutHeaders()->export(public_path($filename));

        // return response()->download($filename);
    }
    public function downloadFileFormat(Request $request)
    {
        // return Excel::download(new BranchFormatExcel(), 'format.xlsx',  WriteTypeExcel::XLSX, ['File-Name' => 'format_sample.xlsx']);
    }
}
