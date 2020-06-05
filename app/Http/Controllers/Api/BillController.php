<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Models\Record;
use App\Services\BillService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $qb = Bill::with(['area']);

        $bills = $qb->paginate();
        return BillResource::collection($bills);
    }

    public function generate(Request $request)
    {
        Validator::make($request->all(), [
            'date' => 'required|date',
        ], [
            'date.required' => '日期必须填写',
            'date.date' => '日期格式错误',
        ])->validate();

        $date = $request->input('date');
        $date = formatDate($date);
        $export = $request->input('export', false);
        $records = Record::with(['chargeRule', 'room', 'person', 'company'])
            ->where('status', 'living')
            ->where('charge_rule_id', '>', 0)
            ->where('charged_to', '<', $date)
            ->get()
            ->toArray();

        $billChunks = array_map(function ($record) {
            // 本次应交费用的开始时间
            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($record['charged_to']))); //string
            // 缴费间隔
            $period = (int) $record['charge_rule']['period'];
            // 应交费用截止日
            $endDate = BillService::getEndDate($startDate, $period);
            // 应交费用截止日不能超过租期结束日
            if ($record['rent_end'] && strtotime($endDate) > strtotime($record['rent_end'])) {
                $endDate = formatDate($record['rent_end']);
            }

            return BillService::generateBills($record, $startDate, $endDate);

            // // 更新record的“缴费至”字段
            // $record->charged_to = $endDate;
            // $record->save();
        }, $records);
        $bills = [];
        foreach ($billChunks as $billChunk) {
            $bills = array_merge($bills, $billChunk);
        }
        if ($export) {
            return response()->json(['data' => $bills]);
        }
        return $this->ok();
    }
}
