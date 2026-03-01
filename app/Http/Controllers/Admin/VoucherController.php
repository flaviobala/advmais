<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'             => 'required|string|max:50|unique:vouchers,code',
            'description'      => 'nullable|string|max:255',
            'discount_percent' => 'required|integer|min:1|max:100',
            'max_uses'         => 'nullable|integer|min:0',
            'expires_at'       => 'nullable|date',
        ]);

        Voucher::create([
            'code'             => strtoupper($request->code),
            'description'      => $request->description,
            'discount_percent' => $request->discount_percent,
            'applies_to'       => 'annual',
            'category_id'      => null,
            'max_uses'         => $request->max_uses ?? 0,
            'expires_at'       => $request->expires_at,
        ]);

        return back()->with('success', 'Voucher criado com sucesso!');
    }

    public function toggle(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);

        return back()->with('success', $voucher->is_active ? 'Voucher ativado.' : 'Voucher desativado.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return back()->with('success', 'Voucher removido.');
    }
}
