<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    private const RATE_PER_DAY = 100000;

    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->whereNotNull('check_in_at')
            // ->whereNotNull('check_out_at')
            ->whereNull('invoice_id')
            ->orderBy('date', 'asc')
            ->get();

        $totalDays = $attendances->count();
        $totalAmount = $totalDays * self::RATE_PER_DAY;

        return view('invoices.create', compact('attendances', 'totalDays', 'totalAmount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance_ids' => ['required', 'array', 'min:1'],
            'attendance_ids.*' => ['exists:attendances,id'],
        ]);

        $attendanceIds = $request->attendance_ids;

        $attendances = Attendance::where('user_id', Auth::id())
            ->whereIn('id', $attendanceIds)
            ->whereNotNull('check_in_at')
            // ->whereNotNull('check_out_at')
            ->whereNull('invoice_id')
            ->get();

        if ($attendances->count() !== count($attendanceIds)) {
            return back()->with('error', 'Beberapa data presensi tidak valid atau sudah di-invoice.');
        }

        $totalDays = $attendances->count();
        $totalAmount = $totalDays * self::RATE_PER_DAY;
        $invoiceNumber = 'INV-' . Auth::id() . '-' . Carbon::now()->format('YmdHis');

        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'invoice_number' => $invoiceNumber,
            'total_days' => $totalDays,
            'total_amount' => $totalAmount,
            'status' => 'unpaid',
        ]);

        Attendance::whereIn('id', $attendanceIds)->update(['invoice_id' => $invoice->id]);

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat!');
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load('attendances');

        return view('invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load(['attendances', 'user']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:unpaid,paid'],
        ]);

        $invoice->update([
            'status' => $request->status,
        ]);

        $message = $request->status === 'paid' ? 'Invoice ditandai sebagai Lunas!' : 'Invoice ditandai sebagai Belum Lunas!';

        return back()->with('success', $message);
    }
}
