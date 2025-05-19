@push('head')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
@endpush

<div x-data x-init="
    snap.pay('{{ $this->transaction->snap_token }}', {
        onSuccess(result) {
            console.log($wire)
            $wire.success(result.order_id)
        },
        onPending(result) {
            console.log(result)
        },
    })
"></div>
