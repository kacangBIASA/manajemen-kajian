<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('event.manage') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Tambah Event Kajian') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 font-sans">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 sm:p-10">
                <form action="{{ route('event.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Kajian</label>
                            <input type="text" name="nama" class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4" placeholder="Masukkan judul kajian..." required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal" class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Waktu / Jam</label>
                            <input type="time" name="waktu" class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lokasi / Tempat</label>
                            <input type="text" name="tempat" class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4" placeholder="Nama masjid atau gedung..." required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" rows="4" class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4" placeholder="Materi yang akan dibahas, pemateri, dll..."></textarea>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 md:col-span-2">
                            <h3 class="text-sm font-bold text-slate-800 mb-4 tracking-wide uppercase">Pengaturan Tiket</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="metode_pembayaran" class="block text-sm font-semibold text-slate-700 mb-1.5">Sifat Kajian</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="block w-full rounded-xl border-slate-200 bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4">
                                        <option value="Gratis">Kajian Gratis (Free)</option>
                                        <option value="Berbayar">Kajian Berbayar (Tiket)</option>
                                    </select>
                                </div>
                                <div id="harga-section" style="display: none;">
                                    <label for="harga" class="block text-sm font-semibold text-slate-700 mb-1.5">Harga Tiket (Rp)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-slate-500 font-medium">Rp</span>
                                        </div>
                                        <input type="number" name="harga" id="harga" class="block w-full pl-12 rounded-xl border-slate-200 bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 pr-4" placeholder="50000">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('event.manage') }}" class="px-6 py-2.5 rounded-xl text-slate-600 bg-slate-100 hover:bg-slate-200 font-semibold transition-colors">Batal</a>
                        <button type="submit" class="px-8 py-2.5 rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 font-bold shadow-md hover:shadow-lg transition-all active:scale-95">Simpan Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodeSelect = document.getElementById('metode_pembayaran');
            const hargaSection = document.getElementById('harga-section');

            metodeSelect.addEventListener('change', function() {
                if (this.value === 'Berbayar') {
                    hargaSection.style.display = 'block';
                } else {
                    hargaSection.style.display = 'none';
                    document.getElementById('harga').value = '';
                }
            });
        });
    </script>
</x-app-layout>
