{{-- @extends('components.layouts.index')
@section('title')
    Login - Telemedicine
@endsection

@section('content')
    @include('components.forms.login-content')
@endsection

@section('form')
    @include('components.forms.login-form')
@endsection --}}





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen w-full bg-[#00ffb3] flex items-center justify-center">
        <div class="lg:w-[1200px] lg:h-[800px] 2xl:w-[1200px] 2xl:h-[800px] xl:w-[1200px] xl:h-[800px] bg-[#0F121C] flex justify-between shadow-lg rounded overflow-hidden xl:flex-row 2xl:flex-row lg:flex-row flex-col">
            <div class="text-white flex xl:my-20 xl:mx-12 2l:my-20 2l:mx-12 lg:my-20 lg:mx-12 my-10 mx-10">
                <div class="xl:w-[516px] space-y-4">
                    <h1 class="text-[24px] font-semibold">Welcome to the Telemedicine - Seamless Video Communication</h1>
                    <p class="text-[14px]">At Telemedicine, we bring you closer to the people who matter most with our high-quality video and audio technology. Connect instantly with our user-friendly interface and enjoy secure, private conversations.</p>
                    <ul class="list-disc ml-4 text-[14px]">
                        <li>Crystal-Clear Quality: Enjoy high-quality video for every call.</li>
                        <li>Easy to Use: Start video chat just a few clicks.</li>
                        <li>Secure: Advanced encryption keeps your conversations safe.</li>
                        <li>Crocs-Platform: Works seamlessly on laptops, tablets, and smartphones.</li>
                    </ul>
                    <h2 class="text-[20px]">Join Telemedicine Today</h2>
                    <p class="text-[14px]">Sign up now to experience the future of video commmunication. Whether for personal use or business, Telemedicine is your go-to solution for seamless, high-quality video chats.</p>
                    <h2 class="text-[20px]">Get Started</h2>
                    <p class="text-[14px]">Create your free account and explore Telemedicine's features. Welcome to the new era of video communication!</p>
                </div>
            </div>
            <div class="xl:w-[577px] 2xl:w-[577px] lg:w-[577px] bg-[#080D14] flex xl:py-20 px-4 pb-10 w-full">
                <form method="post" class="w-full" action="{{ route('login') }}">
                    @csrf
                    <div class="mx-auto text-white flex-col flex">
                        <h1 class="2xl:text-[28px] xl:text-[28px] lg:text-[28px] text-[20px] font-semibold">Telemedicine</h1>
                        <h2 class="text-[26px] xl:mt-8 2xl:mt-8 lg:mt-4">Sign In</h2>
                        <input type="email" name="email" placeholder="Email" class="my-2 bg-[#404749] lg:w-[470px] xl:w-[470px] 2xl:w-[470px]  h-[50px] text-[14px] rounded px-4">
                        <input type="password" name="password" placeholder="Password" class="my-2 bg-[#404749] lg:w-[470px] xl:w-[470px] 2xl:w-[470px] h-[50px] text-[14px] rounded px-4">
                        <div class="my-0 lg:w-[470px] xl:w-[470px] 2xl:w-[470px] h-[28px] text-[11px] text-[#FC2323] bg-[#F07650]/[0.20] flex items-center px-2 rounded">
                            Error Message
                        </div>

                        <button type="submit" class="my-4 bg-[#487D27] lg:w-[470px] xl:w-[470px] 2xl:w-[470px]  h-[60px] text-[16px] rounded px-4 font-semibold  hover:bg-[#287D27]"> Login</button>
                        <div>
                            <span class="text-[14px] mx-2">If you don’t have an account you can
                                <a href="" class="hover:underline text-[#F87979] mx-2">Sign-up</a>for free
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
