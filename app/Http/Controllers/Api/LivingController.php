<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LivingResource;
use App\Http\Resources\RecordResource;
use App\Models\Area;
use App\Models\Company;
use App\Models\Person;
use App\Models\Record;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivingController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = config('app.pageSize', 20);
        $area = $request->query('area', '');
        $building = $request->query('building', '');
        $unit = $request->query('unit', '');

        $keyword = $request->query('keyword', '');
        $areaId = $request->query('area_id', 0);

        $qb = Room::with([
            'area' => function ($query) {
                $query->withTrashed();
            },
            'category' => function ($query) {
                $query->withTrashed();
            },
            'records',
            'records.person',
            'records.company',
            'records.category'
        ]);

        // 楼号选择
        if ($area && $building && $unit) {
            $areaId = Area::where('title', $area)->value('id');
            $rooms = $qb->where('area_id', $areaId)
                ->where('building', $building)
                ->where('unit', $unit)
                ->paginate($pageSize);
            return LivingResource::collection($rooms);
        }

        // 搜索
        if ($keyword) {
            if ($areaId) {
                $qb->where('area_id', $areaId);
            }
            if (strpos($keyword, '-') !== false) { // is building
                $keyword = str_replace(['g', 'h'], ['高', '红'], $keyword);
                $rooms = $qb->where('title', 'like', "{$keyword}%")
                    ->paginate($pageSize);
            } elseif (is_numeric($keyword)) { // is phone
                $rooms = $qb
                    ->whereHas('records.person', function ($query) use ($keyword) {
                        $query->where('phone', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('records.company', function ($query) use ($keyword) {
                        $query->where('manager_phone', 'like', "%{$keyword}%")
                            ->orWhere('linkman_phone', 'like', "%{$keyword}%");
                    })
                    ->get();
            } else { // is name or company 
                $rooms = $qb
                    ->whereHas('records.person', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('records.company', function ($query) use ($keyword) {
                        $query->where('company_name', 'like', "%{$keyword}%");
                    })
                    ->get();
            }
            return LivingResource::collection($rooms);
        }
        return LivingResource::collection([]);
    }

    public function getOneLiving($id)
    {
        $record = Record::with([
            'room' => function ($query) {
                $query->withTrashed();
            },
            'category' => function ($query) {
                $query->withTrashed();
            },
            'area' => function ($query) {
                $query->withTrashed();
            },
            'person',
            'company',
        ])->findOrFail($id);
        return new RecordResource($record);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($data) {
            $record = Record::create($data);
            if ($data['type'] === 'person') {
                $personData = $data['person'];
                if (isset($personData['identify']) && $personData['identify']) {
                    $person = Person::updateOrCreate(
                        ['identify' => $personData['identify']],
                        $personData
                    );
                } else {
                    $person = Person::Create($personData);
                }
                $record->person()->associate($person);
                $record->save();
            } else if ($data['type'] === 'company') {
                $companyData = $data['company'];
                $company = Company::updateOrCreate(
                    ['company_name' => $companyData['company_name']],
                    $companyData
                );
                $record->company()->associate($company);
                $record->save();
            }
        });

        return $this->created();
    }

    public function update($id, Request $request)
    {
        $record = Record::findOrFail($id);
        $data = $request->all();
        DB::transaction(function () use ($record, $data) {
            $record->fill($data);
            if ($data['type'] === 'person') {
                $person = Person::findOrFail($data['person']['id']);
                $person->fill($data['person']);
                $person->save();
            } else if ($data['type'] === 'company') {
                $company = Company::findOrFail($data['company']['id']);
                $company->fill($data['company']);
                $company->save();
            }
            $record->save();
        });
        return $this->updated();
    }

    public function quit($id, Request $request)
    {
        $record = Record::findOrFail($id);
        $record->deleted_at = $request->deleted_at;
        $record->electric_end_base = $request->electric_end_base;
        $record->water_end_base = $request->water_end_base;
        $record->status = Record::STATUS_QUITTED;
        $record->save();
        return $this->deleted();
    }
}
