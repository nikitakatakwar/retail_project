<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\City;
use App\Category;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Helpers\FileTypeDetector;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Input;

use App\Document;
use App\Employee_detail;
use App\Services\SendSms;
use App\Models\EmployeeHistory;
use App\Package;
use App\Phone_number;
use App\CustomerDetail;
use App\PaymentReciept;
use App\Product;
use App\Models\ReferenceCode;
use App\Models\ReferencePoint;
use App\Setting;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{

    public function __construct($page_title = null)
    {
        $this->page_title = "Manage customer Users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {


          $page_title = $this->page_title;

          $superior_array = Employee_detail::where('superior_id', Auth::user()->id)
          ->pluck('user_id')->toArray();

          $roles= User::join('customer_details', 'customer_details.customer_id', '=', 'users.id')
          ->join('Phone_numbers', 'Phone_numbers.user_id', '=', 'users.id')

          ->with(['customer_details' => function ($query) {
              $query->with('package');


          }])->with(['package' => function ($query) {
              $query->select('title');
          }])

          ->get(['users.*', 'customer_details.customer_id','customer_details.address','customer_details.address_opt','customer_details.store_name','customer_details.business_category_id','phone_numbers.number',]);


        // dd($roles);

        if (request()->ajax()) {
            return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = "";

                    if ($data->customer_details && $data->customer_details->verification == 0) {
                        $button .= "<a href=" . route('customer.verify', $data->id) . " class='btn btn-sm btn-primary mr-1 mb-1'> Verify </a>";
                    }

                    if ($data->customer_details && $data->customer_details->payment_status == 0) {
                        $button .= "<a href=" . route('customer.pay', $data->id) . " class='btn btn-sm btn-warning mr-1 mb-1'> Pay </a>";
                    }

                    if ($data->customer_details && $data->customer_details->payment_status == 1) {
                        $button .= "<a href=" . route('customer.document', $data->id) . " class='btn btn-sm btn-info mr-1 mb-1'> Documents </a>";
                    }

                    if ($data->customer_details && $data->customer_details->payment_status == 1) {
                        $button .= "<a href=" . route('customer.invoice', $data->id) . " class='btn btn-sm btn-success mr-1 mb-1'> Invoice </a>";
                    }

                    if ($data->reference_points && Auth::user()->hasPermissionTo('show reference module')) {
                        $button .= "<a href=" . route('customer.reference.points', $data->id) . " class='btn btn-sm btn-warning mr-1 mb-1'> Reference Records </a>";
                    }

                    if (Auth::user()->hasPermissionTo('show receipt module')) {
                        $button .= "<a href=" . route('customer.payment.receipt', $data->id) . " class='btn btn-sm btn-danger mr-1 mb-1'> Payment Receipt </a>";
                    }


                $button .= "<a href=" . route('customer.product', $data->id) . " class='btn btn-sm btn-secondary mr-1 mb-1'> Products </a>";

                $button .= "<a href=" . route('customer.show', $data->id) . " class='btn btn-sm btn-info mr-1 mb-1'> View </a>";
                return $button;
            })
                ->addColumn('package', function ($data) {
                    return $data->customer_details->package->title . " (Rs. " . $data->customer_details->package->price . ")";
                })


                ->addColumn('verification', function ($data) {
                    $html = '';
                    if ($data->customer_details->verification == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->customer_details->verification == 1) {
                        $html .= '<span class="shadow-none badge badge-info">Verified</span>';
                    }
                    return $html;
                })

                // ->addColumn('phone_number', function ($data) {
                //     return $data->phone_numbers->number;
                // })

                ->addColumn('payment_status', function ($data) {
                    $html = '';
                    if ($data->customer_details->payment_status == 0) {
                        $html .= '<span class="shadow-none badge badge-danger">Pending</span>';
                    } elseif ($data->customer_details->payment_status == 1) {
                        $html .= '<span class="shadow-none badge badge-success">Paid</span>';
                    }
                    return $html;
                })

                ->addColumn('employee', function (User $user) {
                    return $user->employees ? $user->employees->map(function ($employee) {
                        return $employee->name;
                    })->implode(',') : "N/A";
                })

                // ->filterColumn('employee', function ($query, $keyword) {
                //     $query->whereHas('employee', function ($query) use ($keyword) {
                //         $query->where('name', 'like', "%" . $keyword . "%");
                //     });
                // })

                ->addColumn('payment_method', function ($data) {
                    if (count($data->transactions) > 0) {
                        $payment_types = array('Cash', 'Payment Gateway', 'UPI', 'Internet Banking', 'Paytm', 'Commission Basis');
                        return $payment_types[$data->transactions()->first()->payment_type];
                    } else {
                        return "N/A";
                    }

                })
                // ->addColumn('superior', function ($data) use ($superior_array) {
                //     if (Auth::user()->hasRole('admin') || count($superior_array) > 0) {
                //         return $data->employees ? $data->employee->map(function ($employee) {
                //             return $employee->employee_detail ? ($employee->employee_detail->superior ? $employee->employee_detail->superior->name : "N/A") : "N/A";
                //         })->implode(',') : "N/A";
                //     } else {
                //         return $data->employees ? $data->employees->map(function ($employee) {
                //             return $employee->name;
                //         })->implode(',') : "N/A";
                //     }
                // })

                ->addColumn('superior', function (User $user) {
                    return $user->employee_detail ? ($user->employee_detail->superior ? $user->employee_detail->superior->name : "N/A") : "N/A";
                })

                // ->editColumn('created_at', function ($user) {
                //     return [
                //         'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                //         'timestamp' => $user->created_at->timestamp
                //     ];
                // })

            ->addIndexColumn()
            ->rawColumns(['action', 'verification', 'payment_status'])
            ->make(true);
        }


