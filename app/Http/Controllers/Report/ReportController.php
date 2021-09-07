<?php

namespace App\Http\Controllers\Report;

use App\Models\Buyer;
use App\Models\Purchase;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailPurchase;

class ReportController extends Controller{
    /*
    -- Consulta de ejemplo tomado de otro proyecto..
     'candidates' => Candidate::select(['candidates.*',
                                        'countries.name as country_name',
                                        'departments.name as department_name',
                                        'professions.name as profession_name',
                                        'areas.name as area_name',
                                        'candidate_files.url as file_url'])
                        ->join('countries', 'candidates.country_id', 'countries.id')
                        ->join('departments', 'candidates.department_id', 'departments.id')
                        ->join('professions', 'candidates.profession_id', 'professions.id')
                        ->join('areas', 'candidates.area_id', 'areas.id')
                        ->leftJoin('candidate_files', 'candidates.id', 'candidate_files.candidate_id')
                        ->whereDate('candidates.created_at', '>=', $this->start_date)
                        ->whereDate('candidates.created_at', '<=', $this->end_date)->get()
    */
    /*
    $totalBuyerPurchases:
    SELECT b.name as buyer_name, SUM(dpurch.price * dpurch.kg_quantity) as purchaseTotal
            FROM buyers b inner join purchases p
            on b.id = p.buyer_id
            join detail_purchase dpurch
            on p.id = dpurch.purchase_id 
            join products pro
            on dpurch.product_id=pro.id
            GROUP BY buyer_name;
    */
    /*
    $departmentsPurchases
    SELECT dp.name as dpt_name, SUM(dpurch.price * dpurch.kg_quantity) as purchaseTotal
        FROM purchases p inner join buyers bu
        on p.buyer_id = bu.id 
        join departments dp 
        on dp.id = bu.department_id 
        join detail_purchase dpurch 
        on dpurch.purchase_id=p.id 
        join products pro 
        on dpurch.product_id=pro.id
        GROUP BY dpt_name
            ORDER BY purchaseTotal DESC;
    */

    public function index(){
        //Obtener total de todas las compras realizadas por cada comprador
        $totalBuyerPurchases = Buyer::select(['buyers.name as buyerName',
                                        DB::raw('ROUND(SUM(detail_purchase.price * detail_purchase.kg_quantity), 2) as purchaseTotal')])
                                    ->join('purchases','buyers.id','purchases.buyer_id')
                                    ->join('detail_purchase', 'purchases.id','detail_purchase.purchase_id')
                                    ->join('products','detail_purchase.product_id','products.id')
                                    ->groupBy('buyerName')
                                    ->orderBy('purchaseTotal','desc')->get();
        
         //Obtener total de todas las compras realizadas de cada departamento.. Cada buyer tiene asociado o relacionado un departamento.  
        $departmentsPurchases = Department::select(['departments.name as departmentName',
                                        DB::raw('ROUND(SUM(detail_purchase.price * detail_purchase.kg_quantity), 2) as purchasesTotal')])
                                    ->join('buyers','departments.id','buyers.department_id')
                                    ->join('purchases','buyers.id','purchases.buyer_id')
                                    ->join('detail_purchase', 'purchases.id','detail_purchase.purchase_id') 
                                    ->join('products','detail_purchase.product_id','products.id') 
                                    ->groupBy('departmentName')
                                    ->orderBy('purchasesTotal','desc')->get();
        
        return view("report.index", compact('totalBuyerPurchases','departmentsPurchases'));
    }

}
