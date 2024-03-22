<x-layout.app>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <header class="flex px-5 py-4 bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-bold text-slate-200 dark:text-slate-100">Data Hasil Pertandingan Sepak Bola</h2>
            </header>
            <div class="p-5">
                @livewire('klasemen')
            </div>
        </div>
    </div>
    </x-layout-app>