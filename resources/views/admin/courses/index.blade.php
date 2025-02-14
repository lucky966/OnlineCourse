<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Courses') }}
            </h2>
            <a href="{{ route('admin.courses.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Add New
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="item-card flex flex-col md:flex-row gap-y-10 justify-between md:items-center">
                    @forelse ($course as $dt)
                        
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{ Storage::url($dt->category->thumbnail) }}" alt="" class="rounded-2xl object-cover w-[120px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $dt->teacher->name }}</h3>
                            <p class="text-slate-500 text-sm">{{ $dt->category->name }}</p>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Students</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $dt->user }}</h3>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Videos</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $dt->courseVideo->count() }}</h3>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Teacher</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $dt->teacher->user->name }}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        <a href="{{ route('admin.courses.show',$dt) }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Manage
                        </a>
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                Delete
                            </button>
                        </form>
                    </div>
                    @empty
                        <p>Data Kursus Masih Kosong</p>
                    @endforelse
                </div>                
            </div>
        </div>
    </div>
</x-app-layout>
