@extends('layouts.container-content')
@section('title', 'Account Control')
@section('content')
<style>
    .prof-card,
    .setting-card {
        background: var(--outgoing-bg);
        color: var(--txt-color);
        border: 1px solid #e4e4e4;
        border-radius: 10px;

        margin-top: 10px;
    }
</style>
@include('layouts.base_side')

<main class="main-content shadow-sm">
    <div class="container-content">
        <section class="viewport p-3" id="account-control-section">

            <header class="header d-flex mb-4">
                <a href="javascript:history.back()" class="nav-link"> <i class="fa fa-chevron-left"></i></a>
            </header>
            <div class="container-fluid">
                <h1 class="fw-bold top-heading"><i class="fa fa-warning"></i> Account Ownership and control</h1>
                <form action="{{ route('account.update-status') }}" method="post" id="accountForm">
                    @csrf
                    <div class="prof-card p-3">
                        <label for="deactivate" class="d-flex align-items-center justify-content-between">
                            <aside>
                                <h1 class="sub-heading">Deactivate account</h1>
                                <p class="text fw-light">Temporarily deactivate your account</p>
                            </aside>
                            <input type="radio" name="opt" value="deactivate" id="deactivate" checked>
                        </label>
                        <label for="delete" class="d-flex align-items-center justify-content-between">
                            <aside>
                                <h1 class="sub-heading">Delete account</h1>
                                <p class="text fw-light">Permanently delete your account</p>
                            </aside>
                            <input type="radio" name="opt" value="delete" id="delete">
                        </label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary rounded w-100">Continue</button>
                    <input type="hidden" name="current_password" id="current_password">
                </form>


                @if ($errors->any())
                <div class="text-center text-danger">
                    @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                    @endforeach
                </div>
                @endif
                @if (session('success'))
                <div class="text-center text-danger">
                    <span class="alert alert-success">Success</span>
                </div>
                @endif
            </div>
        </section>

        <script>
            document.getElementById('accountForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const selectedOption = document.querySelector('input[name="opt"]:checked').value;
                const title = selectedOption === 'deactivate' ? 'Deactivate Account' : 'Delete Account';
                const text = selectedOption === 'deactivate' ?
                    'Are you sure you want to deactivate your account?' :
                    'Are you sure you want to permanently delete your account? This action cannot be undone.';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Confirm Password',
                            text: 'Enter your current password to continue',
                            input: 'password',
                            showCancelButton: true,
                            confirmButtonText: 'Confirm',
                            cancelButtonText: 'Cancel',
                            inputValidator: (password) => !password ? 'Password is required' : null
                        }).then((passwordResult) => {
                            if (passwordResult.isConfirmed && passwordResult.value) {
                                document.getElementById('current_password').value = passwordResult.value;
                                document.getElementById('accountForm').submit();
                            }
                        });
                    }
                });
            });
        </script>
    </div>
</main>

@endsection