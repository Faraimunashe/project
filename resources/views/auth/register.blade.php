<x-guest-layout>
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Register New Account</h5>
            <p class="text-center small">Enter your account details to register</p>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="row g-3">
            @csrf
            <div class="col-12">
                <x-input-label for="name" :value="__('Name')" />
                <div class="input-group">
                    <div class="col-md-12">
                        <input id="name" class="form-control" type="text" name="name" :value="old('name')"/>
                    </div>
                </div>
            </div>

            <!-- Email Address -->
            <div class="col-12">
                <x-input-label for="email" :value="__('Email')" />
                <div class="input-group">
                    <div class="col-md-12">
                        <input id="email" class="form-control" type="email" name="email" :value="old('email')"/>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <x-input-label for="password" :value="__('Password')" />
                <div class="input-group">
                    <div class="col-md-12">
                        <input id="password" class="form-control" type="password" name="password" autocomplete="new-password" />
                    </div>
                </div>
            </div>

            <div class="col-12">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <div class="input-group">
                    <div class="col-md-12">
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"/>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
