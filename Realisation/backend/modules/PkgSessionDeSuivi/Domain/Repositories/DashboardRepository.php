<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getKPICounts($promotionId = null)
    {
        // Helper to apply promotion filter
        $applyFilter = function ($query) use ($promotionId) {
            if ($promotionId && $promotionId !== 'all') {
                $query->where('g.promotion_id', $promotionId);
            }
        };

        // Total check-ins
        $checkinsQuery = DB::table('student_checkins as sc')
            ->join('apprenants as a', 'sc.student_id', '=', 'a.user_id')
            ->join('groupes as g', 'a.groupe_id', '=', 'g.id');
        $applyFilter($checkinsQuery);
        $totalCheckins = $checkinsQuery->count();

        // Total AI insights
        $insightsQuery = DB::table('ai_insights as ai')
            ->join('student_checkins as sc', 'ai.student_checkin_id', '=', 'sc.id')
            ->join('apprenants as a', 'sc.student_id', '=', 'a.user_id')
            ->join('groupes as g', 'a.groupe_id', '=', 'g.id');
        $applyFilter($insightsQuery);
        $totalInsights = $insightsQuery->count();

        // Total students
        $studentsQuery = DB::table('apprenants as a')
            ->join('groupes as g', 'a.groupe_id', '=', 'g.id');
        $applyFilter($studentsQuery);
        $totalStudents = $studentsQuery->count();

        // Total checkin forms
        $formsQuery = DB::table('checkin_forms');
        if ($promotionId && $promotionId !== 'all') {
            $formsQuery->where('promotion_id', $promotionId);
        }
        $totalForms = $formsQuery->count();

        return [
            'total_checkins'       => $totalCheckins,
            'total_ai_insights'    => $totalInsights,
            'total_students'       => $totalStudents,
            'total_checkin_forms'  => $totalForms,
        ];
    }

    public function getGroupeStats($promotionId = null)
    {
        $query = DB::table('groupes as g')
            ->join('promotions as p', 'g.promotion_id', '=', 'p.id')
            ->leftJoin('apprenants as a', 'g.id', '=', 'a.groupe_id')
            ->leftJoin('student_checkins as sc', 'a.user_id', '=', 'sc.student_id');

        if ($promotionId && $promotionId !== 'all') {
            $query->where('p.id', $promotionId);
        }

        return $query->select([
                'g.nom as groupe_name',
                DB::raw('YEAR(p.start_date) as promotion_year'),
                DB::raw('COUNT(DISTINCT a.user_id) as total_students'),
                DB::raw('COUNT(DISTINCT CASE WHEN sc.id IS NOT NULL THEN a.user_id END) as students_submitted'),
                DB::raw('CASE 
                    WHEN COUNT(DISTINCT a.user_id) = 0 THEN 0
                    ELSE ROUND((COUNT(DISTINCT CASE WHEN sc.id IS NOT NULL THEN a.user_id END) * 100.0 / COUNT(DISTINCT a.user_id)), 1)
                END as percentage')
            ])
            ->groupBy('g.id', 'g.nom', DB::raw('YEAR(p.start_date)'))
            ->orderBy('percentage', 'desc')
            ->get();
    }

    public function getCheckinsByPromotion()
    {
        return DB::table('promotions as p')
            ->leftJoin('groupes as g', 'p.id', '=', 'g.promotion_id')
            ->leftJoin('apprenants as a', 'g.id', '=', 'a.groupe_id')
            ->leftJoin('student_checkins as sc', 'a.user_id', '=', 'sc.student_id')
            ->select([
                'p.name as promotion_name',
                DB::raw('COUNT(sc.id) as checkin_count')
            ])
            ->groupBy('p.id', 'p.name')
            ->orderBy('p.start_date', 'desc')
            ->get();
    }


}
