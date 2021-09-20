<div class="flex items-center justify-between py-2 px-2 bg-gray-50 bg-opacity-10">
    <div class="flex gap-2 items-center">
        <div class="text-white text-xl">
            <i class="fas fa-crown"></i>
        </div>
        <div class="text-gray-100 text-lg">{{config('app.name')}}</div>
    </div>
    <div class="flex gap-2 items-center">
        <div class="hover:bg-opacity-20 bg-opacity-10 bg-white rounded-full p-2 text-white cursor-pointer">
            <i class="fas fa-search"></i>
        </div>
        <div class="relative hover:bg-opacity-20 bg-opacity-10 bg-white rounded-full p-2 text-white cursor-pointer">
            <i class="fas fa-bell"></i>
            <div class="bg-red-500 absolute top-0 right-0 -mr-3 rounded-full w-6 h-6 text-xs text-center pt-1 bg-opacity-80">0</div>
        </div>
        <div class="hover:bg-opacity-20 bg-opacity-10 bg-white rounded-full p-2 text-white cursor-pointer ml-4">
            <i class="fas fa-user"></i>
        </div>
    </div>
</div>
