<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Report $report = null)
    {
        return $user->can('reports.general.list.all')
            || $user->can('reports.list.all')
            || $user->can('reports.list.associated');
    }

    public function viewGeneral(User $user, Report $report = null)
    {
        return $user->can('reports.general.list.all');
    }

    public function viewGenerated(User $user, Report $report = null)
    {
        return $user->can('reports.list.all') || $user->can('reports.list.associated');
    }

    public function download(User $user, Report $report)
    {
        if ($user->can('reports.download.all')) {
            return true;
        }
        if ($user->can('reports.download.associated')) {
            return $user->id === $report->created_by;
        }
        return false;
    }

    public function delete(User $user, Report $report)
    {
        if ($user->can('reports.delete.all')) {
            return true;
        }
        if ($user->can('reports.delete.associated')) {
            return $user->id === $report->created_by;
        }
        return false;
    }
}
