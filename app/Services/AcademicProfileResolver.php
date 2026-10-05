<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Department;
use Illuminate\Validation\ValidationException;

/**
 * Translates the human-friendly academic values that clients already send
 * (department name, academic year label, year level) into the relational
 * ids that students / teachers now store.
 */
class AcademicProfileResolver
{
    /**
     * Resolve a department from an explicit id, or from a name / code.
     *
     * @throws ValidationException when a value was supplied but matches nothing.
     */
    public function resolveDepartmentId(?int $departmentId, ?string $nameOrCode, string $errorKey = 'department'): ?int
    {
        if ($departmentId) {
            return $departmentId;
        }

        if (blank($nameOrCode)) {
            return null;
        }

        $needle = mb_strtolower(trim($nameOrCode));

        $department = Department::query()
            ->whereRaw('LOWER(name) = ?', [$needle])
            ->orWhereRaw('LOWER(code) = ?', [$needle])
            ->first();

        if (! $department) {
            $words = preg_split('/\s+/', trim($nameOrCode)) ?: [$nameOrCode];
            $code = count($words) > 1
                ? implode('', array_map(fn ($w) => mb_substr($w, 0, 1), $words))
                : mb_substr($nameOrCode, 0, 4);
            $base = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $code)) ?: 'DEPT';
            $code = substr($base, 0, 10);
            $suffix = 2;
            while (Department::where('code', $code)->exists()) {
                $code = substr($base, 0, 8) . $suffix++;
            }

            $department = Department::create([
                'name' => trim($nameOrCode),
                'code' => $code,
                'status' => 'active',
            ]);
        }

        return $department->id;
    }

    /**
     * Best-effort class lookup from department + academic year label + year level.
     * Returns null (never creates rows) when there is no matching class.
     */
    public function findClassId(?int $departmentId, ?string $academicYear, int|string|null $yearLevel): ?int
    {
        $level = (int) preg_replace('/\D/', '', (string) $yearLevel);

        if (! $departmentId || blank($academicYear) || $level < 1) {
            return null;
        }

        return ClassRoom::query()
            ->where('department_id', $departmentId)
            ->where('year_level', $level)
            ->whereHas('academicYear', fn ($query) => $query->where('name', trim($academicYear)))
            ->value('id');
    }
}
