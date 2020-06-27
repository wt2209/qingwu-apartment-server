<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CompanyRenameRequest;
use App\Http\Requests\LivingMoveRequest;
use App\Http\Requests\LivingRequest;
use App\Http\Resources\CompanyRenameResource;
use App\Http\Resources\LivingResource;
use App\Http\Resources\RecordResource;
use App\Http\Resources\RenewResource;
use App\Models\Area;
use App\Models\Company;
use App\Models\CompanyRename;
use App\Models\Person;
use App\Models\Record;
use App\Models\Renew;
use App\Models\Room;
use App\Services\LivingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivingController extends Controller
{
    public function index(Request $request)
    {
        $area = $request->query('area', '');
        $building = $request->query('building', '');
        $unit = $request->query('unit', '');

        // 搜索
        $keyword = $request->query('keyword', '');
        $areaId = $request->query('area_id', '');
        $categoryId = $request->query('category_id', '');

        $service = new LivingService;

        // 楼号选择
        if ($area && $building && $unit) {
            $rooms = $service->getRoomsBySelect($area, $building, $unit);
        }

        // 搜索
        if ($keyword || $areaId || $categoryId) {
            $rooms = $service->getRoomsBySearch($keyword, $areaId, $categoryId);
        }
        return LivingResource::collection($rooms ?? []);
    }

    public function tree()
    {
        $areasWithRooms = Area::select(['id', 'title'])
            ->with(['rooms' => function ($query) {
                $query->distinct('unit')->select(['unit', 'building', 'area_id']);
            }])
            ->get()
            ->toArray();

        $tree = [];
        foreach ($areasWithRooms as $area) {
            $buildings = [];
            foreach ($area['rooms'] as $room) {
                if (isset($buildings[$room['building']])) {
                    array_push($buildings[$room['building']], $room['unit']);
                } else {
                    $buildings[$room['building']] = [$room['unit']];
                }
            }
            $tree[$area['title']] = $buildings;
        }

        return response()->json(['data' => $tree], 200);
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

    public function getMoveList($personId)
    {
        $list = Record::with([
            'room' => function ($query) {
                $query->withTrashed();
            },
            'toRoom' => function ($query) {
                $query->withTrashed();
            },
            'category' => function ($query) {
                $query->withTrashed();
            },
            'area' => function ($query) {
                $query->withTrashed();
            },
            'person'
        ])
            ->withTrashed()
            ->where('person_id', $personId)
            ->where('status', Record::STATUS_MOVED)
            ->get();
        return RecordResource::collection($list);
    }

    public function getRenameList($companyId)
    {
        $list = CompanyRename::where('company_id', $companyId)->get();
        return CompanyRenameResource::collection($list);
    }

    public function getRenewList($recordId)
    {
        $list = Renew::where('record_id', $recordId)->get();
        return RenewResource::collection($list);
    }

    public function store(LivingRequest $request)
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

    public function update($id, LivingRequest $request)
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

    public function move($id, LivingMoveRequest $request)
    {
        $oldRecord = Record::findOrFail($id);
        $data = $oldRecord->toArray();
        unset($data['status']);
        unset($data['created_at']);
        unset($data['updated_at']);
        $data['electric_start_base'] = $request->electric_start_base;
        $data['water_start_base'] = $request->water_start_base;
        $data = array_filter($data);

        $toRoomId = Room::where('area_id', $request->area_id)
            ->where('title', $request->title)
            ->value('id');

        $oldRecord->deleted_at = $request->deleted_at;
        $oldRecord->status = Record::STATUS_MOVED;
        $oldRecord->electric_end_base = $request->electric_end_base;
        $oldRecord->water_end_base = $request->water_end_base;
        $oldRecord->to_room = $toRoomId;

        $data['room_id'] = $toRoomId;
        $data['record_at'] = $request->deleted_at;

        DB::transaction(function () use ($oldRecord, $data) {
            $oldRecord->save();
            Record::create($data);
        });

        return $this->ok();
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

    public function renew($id, Request $request)
    {
        $record = Record::findOrFail($id);
        if ($record->status === Record::STATUS_LIVING) {
            $renew = [
                'record_id' => $record->id,
                'old_rent_end' => $record->rent_end,
                'new_rent_end' => $request->new_rent_end,
                'renewed_at' => $request->renewed_at,
            ];
            $record->rent_end = $request->new_rent_end;
            DB::transaction(function () use ($record, $renew) {
                Renew::create($renew);
                $record->save();
            });
        }
        return $this->ok();
    }

    public function rename($companyId, CompanyRenameRequest $request)
    {
        $company = Company::findOrFail($companyId);
        $rename = [
            'company_id' => $company->id,
            'new_company_name' => $request->new_company_name,
            'old_company_name' => $company->company_name,
            'renamed_at' => $request->renamed_at,
        ];
        $company->company_name = $request->new_company_name;
        DB::transaction(function () use ($rename, $company) {
            CompanyRename::create($rename);
            $company->save();
        });
        return $this->ok();
    }
}
