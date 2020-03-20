<?php

use App\Models\UniversityEmail;
use Illuminate\Database\Seeder;

class EmailsUniversities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $universitiesEmailArr = [
            'student.riyadh.edu.sa' ,
            'st.uqu.edu.sa',
            'sm.imamu.edu.sa',
            'stu.kau.edu.sa',
            'student.ksu.edu.sa',
            'kfupm.edu.sa',
            'nauss.edu.sa',
            'student.kfu.edu',
            'kku.edu.sa',
            'qu.edu.sa',
            'taibahu.edu.sa',
            'students.tu.edu.sa',
            'stu.jazanu.edu.sa',
            'example.com',
            'stu.bu.edu.sa',
            'stu.ut.edu.sa',
            'nu.edu.sa',
            'pnu.edu.sa',
            'ksau-hs.edu.sa',
            'iau.edu.sa',
            'kaust.edu.sa',
            'std.psau.edu.sa',
            'std.su.edu.sa',
            's.mu.edu.sa',
            'eu.edu.sa',
            'uj.edu.sa',
            'ttcollege.edu.sa',
            'uhb.edu.sa',
            'mbsc.edu.sa',
            'sr.edu.sa',
            'Ibnsina.edu.sa',
            'bmc.edu.sa',
            'alfaisal.edu',
            'alfarabi.edu.sa',
            'mcst.edu.sa',
            'riyadh.edu.sa',
            'dah.edu.sa',
            'upm.edu.sa',
            'dau.edu.sa',
            'psu.edu.sa',
            'aou.edu.om',
            'yu.edu.sa',
            'fbsu.edu.sa',
            'pmu.edu.sa',
            'ubt.edu.sa',
            'jicollege.edu.sa',
            'tctc.gov.sa',
            'amc.edu.sa',
            'tendegrees.sa'
        ];
        //
        if (UniversityEmail::count() == 0) {
            foreach ($universitiesEmailArr as $domain) {
                UniversityEmail::create([
                    'email' => $domain,
                ]);
            }
        }
    }
}
