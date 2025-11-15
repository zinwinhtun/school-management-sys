<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\ClassType;
use App\Http\Repository\FeeRepository;
use App\Http\Requests\Fee\CreateRequest;
use App\Models\Fees;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FeeController extends Controller
{
    protected $fee_repo;

    public function __construct(FeeRepository $fee_repo)
    {
        $this->fee_repo = $fee_repo;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status'); // full_paid filter

        $fees = Fees::with(['student', 'class'])
            ->when($query, function ($q) use ($query) {
                $q->whereHas('student', function ($s) use ($query) {
                    $s->where('name', 'like', "%{$query}%")
                        ->orWhere('phone', 'like', "%{$query}%");
                })
                    ->orWhereHas('class', function ($c) use ($query) {
                        $c->where('name', 'like', "%{$query}%");
                    });
            })
            ->when($status, function ($q) use ($status) {
                if ($status == 'paid') {
                    $q->where('full_paid', true);
                } elseif ($status == 'pending') {
                    $q->where('full_paid', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('Pages.Fee.index', compact('fees'));
    }

    public function collectCreate()
    {
        $students = Student::all();
        $classes = ClassType::all();
        return view('Pages.Fee.create', compact('students', 'classes'));
    }

    public function collectStore(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            if ($data['amount'] > $data['total_amount']) {
                throw ValidationException::withMessages([
                    'amount' => 'Paid amount cannot be greater than total amount.'
                ]);
            }

            $this->fee_repo->collect($data);

            return redirect()->route('fees.index')->with('success', 'New Fee Collect Successfully!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function detail($id)
    {
        $fee = Fees::with('student')->findOrFail($id);

        $student = $fee->student;

        // Paginated Fee History
        $history = $fee->fee_history()->orderByDesc('id')->paginate(5);

        return view('Pages.Fee.detail', compact('fee', 'student', 'history'));
    }

    public function collect($id)
    {
        $fee = Fees::with('student', 'class')->findOrFail($id);
        return view('Pages.Fee.collect', compact('fee'));
    }

    public function addCollect(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'amount'  => 'required|numeric|min:0',
                'note'  => 'nullable|string',
            ]);

            $this->fee_repo->addCollect($id, $data);
            return redirect()->route('fees.index')->with('success', 'Fee Collect Successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function refund($id)
    {
        $fee = Fees::with('student','class')->findOrFail($id);
        return view('Pages.Fee.refund',compact('fee'));
    }

    public function addRefund(Request $request , $id)
    {
        try {
            $data = $request->validate([
                'amount'  => 'required|numeric|min:0',
                'note'  => 'nullable|string',
            ]);

            $this->fee_repo->addRefund($id, $data);
            return redirect()->route('fees.index')->with('success', 'Fee Refund Successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

}
