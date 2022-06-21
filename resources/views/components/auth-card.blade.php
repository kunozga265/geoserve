<div class="">
    <div class="absolute w-full bg-gray-800 background-image" style="background-image: url({{asset('images/auth-background1.jpg')}})"></div>
    <div class="min-h-screen flex flex-col justify-center items-center pt-2 sm:px-6">
        <div style="max-width: 410px; margin-top: 200px" class="sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
            <div class="py-6 flex justify-center">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            {{ $slot }}

        </div>
        <footer class="p-4 text-center">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2022 <a href="https://flowbite.com" class="hover:underline">Geoserve Engineering Group™</a>. All Rights Reserved.
                </span>
            {{-- <ul class="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                 <li>
                     <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                 </li>
                 <li>
                     <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                 </li>
                 <li>
                     <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
                 </li>
                 <li>
                     <a href="#" class="hover:underline">Contact</a>
                 </li>
             </ul>--}}
        </footer>
    </div>
</div>
