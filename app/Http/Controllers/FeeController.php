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

        $fees = Fees::with(['student', 'class'])
            ->where('full_paid', false)
            ->when($query, function ($q) use ($query) {
                $q->whereHas('student', function ($studentQuery) use ($query) {
                    $studentQuery->where('name', 'like', "%{$query}%")
                        ->orWhere('phone', 'like', "%{$query}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('Pages.Fee.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::all();
        $classes = ClassType::all();
        return view('Pages.Fee.create', compact('students', 'classes'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            if ($data['paid_amount'] > $data['total_amount']) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Paid amount cannot be greater than total amount.'
                ]);
            }

            $this->fee_repo->create($data);

            return redirect()->route('fees.index')->with('success', 'Fee Added Successfully!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
