@extends('layouts.include.dark')
@section('title','Report a Problem')
@section('content')

<head>
    <style>
        h2 {
            color: #0056b3;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 0.4rem;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 600;
            margin-bottom: 0;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            resize: vertical;
        }

        textarea {
            min-height: 120px;
        }

        button {
            color: #fff;

            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }



        .note {
            background-color: var(--incoming-bg);
            color: var(--txt-color);
            padding: 1rem;
            border-radius: 6px;
            margin: 1.5rem 0;
            font-size: 0.95rem;
        }

        footer {
            background-color: #003d80;
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }

            header h1 {
                font-size: 1.9rem;
            }

            nav {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <section class="container-content" id="report-issue-section">
        <div class="cover">
            <div class="power-btn"></div>
            <div class="volume-btn"></div>
            <div class="phone">
                <div class="d-flex align-item-center justify-content-center">
                    <div class="eyeland">
                        <div class="camera"></div>
                    </div>
                </div>

                <div class="viewport p-3">
                    <header class="header">
                        <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
                        <span class="mx-auto">Report an Issue</span>
                        <button type="button" onclick="return location.href='/report-problem-history'"><i class="fa fa-history"></i></button>
                    </header>
                    <div class="container-fluid">
                        <div class="note">
                            Please describe your issue clearly. Our support team will review it and respond within 24–48 hours.
                        </div>

                        <form action="{{route('report.problem')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label class="text" for="category">Issue Category <span class="text-danger">*</span></label>
                            <select id="category" name="category" required>
                                <option value="">Choose a category</option>
                                <option value="booking">Booking Issue</option>
                                <option value="technical">Technical Glitch</option>
                                <option value="account">Account issue</option>
                                <option value="other">Other</option>
                            </select>

                            <label class="text" for="description">Describe the Issue <span class="text-danger">*</span></label>
                            <textarea id="description" name="description" placeholder="Provide as much detail as possible..." required></textarea>

                            <label class="text" for="screenshot">Attach Screenshot (optional)</label>
                            <input type="file" id="screenshot" class="text" name="screenshot" accept="image/*">
                            <button type="submit" class="btn btn-primary ">Submit Issue</button>
                            @if (session()->has('success'))
                            <script>
                                window.onload = () => {
                                    Swal.fire({
                                        position: "top",
                                        toast: true,
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true,
                                        icon: "success",
                                        title: "{{session()->get('success')}}"
                                    });
                                }
                            </script>
                            @endif


                            @if ($errors->any())
                            <div class="text-center mt-4">
                                @foreach ($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
    @endsection