return view('admin.customer.index')->with(compact('page_title'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page_title          = $this->page_title;
        $business_categories = Category::whereHas('parent', function ($query) {
            $query->where('title', 'Business Category');
        })->get();

        $product_categories = Category::whereHas('parent', function ($query) {
            $query->where('title', 'Product Category');
        })->get();

        $cities = City::where('state_id', 29)->get();

        $packages = Package::where('status', 1)->get();

        return view('admin.customer.create')->with(compact('page_title', 'business_categories', 'product_categories', 'cities', 'packages'));
}



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                 => 'required',
            'email'                => 'required|email|unique:users,email',
            'phone_number'         => 'required|unique:phone_numbers,number',
            'password'             => 'required|confirmed',
            'address'              => 'required',
            'business_category_id' => 'required',
            'product_category_id'  => 'required',
            'requirements'         => 'nullable',
            'services'             => 'nullable',
            'store_name'           => 'required',
            'state'                => 'required',
            'city'                 => 'required',
            'pincode'              => 'required|numeric',
            'package_id'           => 'required',
            'reference_code'       => 'nullable|exists:reference_codes,reference_code',
        ]);

        //user saving
        $user           = new User;
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        //phone number saving
        $data = [ 'number' => $request->input('phone_number')];
        $user->phone_number()->create($data);

        //assigning role customers
        $user->assignRole('customer');

        //connect customer with employee
        $user->employees()->attach(Auth::user()->id, ['employee_type' => 0]);

        //storing customer details
        $customer_details = [
            'address'              => $request->input('address'),
            'address_opt'          => $request->input('address_opt'),
            'business_category_id' => $request->input('business_category_id'),
            'product_category_id'  => $request->input('product_category_id'),
            'requirements'         => $request->input('requirements'),
            'store_name'           => $request->input('store_name'),
            'state'                => $request->input('state'),
            'city'                 => $request->input('city'),
            'pincode'              => $request->input('pincode'),
            'gstin'                => $request->input('gstin'),
            'pos'                  => $request->input('pos'),
            'verification'         => 0,
            'payment_status'       => 0,
            'package_id'           => $request->input('package_id'),

        ];

        $user->customer_details()->create($customer_details);

        if ($request->input('reference_code'))
         {
            $package = Package::find($request->input('package_id'));

            $reference_code_record         = ReferenceCode::where('reference_code', $request->input('reference_code'))->first();
            $reference_cashback            = Setting::where('setting_key', 'reference_cashback')->first()->value;
            $reference_points              = new ReferencePoint();
            $reference_points->customer_id = $reference_code_record->id;
            $reference_points->points      = ($reference_cashback / 100) * $package->price;
            $reference_points->description = "Your reference code used by " . $user->name;
            $reference_points->status      = 0;

            $reference_points->save();
        }

        return redirect()->route('customer.pay', $user->id);

    }


            public function pay($id)
            {


                $page_title          = $this->page_title;
                $customer   = User::where('id', $id)
                    ->with([
                        'customers' => function ($query) {
                            $query->with('package');
                        },
                    ])->first();



                if (!$customer->hasRole('customer')) {
                    return redirect()->route('home')->with('error-message', 'Invalid Customer!');
                }

                if ($customer->payment_status == 1) {
                    return redirect()->route('customer.index')->with('error-message', 'Already paid!');
                }

                $gst = Setting::where('setting_key', 'gst')->first();

                return view('admin.razorpay.payment')->with(compact( 'customer', 'gst'));
            }


            public function storeTransaction(Request $request)
            {
                $this->validate($request, [
                    'transaction_id' => 'required',
                    'payment_method' => 'required',
                    'amount'         => 'required',
                    'total_amount'   => 'required',
                    'tax'            => 'required',
                ]);

                $customer = User::where('id', $request->input('customer_id'))
                    ->first();
                $customer_details = CustomerDetail::where('customer_id', $request->input('customer_id'))
                    ->with('package')
                    ->first();

                $transaction = new Transaction();

                $transaction->user_id        = $request->input('customer_id');
                $transaction->transaction_id = $request->input('transaction_id');
                $transaction->amount         = $request->input('payment_method') == 5 ? 0 : $request->input('amount');
                $transaction->total_amount   = $request->input('payment_method') == 5 ? 0 : $request->input('total_amount');
                $transaction->tax            = $request->input('payment_method') == 5 ? 0 : $request->input('tax');
                $transaction->payment_type   = $request->input('payment_method');

                $transaction->save();

                $customer_details->payment_status = 1;
                $customer_details->update();

                return redirect()->route('customer.index')->with('success-message', 'Payment Successful!');
            }


            public function product($id)
            {

                $page_title = $this->page_title;
                $customer   = User::where('id', $id)
                ->with([
                    'customers' => function ($query) {
                        $query->with('package');
                    },
                ])->first();

            if (!$customer->hasRole('customer')) {
                return redirect()->route('home')->with('error-message', 'Invalid Customer!');
            }

            if ($customer->customer_details->payment_status == 0) {
                return redirect()->route('customer.index')->with('error-message', 'Please pay before adding products!');
            }


            if (request()->ajax()) {

                $query = Product::where('customer_id', request()->get('id'));

                return DataTables::of($query)
                    ->editColumn('created_at', function ($data) {
                        return $data->created_at ? $data->created_at->format('d/m/Y h:i a') : "N/A";
                    })
                    ->make(true);
            }

            return view('admin.customer.product')->with(compact('page_title', 'customer'));

            }


            public function productUpload(Request $request)
            {
                Excel::import(new ProductImport($request->input('customer_id')), $request->file('document')->store('temp'));

                return redirect()->back()->with('success-message', 'Products Imported Successfully!');
            }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('customer.index')->with('success-message', 'Admin User Deleted Successfully!');
    }

    public function smsVerification($id)
    {
        // $page_title = $this->page_title;
        $customer   = User::where('id', $id)
            ->with([
                'customers' => function ($query) {
                    $query->with('package');
                },
            ])
            ->with('Phone_number')
            ->first();
            //  dd($customer->Phone_number->number);

        if (!$customer->hasRole('customer')) {
            return redirect()->route('home')->with('error-message', 'Invalid Customer!');
        }

        if ($customer->verification == 1) {
            return redirect()->route('customer.index')->with('error-message', 'Already verified!');
        }

        return view('admin.customer.verification')->with(compact('page_title', 'customer'));
    }

    public function sendOTP($mobile)
    {
        $otp = mt_rand(100000, 999999);
        Session::put('otp', $otp);
        $app_name = env('APP_NAME');
        $mobile   = array($mobile);
        $message  = "Welcome to " . env('APP_NAME') . ", Your Verification OTP is " . $otp;
        $send_sms = new SendSms;
        $send_sms->sendSMS($mobile, $message);

        return redirect()->back()->with('success-message', 'New OTP sent!');
    }


    public function submitOTP(Request $request)
    {

        if (Session::get('otp') != $request->input('otp')) {
            return redirect()->back()->with('error-message', 'OTP mismatch! Please Try Again!');
        } else {
            $customers = CustomerDetail::where('customer_id', $request->input('customer_id'))
                ->with(['customers' => function ($query) {
                    $query->with('phone_numbers');
                }])
                ->dd();

            $customers->verification = 1;
            $customers->update();

            $mobile = array($customers->customer->phone_numbers->number);

            $message = "Dear " . $customers->customer->name . "
                \nYour profile has been successfully VERIFIED.
                \nThank you,
                \nCall and WhatsApp Number " . Auth::user()->phone_numbers->number;

            $send_sms = new SendSms;
            $send_sms->sendSMS($mobile, $message);

            return redirect()->route('customer.index')->with('success-message', 'Verification Successful!');
        }

    }


    public function show($id)
    {
        $page_title = "Customer Details";
        $user       = User::where('id', $id)
            ->whereHas('customer_details')
            ->with(['customer_details' => function ($query) {
                $query->with('package');
            }])->with('phone_number')
            ->with('employees')
            ->first();

        if (!$user) {
            return redirect()->back()->with('error-message', 'User Information Unavailable!');
        }

        $show_form = null;
        if ($user->moving_status && $user->moving_status->employee_id == Auth::user()->id) {
            $show_form = 1;
        }

        return view('admin.customer.view')->with(compact('user', 'page_title', 'show_form'));
    }

    public function document($id)
    {
        // $page_title = $this->page_title;
        $customer   = User::where('id', $id)
            ->with([
                'customers' => function ($query) {
                    $query->with('package');
                },
            ], 'documents')->first();



        if (!Auth::user()->hasRole('customer')) {
            return redirect()->route('home')->with('error-message', 'Invalid Customer!');
        }

        $document_categories = Category::whereHas('parent', function ($query) {
            $query->where('title', 'Document Category');
        })->get();

        return view('admin.customer.document',[" customer "=> $customer ])->with(compact('page_title', 'customer', 'document_categories'));
    }


    public function documentSubmit(Request $request)
    {
        if ($request->hasFile('document')) {
            if ($request->file('document')->isValid()) {
                $validated = $request->validate([
                    'document_category' => 'string|max:40',
                    'document'          => 'mimes:jpeg,png|max:1014',
                ]);

                $extension = $request->document->extension();
                $request->document->storeAs('/public/user_documents', $request->input('customer_id') . strtotime(now()) . "." . $extension);
                $url  = Storage::url('user_documents/' . $request->input('customer_id') . strtotime(now()) . "." . $extension);
                $file = Document::create([
                    'document_type' => $validated['document_category'],
                    'document'      => $url,
                    'user_id'       => $request->input('customer_id'),
                ]);
                return redirect()->back()->with('success-message', 'Document Saved Successfully!');
            }
        }
        return redirect()->back()->with('error-message', 'Could not upload Image! Please check file type!');
    }

    public function showInvoice($id)
    {

       $page_title = $this->page_title;
        $customer   = User::where('id', $id)
            ->with('transactions')
            ->whereHas('employees', function ($query) {
                if (Auth::user()->hasRole(['employee'])) {
                    $query->where('employee_id', Auth::user()->id);
                }
            })
            ->with(['customers' => function ($query) {
                $query->with('package');
            }])
            ->first();

        $gst = Setting::where('setting_key', 'gst')->first();

        if (count($customer->transactions) == 0) {

            $transaction                 = new Transaction();
            $transaction->user_id        = $customer->id;
            $transaction->transaction_id = "9VN_MANUAL_ENTRY";
            $transaction->amount         = $customer->customers->package->price;
            $transaction->tax            = $transaction->amount * ($gst->value / 100);
            $transaction->total_amount   = $transaction->amount + $transaction->tax;
            $transaction->payment_type   = 0;
            $transaction->save();
        }

        $customer->refresh();

        return view('admin.customer.invoice')->with(compact('customer', 'page_title', 'gst'));
    }


    public function paymentReceipt($id)
    {
        // $page_title = $this->page_title;

        $customer   = User::where('id', $id)
        ->with([
            'customers' => function ($query) {
                $query->with('package');
            },
        ])
        ->with('Phone_number')
        ->first();
        //  dd($customer->Phone_number->number);

        // if (!$payment_receipt) {


        // }

        return view('admin.customer.payment_receipt')->with(compact('customer', 'payment_receipt', 'page_title'));

 }

}
