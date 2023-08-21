<?php

namespace App\Http\Controllers\Contoh;


use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Models\Contoh\Transaksi;
use App\Models\Contoh\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\PaginationResource;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class TransaksiController extends Controller
{

    public function generateNUmber()
    {
        $nomorRandom = random_int(1000, 9999);
        $nomor =  Carbon::now()->format('Ym').$nomorRandom;
        $data['nomor'] = $nomor;
        return $this->success($data,'save data success');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $limit = $request->limit;
        $nomor = $request->nomor;
        $tgl = $request->tgl;
        // $division_id = $request->division_id;


        $orderCol = $request->order_col ? $request->order_col : 'id';
        $orderType = $request->order_type ? $request->order_type : 'asc';

        $transaksi = Transaksi::/*with('division')->*/where(function ($f) use ($nomor) {
            if ($nomor && $nomor != '' && $nomor != 'null') {
                $f->where('nomor', 'LIKE', '%' . $nomor . '%');
        }
        // })->where(function ($f) use ($division_id) {
        //     if ($division_id && $division_id != '' && $division_id != 'null') {
        //         $f->where('division_id', '=', $division_id);
        //     }
        })

            ->orderBy($orderCol, $orderType)->paginate($limit);

        $data['paging'] = new PaginationResource($transaksi);
        $data['records'] = $transaksi;

        return $this->success($data, 'get records data success');
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
     * @param TransaksiRequest $request
     * @return JsonResponse
     */
    public function store(TransaksiRequest $request): JsonResponse
    {

        Try{
            DB::beginTransaction();
            $transaksi = new Transaksi();
            $transaksi->nomor =$request->nomor;
            // $transDetail->division_id =$detail['division_id'];
            $transaksi->tgl =$request->tgl;
            $transaksi->total =0;
            $transaksi->save();

            $details = $request->details;
            $total = 0;
            foreach($details as $detail){
                $transDetail = new TransaksiDetail();
                $transDetail->transaksi_id = $transaksi->id;
                $transDetail->division_id =$detail['division_id'];
                $transDetail->qty =$detail['qty'];
                $transDetail->harga =$detail['harga'];
                $transDetail->save();
                $total = $total+ ($detail['qty']*$detail['harga']);
            }
            $transaksi->total =$total;
            $transaksi->save();
            DB::commit();
            return $this->success($transaksi,'save data success');
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(),'ERROR.INTERNAL_SERVER_ERROR',  500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        return $this->success($transaksi, 'get record success');
    }

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
    public function update(TransaksiRequest $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->tgl = $request->tgl;
        $transaksi->division_id = $request->division_id;
        $transaksi->qty = $request->qty;
        $transaksi->save();
        return $this->success($transaksi, 'update data success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();

        return $this->success(null, 'delete data success');
    }
}
