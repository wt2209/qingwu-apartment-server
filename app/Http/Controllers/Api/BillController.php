<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BillGenerateRequest;
use App\Http\Requests\BillRemoveRequest;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Models\Record;
use App\Services\BillService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Response;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->query('location', '');
        $areaId = $request->query('area_id', 0);
        $name = $request->query('name', '');
        $title = $request->query('title', ''); // 费用类型
        $turnIn = $request->query('turn_in', null);
        $chargedAt = $request->query('charged_at', null);
        $isRefund = $request->query('is_refund', null);
        $status = $request->query('status', null);
        $pageSize = $request->query('pageSize', 20);
        $export = $request->query('export', false);

        $qb = Bill::with(['area']);

        if ($location) {
            $location = str_replace(['h', 'g'], ['红', '高'], $location);
            $qb->where('location', $location);
        }
        if ($areaId) {
            $qb->where('area_id', $areaId);
        }
        if ($name) {
            $qb->where('name', 'like', "%{$name}%");
        }
        if ($title) {
            $qb->where('title', $title);
        }
        if (!is_null($turnIn)) {
            $qb->where('turn_in', (bool) $turnIn);
        }
        if (!is_null($isRefund)) {
            $qb->where('is_refund', intval($isRefund));
        }
        if ($chargedAt && is_array($chargedAt) && count($chargedAt) === 2) {
            $qb->where('charged_at', '>=', $chargedAt[0])
                ->where('charged_at', '<=', $chargedAt[1]);
        }
        if ($status) {
            if ($status === 'charged') {
                $qb->whereNotNull('charged_at');
            }
            if ($status === 'uncharged') {
                $qb->whereNull('charged_at');
            }
        }
        if ($export) {
            return BillResource::collection($qb->get());
        }
        return BillResource::collection($qb->paginate($pageSize));
    }

    public function generate(BillGenerateRequest $request)
    {
        $date = $request->input('date');
        $export = $request->input('export');
        $save = $request->input('save');
        // 既不保存，又不生成excel，就没必要继续了
        if (!$export && !$save) {
            return $this->ok();
        }

        $date = formatDate($date);
        $records = Record::with(['chargeRule', 'room', 'person', 'company'])
            ->where('status', 'living')
            ->where('charge_rule_id', '>', 0)
            ->where('charged_to', '<', $date)
            ->get()
            ->toArray();

        // 当前时间，用于返回数据时查询使用
        $now = date('Y-m-d H:i:s');
        // 开始生成并存储费用
        $bills = DB::transaction(function () use ($records, $save, $now) {
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
                // 更新record的“缴费至”字段
                Record::where('id', $record['id'])->update(['charged_to' => $endDate]);

                return BillService::generateBills($record, $startDate, $endDate);
            }, $records);

            $bills = [];
            // 合并生成的数据
            foreach ($billChunks as $billChunk) {
                $chunk = array_map(function ($bill) use ($now) {
                    $bill['created_at'] = $bill['updated_at'] = $now;
                    return $bill;
                }, $billChunk);
                $bills = array_merge($bills, $chunk);
            }

            if ($save) {
                DB::table('bills')->insert($bills);
            }
            return $bills;
        });

        if ($export) {
            return response()->json(['data' => BillResource::collection($bills)]);
        }
        return $this->ok();
    }

    public function remove(BillRemoveRequest $request)
    {
        $ids = $request->input('ids', null);
        Bill::whereIn('id', $ids)->delete();
        return $this->deleted();
    }
}
