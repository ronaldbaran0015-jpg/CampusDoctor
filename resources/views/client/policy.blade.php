@extends('layouts.include.dark')
@section('title','FAQ')
@section('content')

<head>
    <style>
        section {
            margin-bottom: 2rem;
        }

        h2 {
            color: #0056b3;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 0.4rem;
            font-size: 16px;
            margin-bottom: 1rem;
            color: var(--txt-color);
        }

        .contact-box {
            background-color: #f0f4fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .faq-item {
            margin-bottom: 1.5rem;
        }

        .faq-item h3 {
            margin-bottom: 0.3rem;
            color: var(--txt-color);
            font-size: 16px;
        }

        .faq-item p,
        a {

            color: var(--txt-color);


        }
    </style>
</head>
<section class="container-content" id="policy-section">
    <div class="viewport p-3">
        <header class="header  mb-3">
            <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            <span class="mx-auto">FAQ</span>
        </header>
        <div class="container-fluid">
            <section id="faq">
                <h2>💡 Frequently Asked Questions</h2>
                <div class="faq-item">
                    <h3>1. How do I reset my CampusDoctor password?</h3>
                    <p class="text">Go to the <a href="#">Password Reset Page</a>, enter your student email, and follow the instructions sent to your inbox.</p>
                </div>

                <div class="faq-item">
                    <h3>2. How can I book an appointment with doctors?</h3>
                    <p class="text">In your homepage go to doctors and click on <strong>View</strong> then select time and date the press <strong> book now</strong> .</p>
                </div>

                <div class="faq-item">
                    <h3>3. Who do I contact for technical issues?</h3>
                    <p class="text">If you’re experiencing login or technical issues, please reach out to <a href="mailto:techsupport@CampusDoctor.edu">techsupport@CampusDoctor.edu</a>.</p>
                </div>


            </section>



            <section id="privacy">
                <h2>🔐 Privacy & Data Protection</h2>
                <p class="text">Your information is protected under university privacy policies. We use secure servers and encryption to ensure your data remains safe. Read our full <a href="#" class="link-primary">Privacy Policy</a>.</p>
            </section>

            <section id="help">
                <h2>❤️ Need More Help?</h2>
                <p class="text">If you can’t find what you’re looking for, our support team is here for you.</p>

            </section>
        </div>
    </div>
</section>
@endsection