<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\FinancialOrganization;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_accounts = BankAccount::with('financial_organization')->orderBy('id', 'DESC')->paginate(10);
        return response()->json([
            'bank_accounts' => $bank_accounts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_name'                  => 'required',
            'financial_organization_id'     => 'required | integer',
            'account_no'                    => 'required | integer',
            'branch'                        => 'required',
            'account_type'                  => 'required | integer',
            'swift_code'                    => 'required',
            'route_no'                      => 'required | integer',
        ]);

        $bank_account = BankAccount::create([
            'account_name'                  => $request->account_name,
            'financial_organization_id'     => $request->financial_organization_id,
            'account_no'                    => $request->account_no,
            'branch'                        => $request->branch,
            'account_type'                  => $request->account_type,
            'swift_code'                    => $request->swift_code,
            'route_no'                      => $request->route_no,
        ]);

        return response()->json($bank_account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'account_name'                  => 'required',
            'financial_organization_id'     => 'required | integer',
            'account_no'                    => 'required | integer',
            'branch'                        => 'required',
            'account_type'                  => 'required | integer',
            'swift_code'                    => 'required',
            'route_no'                      => 'required | integer',
        ]);

        $bank_account = $bankAccount->update([
            'account_name'                  => $request->account_name,
            'financial_organization_id'     => $request->financial_organization_id,
            'account_no'                    => $request->account_no,
            'branch'                        => $request->branch,
            'account_type'                  => $request->account_type,
            'swift_code'                    => $request->swift_code,
            'route_no'                      => $request->route_no,
        ]);

        return response()->json($bank_account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return $this->index();
    }

    //Bank List
    public function bankList(){
        $banks = FinancialOrganization::all();
        return response()->json([
            'banks' => $banks
        ], 200);
    }

    public function bankAccountsList()
    {
        $bank_accounts = BankAccount::with('financial_organization')->get();
        return response()->json([
            'bank_accounts' => $bank_accounts
        ], 200);
    }
}
