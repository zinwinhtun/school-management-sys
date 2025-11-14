<?php

namespace App\Http\Repository;

use App\Models\Fees;
use Illuminate\Support\Facades\DB;

class FeeRepository
{
    protected $model;

    public function __construct(Fees $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $data['full_paid'] = ($data['total_amount'] == $data['paid_amount']);

            $data['is_refunded'] = ($data['fee_type'] === 'refund');

            $fee = $this->model::create($data);

            DB::commit();
            return $fee;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            throw $e;
        }
    }
}
