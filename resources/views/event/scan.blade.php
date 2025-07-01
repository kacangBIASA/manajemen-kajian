<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Scan QR Code
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('event.scan.process') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Masukkan QR Code</label>
                <input type="text" name="qr_code" class="w-full mt-1 rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Pilih Event</label>
                <select name="event_id" class="w-full mt-1 rounded border-gray-300">
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                Scan
            </button>
        </form>
    </div>
</x-app-layout>
