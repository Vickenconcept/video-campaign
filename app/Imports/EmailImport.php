<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmailImport implements ToArray, WithHeadingRow, WithValidation
{
    protected $emails = [];

    public function array(array $array)
    {
        foreach ($array as $row) {
            // Look for email in common column names
            $email = null;
            
            // Check various possible column names for email
            $emailColumns = ['email', 'Email', 'EMAIL', 'e-mail', 'E-mail', 'E-Mail'];
            
            foreach ($emailColumns as $column) {
                if (isset($row[$column]) && !empty($row[$column])) {
                    $email = trim($row[$column]);
                    break;
                }
            }
            
            // If no email found, check if any column contains an email pattern
            if (!$email) {
                foreach ($row as $value) {
                    if (is_string($value) && filter_var(trim($value), FILTER_VALIDATE_EMAIL)) {
                        $email = trim($value);
                        break;
                    }
                }
            }
            
            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->emails[] = $email;
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.email' => 'nullable|email',
        ];
    }

    public function getEmails(): array
    {
        return array_unique($this->emails);
    }
} 