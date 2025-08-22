<?php

namespace Database\Seeders;

use App\Models\AMWorker;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();
        
        if ($tenants->isEmpty()) {
            $this->command->warn('No tenants found. Skipping worker seeding.');
            return;
        }
        
        // CSV data from the Base worker.csv file
        $workersData = [
            ['000001', '1972-03-06', '', '1900-01-01', '1900-01-01', '', 'White', 'Jodi', 'Female', 'No', 'No', '', 'en-us', 'Christiansen', '', '', 'Jodi Christiansen', '', 'English', '', '', '', '', 'jodi@contoso.com'],
            ['000002', '1945-05-06', '', '1900-01-01', '1900-01-01', '', 'White', 'Charlie', 'Male', 'No', 'No', '', 'en-us', 'Carson', '', '', 'Charlie Carson', '', 'English', '', '', '', 'USA', 'Charlie@contoso.com'],
            ['000003', '1965-07-02', '', '1900-01-01', '1900-01-01', '', 'White', 'Ted', 'Male', 'No', 'No', '', 'en-us', 'Howard', '', '', 'Ted Howard', '', 'English', '', '', '', '', 'ted@contoso.com'],
            ['000004', '1976-08-05', '', '1900-01-01', '1900-01-01', '', 'Asian', 'Luke', 'Male', 'No', 'No', '', 'en-us', 'Lenhart', '', '', 'Luke Lenhart', '', 'French', '', '', '', '', 'luke@contoso.com'],
            ['000005', '1955-05-04', '', '1900-01-01', '2006-08-11', '', 'Native Hawaiian', 'Theresa', 'Female', 'Yes', 'No', '', 'en-us', 'Jayne', '', '', 'Theresa Jayne', '', 'English', '', '', '', '', 'theresa@contoso.com'],
            ['000006', '1973-03-01', '', '1900-01-01', '1900-01-01', '', 'Native Hawaiian', 'Benjamin', 'Male', 'No', 'No', '', 'en-us', 'Martin', '', '', 'Benjamin Martin', '', 'English', '', '', '', '', 'benjaminm@contoso.com'],
            ['000007', '1975-05-21', '', '1900-01-01', '1900-01-01', '', 'White', 'Sara', 'Female', 'No', 'No', '', 'en-us', 'Thomas', '', '', 'Sara Thomas', '', 'English', '', '', '', '', 'Sara@contoso.com'],
            ['000008', '1965-07-25', '', '1900-01-01', '1900-01-01', '', 'Hispanic/Latino', 'Pierre', 'Male', 'No', 'No', '', 'en-us', 'Hezi', '', '', 'Pierre Hezi', '', 'French', '', '', '', '', 'pierre@contoso.com'],
            ['000009', '1983-04-13', '', '1900-01-01', '1900-01-01', '', 'Black/African', 'Takashi', 'Female', 'No', 'No', '', 'en-us', 'Andrews', '', '', 'Takashi Andrews', '', 'English', '', '', '', '', 'takashi@contoso.com'],
            ['000010', '1961-11-16', '', '1900-01-01', '1900-01-01', '', 'Hispanic/Latino', 'Ellen', 'Female', 'No', 'No', '', 'en-us', 'Gasca', '', '', 'Ellen Gasca', '', 'Spanish', '', '', '', '', 'ellen@contoso.com'],
            ['000011', '1979-01-09', '', '1900-01-01', '1900-01-01', '', 'Asian', 'Mia', 'Female', 'No', 'No', '', 'en-us', 'Vanclooster', '', '', 'Mia Vanclooster', '', 'English', '', '', '', '', 'mia@contoso.com'],
            ['000012', '1980-06-05', '', '1900-01-01', '1900-01-01', '', 'Asian', 'Inga', 'Female', 'No', 'No', '', 'en-us', 'Numadutir', '', '', 'Inga Numadutir', '', 'English', '', '', '', '', 'inga@contoso.com'],
            ['000013', '1988-03-01', '', '1900-01-01', '1900-01-01', '', 'Black/African', 'Lars', 'Male', 'No', 'No', '', 'en-us', 'Giusti', '', '', 'Lars Giusti', '', 'French', '', '', '', '', 'lars@contoso.com'],
            ['000014', '1975-04-07', '', '1900-01-01', '1900-01-01', '', 'Black/African', 'Arnie', 'Male', 'No', 'No', '', 'en-us', 'Mondloch', '', '', 'Arnie Mondloch', '', 'English', '', '', '', '', 'arnie@contoso.com'],
            ['000015', '1976-07-05', '', '1900-01-01', '1900-01-01', '', 'White', 'Terrence', 'Male', 'No', 'No', '', 'en-us', 'Dorsey', '', '', 'Terrence Dorsey', '', 'English', '', '', '', '', 'Terrence@contoso.com'],
            ['000016', '1982-05-08', '', '1900-01-01', '1900-01-01', '', 'Native Hawaiian', 'John', 'Male', 'No', 'No', '', 'en-us', 'Emory', '', '', 'John Emory', '', '', '', '', '', '', 'john@contoso.com'],
            ['000017', '1971-05-07', '', '1900-01-01', '1900-01-01', '', 'White', 'June', 'Female', 'No', 'No', '', 'en-us', 'Low', '', '', 'June Low', '', 'English', '', '', '', '', 'junel@contoso.com'],
            ['000018', '1983-08-09', '', '1900-01-01', '1900-01-01', '', 'White', 'Shannon', 'Female', 'No', 'No', '', 'en-us', 'Dascher', '', '', 'Shannon Dascher', '', 'English', '', '', '', '', 'Shannon@contoso.com'],
            ['000019', '1962-09-23', '', '1900-01-01', '1900-01-01', '', 'Black/African', 'Emil', 'Male', 'No', 'No', '', 'en-us', 'Karafezov', '', '', 'Emil Karafezov', '', 'English', '', '', '', '', 'emil@contoso.com'],
            ['000020', '1960-06-07', '', '1900-01-01', '1900-01-01', '', 'White', 'Julia', 'Female', 'No', 'No', '', 'en-us', 'Funderburk', '', '', 'Julia Funderburk', '', 'English', '', '', '', '', 'julia@contoso.com'],
            ['000021', '1983-08-05', '', '1900-01-01', '1900-01-01', '', 'White', 'Reina', 'Female', 'No', 'No', '', 'en-us', 'Cabatana', '', '', 'Reina Cabatana', '', 'English', '', '', '', '', 'reina@contoso.com'],
            ['000022', '1973-06-13', '', '1900-01-01', '1900-01-01', '', 'White', 'Tony', 'Male', 'No', 'No', '', 'en-us', 'Krijnen', '', '', 'Tony Krijnen', '', 'English', '', '', '', '', 'tonyk@contoso.com'],
            ['000023', '1977-10-23', '', '1900-01-01', '1900-01-01', '', 'Two or More', 'Ahmed', 'Male', 'No', 'No', '', 'en-us', 'Barnett', '', '', 'Ahmed Barnett', '', 'English', '', '', '', '', 'ahmed@contoso.com'],
            ['000024', '1962-03-01', '', '1900-01-01', '1900-01-01', '', 'White', 'Claire', 'Female', 'No', 'No', '', 'en-us', 'Kennedy', '', '', 'Claire Kennedy', '', 'English', '', '', '', '', 'Claire@contoso.com'],
            ['000025', '1976-02-29', '', '1900-01-01', '1900-01-01', '', 'White', 'Tricia', 'Female', 'No', 'No', '', 'en-us', 'Fejfar', '', '', 'Tricia Fejfar', '', 'English', '', '', '', '', 'tricia@contoso.com'],
            ['000026', '1974-07-09', '', '1900-01-01', '1900-01-01', '', 'Hispanic/Latino', 'Vince', 'Male', 'No', 'No', '', 'en-us', 'Prado', '', '', 'Vince Prado', '', 'Spanish', '', '', '', '', 'vincep@contoso.com'],
            ['000027', '1974-02-19', '', '1900-01-01', '1900-01-01', '', 'White', 'Tim', 'Male', 'No', 'No', '', 'en-us', 'Litton', '', '', 'Tim Litton', '', 'English', '', '', '', '', 'tim@contoso.com'],
            ['000028', '1976-04-01', '', '1900-01-01', '1900-01-01', '', 'White', 'Alicia', 'Female', 'No', 'No', '', 'en-us', 'Thornber', '', '', 'Alicia Thornber', '', 'English', '', '', 'USA', 'alicia@contoso.com'],
            ['000029', '1983-12-17', '', '1900-01-01', '1900-01-01', '', 'Hispanic/Latino', 'Sammy', 'Male', 'No', 'No', '', 'en-us', 'Isales', '', '', 'Sammy Isales', '', 'Spanish', '', '', '', '', 'sammy@contoso.com'],
            ['000030', '1988-07-07', '', '1900-01-01', '1900-01-01', '', 'Two or More', 'Prakash', 'Male', 'No', 'No', '', 'en-us', 'Kovvuru', '', '', 'Prakash Kovvuru', '', 'English', '', '', '', '', 'Prakash@contoso.com'],
        ];
        
        foreach ($tenants as $tenant) {
            $this->command->info("Seeding workers for tenant: {$tenant->name}");
            
                            foreach ($workersData as $workerData) {
                    // Convert '1900-01-01' dates to null (these appear to be placeholder dates)
                    $birthdate = $workerData[1] !== '1900-01-01' ? $workerData[1] : null;
                    $deceasedDate = $workerData[3] !== '1900-01-01' ? $workerData[3] : null;
                    $disabledVerificationDate = $workerData[4] !== '1900-01-01' ? $workerData[4] : null;
                    
                    // Convert Yes/No to boolean
                    $isDisabled = $workerData[9] === 'Yes';
                    $isFullTimeStudent = $workerData[10] === 'Yes';
                    
                    // Handle email, city, and country region mapping
                    // Column 21: PersonBirthCity, Column 22: PersonBirthCountryRegion, Column 23: PrimaryContactEmail
                    $email = isset($workerData[23]) ? $workerData[23] : null;
                    $birthCity = isset($workerData[21]) ? $workerData[21] : null;
                    $birthCountryRegion = isset($workerData[22]) ? $workerData[22] : null;
                    
                    AMWorker::firstOrCreate([
                        'personnel_number' => $workerData[0],
                        'tenant_id' => $tenant->id,
                    ], [
                        'birthdate' => $birthdate,
                        'citizenship_country_region' => isset($workerData[2]) ? $workerData[2] : null,
                        'deceased_date' => $deceasedDate,
                        'disabled_verification_date' => $disabledVerificationDate,
                        'education' => isset($workerData[5]) ? $workerData[5] : null,
                        'ethnic_origin_id' => isset($workerData[6]) ? $workerData[6] : null,
                        'first_name' => $workerData[7],
                        'gender' => isset($workerData[8]) ? $workerData[8] : null,
                        'is_disabled' => $isDisabled,
                        'is_full_time_student' => $isFullTimeStudent,
                        'known_as' => isset($workerData[11]) ? $workerData[11] : null,
                        'language_id' => isset($workerData[12]) ? $workerData[12] : null,
                        'last_name' => $workerData[13],
                        'last_name_prefix' => isset($workerData[14]) ? $workerData[14] : null,
                        'middle_name' => isset($workerData[15]) ? $workerData[15] : null,
                        'name' => $workerData[16],
                        'nationality_country_region' => isset($workerData[17]) ? $workerData[17] : null,
                        'native_language_id' => isset($workerData[18]) ? $workerData[18] : null,
                        'personal_suffix' => isset($workerData[19]) ? $workerData[19] : null,
                        'personal_title' => isset($workerData[20]) ? $workerData[20] : null,
                        'person_birth_city' => $birthCity,
                        'person_birth_country_region' => $birthCountryRegion,
                        'primary_contact_email' => $email,
                    ]);
                }
        }
        
        $this->command->info('Worker seeding completed successfully!');
    }
}
