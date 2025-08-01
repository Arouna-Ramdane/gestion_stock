
@extends('layouts.base_no_dashbord')

@section('content')

   <div class="bg-blue-200 flex flex-col items-center justify-center h-full">
        <form action="{{route('login')}}" method="post" class="bg-white p-5 sm:w-lg">
            <h1 class="flex flex-col items-center justify-center text-2xl font-bold">Login page</h1>
                @php
            $token=csrf_token();
            @endphp
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">email</legend>
                    <input type="email" class="input w-full" name="email" placeholder="exemple@ifnti.com" required />
                    @error ('email')
                        <p class="label text-red-400">{{$message}}</p>
                    @enderror
                </fieldset>
            </div>
            <input type=text value='{{$token}}' name='_token' hidden/>


        <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">password</legend>
                    <input type="password" class="input w-full" name="password" required />
                    @error ('password')
                        <p class="label text-red-400">{{$message}}</p>
                    @enderror
                </fieldset>
            </div>
            <br>
            <button type="submit" class="btn btn-neutral w-full">LOGIN</button>
        </form>
    </div>
@endsection
