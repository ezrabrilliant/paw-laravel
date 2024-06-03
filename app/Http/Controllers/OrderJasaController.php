<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderJasaService;
use Illuminate\Support\Facades\Log;

class OrderJasaController extends Controller
{protected $orderJasaService;

    public function __construct(OrderJasaService $orderJasaService){
        $this->orderJasaService = $orderJasaService;
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'pet_name' => 'required|string|max:255',
                'pet_age' => 'required|integer',
                'pet_weight' => 'required|integer',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'address' => 'nullable|string|max:255',
                'delivery_cost' => 'nullable|integer',
                'jasa_ids' => 'required|array',
            ]);

            $hargaDelivery = 0;
            if ($request->delivery_cost) {
                $hargaDelivery = $request->delivery_cost;
            }


            $memberId = null;
            $user = Auth::user();
            if ($user) {
                $memberId = $user->member_id;
            }

            $this->orderJasaService->insertOrderJasa(
                $request->pet_name,
                $request->pet_age,
                $request->pet_weight,
                $request->check_in_date,
                $request->check_out_date,
                $request->address ?? '',
                $hargaDelivery,
                $memberId,
                $request->jasa_ids
            );
            Log::info('Data berhasil disimpan ke dalam database.');

            return redirect('/')->with('success', 'Order has been successfully submitted.');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while submitting the order.');
        }
    }

    public function penitipanCalculateOverview(Request $request, OrderJasaService $orderJasaService)
    {
        $checkInDate = $request->query('check_in_date');
        $checkOutDate = $request->query('check_out_date');
        $delivery = $request->query('delivery') === 'true';
        $address = $request->query('address', '');
        $jasa_id = $request->query('jasa_ids');

        $days = $orderJasaService->hitungHari($checkInDate, $checkOutDate);
        $serviceCost = $orderJasaService->hitungBiayaPenitipan($days, $jasa_id);

        $totalCost = $orderJasaService->addTotalHargaJasaToSubtotal(0, $serviceCost);
        $deliveryCost = 0;

        $response = [
            'days' => $days,
            'serviceCost' => $serviceCost,
            'totalCost' => $totalCost,
        ];

        if ($delivery) {
            $deliveryCost = $orderJasaService->hitungBiayaDelivery($address);
            $totalCost = $orderJasaService->addTotalHargaDeliveryToSubtotal($totalCost, $deliveryCost);
            $response['deliveryCost'] = $deliveryCost;
            $response['totalCost'] = $totalCost;
        }

        return response()->json($response);
    }
    public function groomingCalculateOverview(Request $request, OrderJasaService $orderJasaService)
    {

    $jasaData = json_decode($request->query('jasa_ids'), true);
    $jasaIds = array_map(function($jasa) {
        return $jasa['id'];
    }, $jasaData);


        $delivery = $request->query('delivery') === 'true';
        $address = $request->query('address', '');
        $totalCost = 0;

        $serviceCost = $orderJasaService->countHargaJasa($jasaIds);

        $totalCost = $orderJasaService->addTotalHargaJasaToSubtotal($totalCost, $serviceCost);
        $deliveryCost = 0;

        $response = [
            'serviceCost' => $serviceCost,
            'totalCost' => $totalCost,
        ];
        if ($delivery) {
            $deliveryCost = $orderJasaService->hitungBiayaDelivery($address);
            $totalCost = $orderJasaService->addTotalHargaDeliveryToSubtotal($totalCost, $deliveryCost);
            $response['deliveryCost'] = $deliveryCost;
            $response['totalCost'] = $totalCost;
        }
        return response()->json($response);
    }

}
