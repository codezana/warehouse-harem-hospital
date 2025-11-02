<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;
use App\Models\User; // Adjust the model namespace based on your project

class UsersExport implements FromCollection, ShouldAutoSize
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [];
    }

    public function map($user): array
    {
        return [
            'Username' => $user->username,
            'Email' => $user->email,
            'Phone' => $user->phone,
            'Role' => $user->role,
            'File' => $user->file,
            'Status' => $user->status,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '@', // Format email as text
            'C' => '@', // Format phone as text
        ];
    }
}
