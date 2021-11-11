<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel>
                <h1 class="text-center font-bold text-xl">Profile</h1>

                <form method="POST" action="/profile/delete" class="mt-10">
                    @csrf

                    <input name="id" type="hidden" value="{{ Auth::user()->id }}">
                    <div class="text-center">
                        <button type="submit" class="transition-colors duration-300 bg-red-300 hover:bg-red-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8"
                                onclick='return confirm("После удаления аккаунта вы сможете восстановить его до {{ \Carbon\Carbon::now()->addDays(14)->format('d-m-Y') }}")'>Delete profile</button>
                    </div>
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>
