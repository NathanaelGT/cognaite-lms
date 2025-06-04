<div>
    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.user_name">
        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
            File
        </span>
    </label>
    <div class="border rounded-md overflow-hidden" style="width: 100%; height: 500px;">
        <iframe
            src="{{ asset('storage/' . $getRecord()->file_path) }}"
            width="100%"
            height="100%">
        </iframe>
    </div>
</div>
