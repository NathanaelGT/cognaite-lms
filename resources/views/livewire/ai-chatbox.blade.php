<div x-data="{ open: false }" style="position: relative;">

    <button
        @click="open = !open"
        aria-label="Open chat"
        style="
            position: fixed;
            right: 2rem;
            bottom: 2rem;
            width: 56px;
            height: 56px;
            border-radius: 9999px;
            background: rgb(var(--primary-600));
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        "
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24" height="24">
            <path d="M12 2C6.477 2 2 5.94 2 10.8c0 2.67 1.34 5.06 3.44 6.69V22l4.05-2.22c.81.17 1.66.26 2.51.26 5.523 0 10-3.94 10-8.8S17.523 2 12 2Z" />
        </svg>
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition.origin.bottom.right
        @click.outside="open = false"
        class="flex"
        style="
            position: fixed;
            right: 2rem;
            bottom: 6.5rem;
            width: min(48rem, calc(100vw - 2rem));
            max-height: 40rem;
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            flex-direction: column;
            overflow: hidden;
        "
    >
        <div
            style="
                background: rgb(var(--primary-600));
                color: white;
                padding: 0.75rem 1rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            "
        >
            <div
                style="
                    width: 36px;
                    height: 36px;
                    border-radius: 9999px;
                    background: rgba(255,255,255,0.25);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.75rem;
                    font-weight: 700;
                "
            >
                C
            </div>
            <div style="flex: 1;">
                <div style="font-size: 0.9rem; font-weight: 600;">Cogi</div>
                <div style="font-size: 0.75rem; opacity: 0.85;">Teman belajar Anda</div>
            </div>
            <button
                @click="open = false"
                style="background: none; border: none; color: white; font-size: 1rem; cursor: pointer;"
            >✕</button>
        </div>

        <div
            id="chat"
            style="
                flex: 1;
                padding: 1rem;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                overflow-y: auto;
                overflow-x: hidden;
                background: #f0f2f5;
                font-size: 0.9rem;
                scrollbar-width: thin;
                scrollbar-color: rgba(0,0,0,0.3) transparent;
            "
        >
            <div
                style="
                    max-width: 70%;
                    background: #e4e6eb;
                    padding: 0.6rem 1rem;
                    border-radius: 1.25rem 1.25rem 1.25rem 0.4rem;
                "
            >
                Halo, aku Cogi, asisten AI kamu. Aku siap membantu menjawab pertanyaan apa saja terkait batch ini. Silakan tanyakan apa yang ingin kamu ketahui!
            </div>
            @foreach($this->history as $history)
                @if($history->from_user)
                    <div
                        asd="dsa"
                        style="
                            max-width: 70%;
                            background: rgb(var(--primary-600));
                            color: white;
                            padding: 0.6rem 1rem;
                            border-radius: 1.25rem 1.25rem 0.4rem 1.25rem;
                            align-self: flex-end;
                        "
                    >
                        {{ $history->message }}
                    </div>
                @else
                    <div
                        style="
                            max-width: 70%;
                            background: #e4e6eb;
                            padding: 0.6rem 1rem;
                            white-space: pre-wrap;
                            border-radius: 1.25rem 1.25rem 1.25rem 0.4rem;
                        "
                    >{!! \Illuminate\Support\Str::markdown($history->message) !!}</div>
                @endif
            @endforeach

            <style>[wire\:text="currentPrompt"]:empty{display:none}</style>
            <div
                wire:text="currentPrompt"
                style="
                    max-width: 70%;
                    background: rgb(var(--primary-600));
                    color: white;
                    padding: 0.6rem 1rem;
                    border-radius: 1.25rem 1.25rem 0.4rem 1.25rem;
                    align-self: flex-end;
                "
            ></div>

            <div wire:stream="answer" style="display: none"></div>
            <style>#output:empty{display:none}</style>
            <div
                 wire:ignore
                 id="output"
                 style="
                    max-width: 70%;
                    background: #e4e6eb;
                    padding: 0.6rem 1rem;
                    white-space: pre-wrap;
                    border-radius: 1.25rem 1.25rem 1.25rem 0.4rem;
                "
            ></div>
            <script src="https://cdn.jsdelivr.net/npm/marked/lib/marked.umd.js"></script>
            <script>
                const container = document.querySelector('#chat')
                const input = document.querySelector('[wire\\:stream="answer"]')
                const output = document.querySelector('#output')

                const observer = new MutationObserver((mutations) => {
                    for (const mutation of mutations) {
                        if ((mutation.type === 'childList' || mutation.type === 'characterData') && input.innerHTML !== '') {
                            output.innerHTML = marked.parse(input.innerHTML)
                            container.scrollTop = container.scrollHeight
                        }
                    }
                })

                observer.observe(input, {
                    childList: true,
                    characterData: true,
                    subtree: true,
                })

                container.scrollTop = container.scrollHeight
            </script>
        </div>

        <form
            wire:submit.prevent="submitPrompt"
            wire:loading.attr="disabled"
            style="
                padding: 0.75rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                border-top: 1px solid #ddd;
                background: #ffffff;
            "
        >
            <input
                wire:model="prompt"
                type="text"
                placeholder="Tanya saya apa saja terkait batch ini..."
                style="
                    flex: 1;
                    border: none;
                    outline: none;
                    border-radius: 9999px;
                    padding: 0.6rem 1rem;
                    background: #f0f2f5;
                    font-size: 0.9rem;
                "
            />
            <button
                aria-label="Send"
                style="
                    min-width: 48px;
                    height: 40px;
                    padding: 0 14px;
                    border-radius: 9999px;
                    background: rgb(var(--primary-600));
                    border: none;
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                "
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="18" height="18">
                    <path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z" />
                </svg>
            </button>
        </form>
    </div>
</div>
