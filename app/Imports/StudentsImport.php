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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    private $errors = [];

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
            $errorMsg = 'Row ' . $this->rows . ': Missing required fields (student_id, name, email, year)';
            Log::error($errorMsg, $row);
            $this->failedRows++;
            $this->errors[] = $errorMsg;
            $this->debug[] = $errorMsg;
            return null;
        }

        // Check if student with this ID or email already exists
        $existingStudent = Student::where('student_id', $row['student_id'])
                                  ->orWhere('email', $row['email'])
                                  ->first();

        if ($existingStudent) {
            $errorMsg = 'Row ' . $this->rows . ': Student already exists (ID: ' . $row['student_id'] . ', Email: ' . $row['email'] . ')';
            Log::warning($errorMsg);
            $this->failedRows++;
            $this->errors[] = $errorMsg;
            $this->debug[] = $errorMsg;
            return null;
        }

        try {
            // Ensure year is integer
            $year = (int)$row['year'];
            
            // Validate year is between 1-5 (updated to 5 years)
            if ($year < 1 || $year > 5) {
                $errorMsg = 'Row ' . $this->rows . ': Year must be 1,2,3,4,5 (got: ' . $row['year'] . ')';
                Log::error($errorMsg);
                $this->failedRows++;
                $this->errors[] = $errorMsg;
                $this->debug[] = $errorMsg;
                return null;
            }
            
            // Handle batch - convert to string if it's numeric
            $batch = isset($row['batch']) ? trim($row['batch']) : date('Y');
            if (is_numeric($batch)) {
                $batch = (string)$batch; // Convert to string
            }
            
            // Handle section
            $section = isset($row['section']) ? trim($row['section']) : null;
            if ($section !== null && is_numeric($section)) {
                $section = (string)$section;
            }
            
            // Generate a random password for the student (if you have authentication)
            $password = Str::random(10);
            
            $student = new Student([
                'student_id' => trim($row['student_id']),
                'name'       => trim($row['name']),
                'email'      => trim($row['email']),
                'phone'      => isset($row['phone']) ? trim($row['phone']) : null,
                'program'    => isset($row['program']) ? trim($row['program']) : 'Computer Science',
                'year'       => $year,
                'section'    => $section,
                'batch'      => $batch,
                'address'    => isset($row['address']) ? trim($row['address']) : null,
                'status'     => 'active',
                // 'password' => Hash::make($password), // Uncomment if you have authentication
            ]);
            
            $student->save(); // Explicitly save to catch any errors
            
            $this->successfulRows++;
            Log::info('Student created successfully', [
                'student_id' => $row['student_id'], 
                'id' => $student->id,
                'email' => $row['email']
            ]);
            $this->debug[] = 'Row ' . $this->rows . ': SUCCESS - ' . $row['student_id'] . ' (' . $row['name'] . ')';
            
            return $student;
            
        } catch (\Exception $e) {
            $errorMsg = 'Row ' . $this->rows . ': Database Error - ' . $e->getMessage();
            Log::error('Error creating student: ' . $e->getMessage(), [
                'row' => $row,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->failedRows++;
            $this->errors[] = $errorMsg;
            $this->debug[] = $errorMsg;
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'year' => 'required|integer|min:1|max:5',
            'section' => 'nullable|string|max:10',
            'batch' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'program' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'student_id.required' => 'Student ID is required',
            'student_id.max' => 'Student ID must not exceed 255 characters',
            'name.required' => 'Student name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email address is already registered',
            'year.required' => 'Year of study is required',
            'year.min' => 'Year must be between 1 and 5',
            'year.max' => 'Year must be between 1 and 5',
            'batch.string' => 'Batch must be a valid year (e.g., 2016)',
        ];
    }

    /**
     * Prepare the data for validation
     */
    public function prepareForValidation($data, $index)
    {
        // Trim all string values
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }
        
        // Convert batch to string if it's numeric
        if (isset($data['batch']) && is_numeric($data['batch'])) {
            $data['batch'] = (string)$data['batch'];
        }
        
        // Convert section to string if it's numeric
        if (isset($data['section']) && is_numeric($data['section'])) {
            $data['section'] = (string)$data['section'];
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
            $this->errors[] = $errorMsg;
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
     * Get error list
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get summary of import
     */
    public function getSummary(): array
    {
        return [
            'total_rows' => $this->rows,
            'successful' => $this->successfulRows,
            'failed' => $this->failedRows,
            'errors' => $this->errors,
            'debug' => $this->debug,
        ];
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