<?php

namespace App\Http\Controllers;

use App\Models\AuthorLoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

/**
 * Ported from the CodeIgniter 3 AuthorDashboard controller.
 *
 * Query-builder, session and view calls map across to their Laravel
 * equivalents while preserving the original behaviour. Authentication is a
 * custom session guard (session key "author_login"); the AuthorAuth middleware
 * replaces the legacy loginSession() helper on protected routes.
 */
class AuthorDashboardController extends Controller
{
    protected AuthorLoginModel $model;

    public function __construct()
    {
        $this->model = new AuthorLoginModel();
    }

    // ***************************** First Page / Auth ************

    public function login()
    {
        return view('authordashboard.login_page');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('email');
        $request->session()->flush();

        return redirect()->to('/');
    }

    public function author_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Please enter Email',
            'password.required' => 'Please enter Password',
        ]);

        if ($validator->fails()) {
            return view('authordashboard.login_page')->withErrors($validator);
        }

        $email = $request->input('email');
        $pass  = $request->input('password');

        $login = $this->model->login_data($email, $pass);

        if ($login) {
            $data = [
                'userName' => $login->lead_author_name,
                'user_id'  => $login->id,
                'email'    => $login->user_email,
                'mobileNo' => $login->phonenumber,
                'lead_new' => $login->lead_new,
            ];

            $request->session()->put('author_login', $data);

            return redirect()->to('AuthorDashboard');
        }

        return redirect()->to('AuthorDashboard/author_login')
            ->with('error_msg', 'Invalid account credentials.!');
    }

    // ***************************** Author Dashboard ************

    public function index()
    {
        $userid = session('author_login')['user_id'];

        $data['total_profit'] = $this->profit();

        $data['sales'] = DB::table('kdp_sale_report')
            ->selectRaw('SUM(UnitsSold) as sell, orderMonth, orderYear')
            ->where('leads_id', $userid)
            ->groupBy('orderMonth')
            ->get();

        $data['tol_paid'] = DB::table('tbl_pay_royality')
            ->selectRaw('SUM(amount) as paid')
            ->where('lead_id', $userid)
            ->get();

        $currentYear = date('Y');

        $data['monthData'] = DB::table('kdp_sale_report')
            ->selectRaw('YEAR(DATE_SUB(OrderDateDt, INTERVAL 3 MONTH)) AS FinancialYear, MONTHNAME(OrderDateDt) AS Month, SUM(UnitsSold) AS Orders')
            ->where('leads_id', $userid)
            ->where('OrderDateDt', '>=', $currentYear . '-01-01')
            ->where('OrderDateDt', '<=', $currentYear . '-12-31')
            ->groupByRaw('FinancialYear, MONTH(OrderDateDt)')
            ->orderByRaw('FinancialYear, FIELD(MONTH(OrderDateDt),4,5,6,7,8,9,10,11,12,1,2,3)')
            ->get();

        return view('authordashboard.dashboard', $data);
    }

    /**
     * Aggregate the author's lifetime profit / units across marketplaces.
     * Returns the data array the dashboard view expects.
     */
    public function profit(): array
    {
        $userid = session('author_login')['user_id'];

        $book = DB::table('mrpfixation')->where('leads_id', $userid)->get();

        $totalSold = 0;
        $total_profit = 0;
        $total_amazoncount = 0;
        $total_flipkart = 0;
        $total_gpay = 0;
        $total_kdp = 0;
        $total_bfc = 0;

        foreach ($book as $bb) {
            $sales = DB::table('kdp_sale_report')
                ->where('leads_id', $userid)
                ->where('BookTitle', $bb->book_title)
                ->get();

            $sold = 1; $return = 1; $flipkart = 0; $amazoncount = 0; $gpay = 0; $kdp = 0; $bfc = 0;
            foreach ($sales as $saleData) {
                if ($saleData->Marketplace == "Flipkart" && $saleData->UnitsSold >= 1) {
                    $flipkart = $flipkart + $saleData->UnitsSold;
                } elseif ($saleData->Marketplace == "Flipkart" && $saleData->UnitsSold < 0) {
                    $flipkart = $flipkart + $saleData->UnitsSold;
                }

                if ($saleData->Marketplace == "GooglePlay" && $saleData->UnitsSold >= 1) {
                    $gpay = $gpay + $saleData->UnitsSold;
                } elseif ($saleData->Marketplace == "GooglePlay" && $saleData->UnitsSold <= -1) {
                    $gpay = $gpay + $saleData->UnitsSold;
                }

                if ($saleData->Marketplace == "KDP" && $saleData->UnitsSold >= 1) {
                    $kdp = $kdp + $saleData->UnitsSold;
                } elseif ($saleData->Marketplace == "KDP" && $saleData->UnitsSold <= -1) {
                    $kdp = $kdp + $saleData->UnitsSold;
                }

                if ($saleData->Marketplace == "Amazon" && $saleData->UnitsSold >= 1) {
                    $amazoncount = $amazoncount + $saleData->UnitsSold;
                } elseif ($saleData->Marketplace == "Amazon" && $saleData->UnitsSold <= -1) {
                    $amazoncount = $amazoncount + $saleData->UnitsSold;
                }

                if ($saleData->Marketplace == "bfc" && $saleData->UnitsSold >= 1) {
                    $bfc = $bfc + $saleData->UnitsSold;
                } elseif ($saleData->Marketplace == "bfc" && $saleData->UnitsSold <= -1) {
                    $bfc = $bfc + $saleData->UnitsSold;
                }
            }

            $totalSold += $sold - $return;
            $totalSold += $flipkart + $gpay + $kdp + $amazoncount + $bfc;
            $profit1 = ($kdp + $gpay) * $bb->kdp;
            $profit2 = ($amazoncount + $flipkart) * $bb->amazon;
            $profit3 = $bfc * $bb->bfc;
            $total_profit += $profit1 + $profit2 + $profit3;

            $total_amazoncount += $amazoncount;
            $total_flipkart += $flipkart;
            $total_gpay += $gpay;
            $total_kdp += $kdp;
            $total_bfc += $bfc;
        }

        return [
            'totalSold'    => $totalSold,
            'total_profit' => $total_profit,
            'flipkart'     => $total_flipkart,
            'gpay'         => $total_gpay,
            'kdp'          => $total_kdp,
            'amazoncount'  => $total_amazoncount,
            'bfc'          => $total_bfc,
            'other'        => 0,
        ];
    }

    public function view_details()
    {
        $userid = session('author_login')['user_id'];

        $data['sales'] = DB::table('kdp_sale_report')
            ->where('leads_id', $userid)
            ->get();

        return view('authordashboard.view-detail', $data);
    }

    public function payable()
    {
        $userid = session('author_login')['user_id'];

        $book = DB::table('mrpfixation')->where('leads_id', $userid)->get();

        $totalSold = 0; $total_profit = 0;
        foreach ($book as $bb) {
            $sales = DB::table('kdp_sale_report')
                ->where('leads_id', $userid)
                ->where('BookTitle', $bb->book_title)
                ->get();

            [$flipkart, $gpay, $kdp, $amazoncount, $bfc] = $this->tallyMarketplaces($sales);

            $totalSold += 0;
            $totalSold += $flipkart + $gpay + $kdp + $amazoncount + $bfc;
            $total_profit += (($kdp + $gpay) * $bb->kdp) + (($amazoncount + $flipkart) * $bb->amazon) + ($bfc * $bb->bfc);
        }

        $data['pre_profit'] = $total_profit;

        $current_profit = 0;
        foreach ($book as $bb) {
            $sales = DB::table('kdp_sale_report')
                ->where('leads_id', $userid)
                ->where('BookTitle', $bb->book_title)
                ->whereRaw('OrderDateDt BETWEEN "' . date('Y-m-01') . '" and "' . date('Y-m-d') . '"')
                ->get();

            [$flipkart, $gpay, $kdp, $amazoncount, $bfc] = $this->tallyMarketplaces($sales);

            $current_profit += (($kdp + $gpay) * $bb->kdp) + (($amazoncount + $flipkart) * $bb->amazon) + ($bfc * $bb->bfc);
        }

        $data['tol_paid'] = DB::table('tbl_pay_royality')
            ->selectRaw('SUM(amount) as paid')
            ->where('lead_id', $userid)
            ->get();

        $data['current_profit'] = $current_profit;

        return view('authordashboard.payable', $data);
    }

    public function getprofitDeatils(Request $request)
    {
        $userid   = session('author_login')['user_id'];
        $calendar = $request->input('calendar');

        $time  = strtotime($calendar);
        $final = date("Y-m", strtotime("-1 month", $time));

        $book = DB::table('mrpfixation')->where('leads_id', $userid)->get();

        $start = $calendar . "-01";
        $end   = $calendar . "-31";

        $total_profit = 0;
        foreach ($book as $bb) {
            $sales = DB::table('kdp_sale_report')
                ->where('leads_id', $userid)
                ->where('BookTitle', $bb->book_title)
                ->where('OrderDateDt', '<=', $final . "-31")
                ->get();

            [$flipkart, $gpay, $kdp, $amazoncount, $bfc] = $this->tallyMarketplaces($sales);

            $total_profit += (($kdp + $gpay) * $bb->kdp) + (($amazoncount + $flipkart) * $bb->amazon) + ($bfc * $bb->bfc);
        }

        $data['pre_profit'] = $total_profit;

        $current_profit = 0;
        foreach ($book as $bb) {
            $sales = DB::table('kdp_sale_report')
                ->where('leads_id', $userid)
                ->where('BookTitle', $bb->book_title)
                ->whereRaw('OrderDateDt BETWEEN "' . $start . '" and "' . $end . '"')
                ->get();

            [$flipkart, $gpay, $kdp, $amazoncount, $bfc] = $this->tallyMarketplaces($sales);

            $current_profit += (($kdp + $gpay) * $bb->kdp) + (($amazoncount + $flipkart) * $bb->amazon) + ($bfc * $bb->bfc);
        }

        $tol_paid = DB::table('tbl_pay_royality')
            ->selectRaw('SUM(amount) as paid')
            ->where('lead_id', $userid)
            ->get();

        $data['earn_profit']    = $tol_paid[0]->paid;
        $data['current_profit'] = $current_profit;
        $data['date']           = date("d/m/Y", strtotime($start));

        return response()->json($data);
    }

    public function salesReport()
    {
        $lead_id = session('author_login')['user_id'];

        $data['book_details'] = DB::table('kdp_sale_report')
            ->where('leads_id', $lead_id)
            ->groupBy('BookTitle')
            ->get();

        return view('authordashboard.sales-report', $data);
    }

    public function getbookDetailsFilter(Request $request)
    {
        $book_title = $request->input('booktitle');
        $lead_id    = $request->input('lead_id');
        $start      = $request->input('start');
        $end        = $request->input('end');

        $book = DB::table('mrpfixation')->where('book_title', $book_title)->first();

        $query = DB::table('kdp_sale_report')
            ->where('leads_id', $lead_id)
            ->where('BookTitle', $book_title);

        if ($start != '') {
            $query->whereRaw('OrderDateDt BETWEEN "' . date('Y-m-d', strtotime($start)) . '" and "' . date('Y-m-d', strtotime($end)) . '"');
        }

        $sales = $query->get();

        return response()->json($this->buildBookDetails($book, $sales));
    }

    public function getbookDetails(Request $request)
    {
        $book_title = $request->input('booktitle');
        $lead_id    = $request->input('lead_id');

        $book = DB::table('mrpfixation')->where('book_title', $book_title)->first();

        $sales = DB::table('kdp_sale_report')
            ->where('leads_id', $lead_id)
            ->where('BookTitle', $book_title)
            ->get();

        return response()->json($this->buildBookDetails($book, $sales));
    }

    public function myrecord()
    {
        return view('authordashboard.my-record');
    }

    public function book_publish()
    {
        $data['userid'] = session('author_login')['user_id'];

        $data['book_language'] = DB::table('tbl_language')->where('status', 1)->get();

        return view('authordashboard.book-publish', $data);
    }

    public function refer_friend()
    {
        $data['userid'] = session('author_login')['user_id'];

        return view('authordashboard.refer-your-friends', $data);
    }

    public function bank_details()
    {
        return view('authordashboard.bank-details');
    }

    public function myprofile($id = '', $lead_id = '', $leadnew = '')
    {
        $data['id']      = $id;
        $data['lead_id'] = $lead_id;

        $userId  = session('author_login')['user_id'];
        $lead_new = session('author_login')['lead_new'];

        if (empty($lead_new)) {
            $data['book_details'] = $this->model->book_list();

            if (! empty($id) && ! empty($lead_id)) {
                if ($id == $lead_id && empty($lead_new)) {
                    $data['package_details'] = DB::table('tblleads')->where('id', $lead_id)->first();
                    $data['asf_details']     = DB::table('chorus_asf')->whereNull('asf_new')->where('lead_id', $id)->first();
                } else {
                    if ($leadnew == '1') {
                        $data['package_details'] = DB::table('create_package_leads')->where('id', $id)->first();
                        $data['asf_details']     = DB::table('chorus_asf')->where('lead_id', $id)->where('asf_new', 1)->first();
                    } else {
                        $data['package_details'] = DB::table('tblleads_create_package')->where('id', $id)->first();
                        $data['asf_details']     = DB::table('chorus_asf')->whereNull('asf_new')->where('lead_id', $id)->first();
                    }
                }
            } else {
                $firstId = $data['book_details'][0]->id;
                $data['package_details'] = DB::table('tblleads')->where('id', $firstId)->first();
                $data['asf_details']     = DB::table('chorus_asf')->whereNull('asf_new')->where('lead_id', $firstId)->first();
            }
        } else {
            $data['book_details'] = $this->model->book_list();
            $firstId = $data['book_details'][0]->id;
            $data['package_details'] = DB::table('create_package_leads')->where('id', $firstId)->first();
            $data['asf_details']     = DB::table('chorus_asf')->where('asf_new', '1')->where('lead_id', $firstId)->first();
        }

        // The legacy view ran inline city/state/country lookups via $this->db;
        // resolve them here and pass them in instead.
        $data['city_name'] = $data['state_name'] = $data['country_name'] = null;
        if (! empty($data['asf_details']) && ! empty($data['asf_details']->asf_address)) {
            $data['city_name']    = DB::table('cities')->where('id', $data['asf_details']->asf_city)->first();
            $data['state_name']   = DB::table('states')->where('id', $data['asf_details']->asf_state)->first();
            $data['country_name'] = DB::table('countries')->where('id', $data['asf_details']->asf_country)->first();
        }

        return view('authordashboard.my-profile', $data);
    }

    public function change_password()
    {
        return view('authordashboard.change-password');
    }

    public function updatePass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword'  => 'required',
            'newPassword'  => 'required|max:10',
            'confirm_pass' => 'required|max:10|same:newPassword',
        ], [
            'required' => 'Enter :attribute',
        ]);

        if ($validator->fails()) {
            return view('authordashboard.change-password')->withErrors($validator);
        }

        $id     = $request->input('userid');
        $oldpws = $request->input('oldPassword');
        $newpws = $request->input('newPassword');

        $lead = DB::table('tblleads')->where('id', $id)->first();

        if ($lead) {
            // Mirror the legacy external password-sync API call.
            $this->appChangePassword($lead->email ?? '', $newpws);
        }

        $changed = $this->model->changePassword($id, $newpws, $oldpws);

        if ($changed) {
            return redirect()->to('AuthorDashboard/change_password')
                ->with('success_msg', 'Your password has been changed.');
        }

        return redirect()->to('AuthorDashboard/change_password')
            ->with('error_msg', 'Your old password is incorrect');
    }

    public function refer_friend_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'   => 'required',
            'user_email'  => 'required|email',
            'user_mobile' => 'required|max:10|min:10',
        ], [
            'required' => 'Please enter :attribute',
        ]);

        if ($validator->fails()) {
            return view('authordashboard.refer-your-friends')->withErrors($validator);
        }

        DB::table('tbl_refer_friend')->insert([
            'author_id' => $request->input('id'),
            'name'      => trim($request->input('user_name')),
            'email'     => trim($request->input('user_email')),
            'phone_no'  => trim($request->input('user_mobile')),
        ]);

        return redirect()->to('AuthorDashboard/refer_friend')
            ->with('success_msg', 'Refer a friend inserted successfully!');
    }

    public function bookPublish(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_title'           => 'required',
            'status_of_manuscript' => 'required',
            'book_genre'           => 'required',
            'book_language'        => 'required',
        ], [
            'required' => 'Please enter :attribute',
        ]);

        if ($validator->fails()) {
            return view('authordashboard.book-publish')->withErrors($validator);
        }

        DB::table('tbl_book_publish')->insert([
            'authorId'             => $request->input('id'),
            'book_title'           => $request->input('book_title'),
            'status_of_manuscript' => $request->input('status_of_manuscript'),
            'genre_of_book'        => $request->input('book_genre'),
            'book_language'        => $request->input('book_language'),
        ]);

        return redirect()->to('AuthorDashboard/book_publish')
            ->with('success_msg', 'Book Publish inserted successfully!');
    }

    public function work_status($id = '')
    {
        $data['bookid']       = $id;
        $data['book_details'] = $this->model->book_list();

        $data['package_details'] = DB::table('create_package_leads')->where('id', $id)->first();

        $sub_service = $data['package_details']
            ? explode(",", $data['package_details']->sub_services)
            : [];
        $data['sub_service'] = $sub_service;

        $data['proofreading'] = DB::table('services_level_two')
            ->whereIn('id', $sub_service)
            ->where('services_level_nm_2', 'like', '%Proof%')
            ->get();

        $data['formatediting'] = DB::table('services_level_two')
            ->whereIn('id', $sub_service)
            ->where('services_level_nm_2', 'like', '%Format%')
            ->get();

        return view('authordashboard.work_status', $data);
    }

    public function myOrder()
    {
        $email = session('author_login')['email'];

        $response = Http::asForm()->post('https://admin.bookstore.bfcpublications.com/api/transaction', [
            'email' => $email,
        ]);

        $jsonData = $response->json();
        $data['transaction'] = $jsonData['data'] ?? [];

        return view('authordashboard.my-order', $data);
    }

    public function paymentop()
    {
        return view('authordashboard.paymentop');
    }

    // ***************** Forget Password (legacy, UI-disabled) **********************

    public function forget_password()
    {
        return view('authordashboard.forget-password');
    }

    public function recover_password()
    {
        return view('authordashboard.forget_password');
    }

    public function send_email(Request $request)
    {
        $forget_mail = $request->input('emailid');

        $mail = $this->model->forget_pws($forget_mail);

        if ($mail) {
            return redirect()->to('AuthorDashboard/recover_password');
        }

        return redirect()->to('AuthorDashboard/forget_password')
            ->with('msg', '<div class="alert alert-danger" role="alert" style=color:red >Please enter correct email.</div>');
    }

    // ***************** Helpers **********************

    /**
     * Mirror of the legacy appChangePassword() external API call that syncs the
     * author's password to the bookstore admin. Failures are swallowed so the
     * local password change still completes, matching the original intent.
     */
    protected function appChangePassword(string $email, string $password): void
    {
        try {
            Http::asForm()->post('https://admin.bookstore.bfcpublications.com/api/webChangePassword', [
                'email'            => $email,
                'confirm_password' => $password,
            ]);
        } catch (\Throwable $e) {
            // Non-fatal, as in the original.
        }
    }

    /**
     * Tally UnitsSold per marketplace for a set of sale rows.
     * Returns [flipkart, gpay, kdp, amazoncount, bfc].
     */
    protected function tallyMarketplaces($sales): array
    {
        $flipkart = 0; $amazoncount = 0; $gpay = 0; $kdp = 0; $bfc = 0;

        foreach ($sales as $saleData) {
            if ($saleData->Marketplace == "Flipkart" && $saleData->UnitsSold >= 1) {
                $flipkart += $saleData->UnitsSold;
            } elseif ($saleData->Marketplace == "Flipkart" && $saleData->UnitsSold < 0) {
                $flipkart += $saleData->UnitsSold;
            }

            if ($saleData->Marketplace == "GooglePlay" && $saleData->UnitsSold >= 1) {
                $gpay += $saleData->UnitsSold;
            } elseif ($saleData->Marketplace == "GooglePlay" && $saleData->UnitsSold <= -1) {
                $gpay += $saleData->UnitsSold;
            }

            if ($saleData->Marketplace == "KDP" && $saleData->UnitsSold >= 1) {
                $kdp += $saleData->UnitsSold;
            } elseif ($saleData->Marketplace == "KDP" && $saleData->UnitsSold <= -1) {
                $kdp += $saleData->UnitsSold;
            }

            if ($saleData->Marketplace == "Amazon" && $saleData->UnitsSold >= 1) {
                $amazoncount += $saleData->UnitsSold;
            } elseif ($saleData->Marketplace == "Amazon" && $saleData->UnitsSold <= -1) {
                $amazoncount += $saleData->UnitsSold;
            }

            if ($saleData->Marketplace == "bfc" && $saleData->UnitsSold >= 1) {
                $bfc += $saleData->UnitsSold;
            } elseif ($saleData->Marketplace == "bfc" && $saleData->UnitsSold <= -1) {
                $bfc += $saleData->UnitsSold;
            }
        }

        return [$flipkart, $gpay, $kdp, $amazoncount, $bfc];
    }

    /**
     * Build the JSON payload shared by getbookDetails / getbookDetailsFilter.
     */
    protected function buildBookDetails($book, $sales): array
    {
        [$flipkart, $gpay, $kdp, $amazoncount, $bfc] = $this->tallyMarketplaces($sales);

        $profit1 = ($kdp + $gpay) * ($book->kdp ?? 0);
        $profit2 = ($amazoncount + $flipkart) * ($book->amazon ?? 0);
        $profit3 = $bfc * ($book->bfc ?? 0);

        $total_profit = $profit1 + $profit2 + $profit3;

        $flipkart    = max(0, $flipkart);
        $kdp         = max(0, $kdp);
        $gpay        = max(0, $gpay);
        $amazoncount = max(0, $amazoncount);
        $bfc         = max(0, $bfc);

        return [
            'totalSold'    => $flipkart + $gpay + $kdp + $amazoncount + $bfc,
            'total_profit' => $total_profit,
            'flipkart'     => $flipkart,
            'gpay'         => $gpay,
            'kdp'          => $kdp,
            'amazoncount'  => $amazoncount,
            'bfc'          => $bfc,
            'other'        => 0,
        ];
    }
}
