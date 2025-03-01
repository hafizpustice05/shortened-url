<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestQueryBuilderController extends Controller
{
    public function index()
    {
        $store = DB::query()
            ->select([])
            ->from("store as str")
            ->leftJoin("address as addr", "str.id", "=", "addr.id");

        $paymentDetails = DB::query()
            ->select(["cus.store_id", DB::raw("sum(pay.amount as sales")])
            ->from("customer as cus")
            ->join("payment as pay", "cus.id", "pay.id")
            ->groupBy("cus.store_id");


        $result  = DB::query()
            ->select(["storeDetails.*", "r2.*"])
            ->fromSub(function ($query) {
                $query->select(["cus.store_id", DB::raw("sum(pay.amount as sales")])
                    ->from("customer as cus")
                    ->join("payment as pay", "cus.id", "pay.id")
                    ->groupBy("cus.store_id");
            }, "storeDetails")
            ->joinSub(function ($query) {
                $query->select(["cus.store_id", DB::raw("sum(pay.amount as sales")])
                    ->from("customer as cus")
                    ->join("payment as pay", "cus.id", "pay.id")
                    ->groupBy("cus.store_id");
            }, "r2", "r2.id", "storeDetails.id")
            ->get();


        //complex join

        DB::query()
            ->select(["cat.name", DB::raw("count(f.flim_id) as flim_count")])
            ->from("category as cat")
            ->join("flim as f", "f.id", "cat.id")
            ->join("language as lan", function ($join) {
                $join
                    ->on("lan.id", "cat.id")
                    ->where("lan.name", "Bangli");
            })->groupBy("cat.name")->orderBy("flim_count", "DESC")->get();


        DB::table("flim")
            ->select(["flim.*"])
            ->where("title", "LIKE", "k%")
            ->whereIn("language_id", function ($query) {
                $query->select("language_id")
                    ->from("language")
                    ->where("name", "Benglai");
            })->orderBy("title")->get();

        //  unique row select in db
        /*
        SELECT `plan`.*,
           Ifnull(ac_plan.tax, 0) AS tax
        FROM   (SELECT DISTINCT `plan_name`,
                        `plan_id`
        FROM   `subscription_plan`) AS `plan`
       LEFT JOIN (SELECT `plan`.`plan_name`,
                         `plan`.`tax`
                  FROM   `subscription_plan` AS `plan`
                  WHERE  `plan`.`interval_count` = ?) AS `ac_plan`
              ON `ac_plan`.`plan_name` = `plan`.`plan_name` 
        */
         DB::query()
            ->select([
                'plan.*',
                DB::raw('IFNULL(ac_plan.tax, 0) as tax')
            ])
            ->fromSub(function ($query) {
                $query->select([
                    'plan_name',
                    'plan_id'
                ])
                    ->from('subscription_plan')
                    ->distinct();
            }, 'plan')
            ->leftJoinSub(function ($query) {
                $query->select('plan.plan_name', 'plan.tax')
                    ->from('subscription_plan as plan')
                    ->where('plan.interval_count', 3);
            }, 'ac_plan', 'ac_plan.plan_name', 'plan.plan_name')
            ->get();
    }
}
