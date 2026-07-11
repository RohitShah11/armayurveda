<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class BulkEmailController extends Controller
{
    public function sendBulkMail()
    {
        $subject = "Application for Articleship - CMA Inter G1 Cleared | Simran Shah";

        $body = '
        <p>Respected Sir/Ma\'am,</p>

        <p>
        I am <strong>Simran Shah</strong>, CMA Inter student with ICMAI Reg No:
        <strong>03232044321</strong>.
        I have cleared Group 1 and appeared for Group 2 in June 2026.
        </p>

        <p>
        As per ICMAI norms, I am eligible for 15 months Practical Training.
        I wish to apply for articleship at your esteemed organization.
        </p>

        <p>
        I have basic knowledge of <strong>Tally Prime, GST, Excel and Cost Accounting</strong>.
        I am hardworking and eager to learn.
        </p>

        <p>
        Please find my CV attached for your consideration.
        Kindly let me know if I can appear for an interview.
        </p>

        <p>
        Thank you.
        </p>

        <br>

        <p>
        Yours faithfully,<br>
        <strong>Simran Shah</strong><br>
        📞 6291528847<br>
        ✉ simranshah027@gmail.com<br>
        Kolkata
        </p>
        ';

        $emails = [
            'srija@vitwo.in',
            'adpvt71@gmail.com',
            'aktassociates@gmail.com',
            'lokesh@tibrewalca.com',
            'sunil120463@gmail.com',
            'aassaahimol@gmail.com',
            'acam.const@gmail.com',
            'acctsolu2015@gmail.com',
            'achassociates@gmail.com',
            'dandapat1376@gmail.com',
            'adishwarimpex@gmail.com',
            'nihitdalmia@gmail.com',
            'pladf12@gmail.com',
            'info@affinityglobal.in'
        ];

        foreach ($emails as $email) {

            Mail::send([], [], function ($message) use ($email, $subject, $body) {

                $message->to($email)
                        ->subject($subject)
                        ->html($body)

                        // Change this path to your resume location
                        ->attach(public_path('Simran_Shah_CV_CMA_Articleship.pdf'));

            });

            sleep(1); // Optional delay
        }

        return "Emails Sent Successfully";
    }
}