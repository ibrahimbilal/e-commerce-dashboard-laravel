@push('scripts')
@php
    $customerAddressesUrlTemplate = str_replace('/0/', '/__CUSTOMER__/', route('admin.customers.addresses', ['customer' => 0]));
@endphp
<script>
$(function () {
    var addressesUrlTemplate = {{ Js::from($customerAddressesUrlTemplate) }};
    function formatAddressLabel(a) {
        return [a.address_title, a.address_1, a.city, a.country].filter(Boolean).join(', ') || ('Address #' + a.id);
    }
    function rebuildAddressSelect(addresses, selectedId) {
        var $sel = $('#address-id');
        $sel.empty().append($('<option>', { value: '', text: 'Select address' }));
        (addresses || []).forEach(function (a) {
            $sel.append($('<option>', { value: a.id, text: formatAddressLabel(a) }));
        });
        if (selectedId) {
            $sel.val(String(selectedId));
        }
    }
    $('#customer').on('change', function () {
        var customerId = $(this).val();
        var preserveId = $('#address-id').val();
        if (!customerId) {
            rebuildAddressSelect([], null);
            return;
        }
        var url = addressesUrlTemplate.replace('__CUSTOMER__', customerId);
        $.getJSON(url).done(function (data) {
            rebuildAddressSelect(data.addresses || [], preserveId);
        }).fail(function () {
            rebuildAddressSelect([], null);
        });
    });
});
</script>
@endpush
