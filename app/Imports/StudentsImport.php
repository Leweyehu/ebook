<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;

class StudentsImport implements 
    ToModel, 
    WithHeadingRow, 
    WithValidation, 
    WithBatchInserts, 
    WithChunkReading,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $rows = 0;
    private $successfulRows = 0;
    private $failedRows = 0;
    private $debug = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rows++;
        
        // Log the row being processed for debugging
        Log::info('Processing row: ' . json_encode($row));
        $this->debug[] = 'Processing row ' . $this->rows . ': ' . json_encode($row);
        
        // Check if required fields exist
        if (!isset($row['student_id']) || !isset($row['name']) || !isset($row['email']) || !isset($row['year'])) {
            Log::error('Missing required fields', $row);
            $this->failedRows++;
            $this->debug[] = 'Row ' . $this->rows . ': Missing required fields';
            return null;
        }

        // Check if student with this ID or email already exists
        $existingStudent = Student::where('student_id', $row['student_id'])
                                  ->orWhere('email', $row['email'])
                                  ->first();

        if ($existingStudent) {
            Log::warning('Student already exists', ['student_id' => $row['student_id'], 'email' => $row['email']]);
            $this->failedRows++;
            $this->debug[] = 'Row ' . $this->rows . ': Student already exists (ID: ' . $row['student_id'] . ')';
            return null;
        }

        try {
            // Ensure year is integer
            $year = (int)$row['year'];
            
            // Validate year is between 1-4
            if ($year < 1 || $year > 4) {
                Log::error('Invalid year value', ['year' => $row['year']]);
                $this->failedRows++;
                $this->debug[] = 'Row ' . $this->rows . ': Year must be 1,2,3,4 (got: ' . $row['year'] . ')';
                return null;
            }
            
            // Handle batch - convert to string if it's numeric
            $batch = isset($row['batch']) ? trim($row['batch']) : date('Y');
            if (is_numeric($batch)) {
                $batch = (string)$batch; // Convert to string
            }
            
            $student = new Student([
                'student_id' => trim($row['student_id']),
                'name'       => trim($row['name']),
                'email'      => trim($row['email']),
                'year'       => $year,
                'section'    => isset($row['section']) ? trim($row['section']) : null,
                'batch'      => $batch,
                'is_active'  => true,
            ]);
            
            $student->save(); // Explicitly save to catch any errors
            
            $this->successfulRows++;
            Log::info('Student created successfully', ['student_id' => $row['student_id'], 'id' => $student->id]);
            $this->debug[] = 'Row ' . $this->rows . ': Success - ' . $row['student_id'];
            
            return $student;
            
        } catch (\Exception $e) {
            Log::error('Error creating student: ' . $e->getMessage(), [
                'row' => $row,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->failedRows++;
            $this->debug[] = 'Row ' . $this->rows . ': Error - ' . $e->getMessage();
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'year' => 'required|integer|min:1|max:4',
            'section' => 'nullable|string|max:10',
            'batch' => 'nullable|string|max:10', // Now accepts strings
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'student_id.required' => 'Student ID is required',
            'name.required' => 'Student name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'year.required' => 'Year of study is required',
            'year.min' => 'Year must be between 1 and 4',
            'year.max' => 'Year must be between 1 and 4',
            'batch.string' => 'Batch must be a valid year (e.g., 2016)',
        ];
    }

    /**
     * Prepare the data for validation
     */
    public function prepareForValidation($data, $index)
    {
        // Convert batch to string if it's numeric
        if (isset($data['batch']) && is_numeric($data['batch'])) {
            $data['batch'] = (string)$data['batch'];
        }
        
        return $data;
    }

    /**
     * Handle a validation failure
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failedRows++;
            $errorMsg = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            $this->debug[] = $errorMsg;
            
            Log::warning('Import validation failed', [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ]);
        }
    }

    /**
     * Get the total number of rows processed
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    /**
     * Get number of successful imports
     */
    public function getSuccessfulCount(): int
    {
        return $this->successfulRows;
    }

    /**
     * Get number of failed imports
     */
    public function getFailedCount(): int
    {
        return $this->failedRows;
    }

    /**
     * Get debug information
     */
    public function getDebug(): array
    {
        return $this->debug;
    }

    /**
     * Batch insert size for better performance
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size for reading the file
     */
    public function chunkSize(): int
    {
        return 100;
    }
}