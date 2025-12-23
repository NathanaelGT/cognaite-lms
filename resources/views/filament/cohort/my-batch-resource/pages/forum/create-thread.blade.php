<x-filament-panels::page>
    <div class="space-y-4">

        <h2 style="font-size: 1.5rem; font-weight: 700;">
            Buat Diskusi Baru
        </h2>

        <p style="font-size: 0.875rem; color: #6b7280;">
            Ajukan pertanyaan sesuai materi, quiz, atau tugas yang sedang kamu ikuti.
        </p>

        <form wire:submit.prevent="submit" class="space-y-4">

            {{ $this->form }}

            <div style="display: flex; justify-content: flex-end;">
                <button
                    type="{{ $this->enabled ? 'submit' : 'button' }}"
                    wire:loading.attr="disabled"
                    style="
                        display: inline-flex;
                        align-items: center;
                        gap: 0.5rem;
                        padding: 0.5rem 1rem;
                        border-radius: 0.375rem;
                        background: rgb(217 119 6);
                        color: white;
                        font-weight: 600;
                        border: none;
                        cursor: pointer;
                    "
                >
                    <svg
                        wire:loading
                        xmlns="http://www.w3.org/2000/svg"
                        style="width: 1rem; height: 1rem;"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="animate-spin"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v3m6.364 1.636-2.121 2.121M21 12h-3m-1.636 6.364-2.121-2.121M12 21v-3m-6.364-1.636 2.121-2.121M3 12h3m1.636-6.364 2.121 2.121"/>
                    </svg>

                    <span wire:loading.remove>
                        Kirim Pertanyaan
                    </span>

                    <span wire:loading>
                        Mengirim...
                    </span>
                </button>
            </div>

        </form>
    </div>
</x-filament-panels::page>
