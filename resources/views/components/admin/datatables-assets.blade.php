{{--
  DataTables 2.x (Bootstrap 5 integration) — no embedded Bootstrap JS.
  Extensions: Buttons (ColVis, HTML5+JSZip+pdfmake, Print), AutoFill, ColReorder,
  DateTime, SearchBuilder, SearchPanes, Select.
  Replaces legacy download-builder bundle (BS 4.1.1 + DT 1.10.24).
--}}
@once
    @push('stylesheet')
        <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"/>
    @endpush
    @push('scripts')
        <script src="{{ asset('vendor/datatables/js/jszip.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/pdfmake.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/vfs_fonts.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/buttons.bootstrap5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/buttons.html5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/buttons.print.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/buttons.colVis.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.autoFill.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/autoFill.bootstrap5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.colReorder.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.dateTime.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.searchBuilder.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/searchBuilder.bootstrap5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.searchPanes.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/searchPanes.bootstrap5.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/dataTables.select.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/datatables/js/select.bootstrap5.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            window.getAdminDataTableLayout = function () {
                var rtl = document.documentElement.getAttribute('dir') === 'rtl';
                if (rtl) {
                    return {
                        topStart: 'search',
                        topEnd: 'buttons',
                        bottomStart: 'paging',
                        bottomEnd: 'info',
                    };
                }

                return {
                    topStart: 'buttons',
                    topEnd: 'search',
                    bottomStart: 'info',
                    bottomEnd: 'paging',
                };
            };

            window.AdminDataTableLayout = window.getAdminDataTableLayout();

            /** Prefer at init time so layout matches current document.dir (RTL/LTR). */
            window.resolveAdminDataTableLayout = function () {
                return typeof window.getAdminDataTableLayout === 'function'
                    ? window.getAdminDataTableLayout()
                    : window.AdminDataTableLayout;
            };

            (function () {
                if (typeof DataTable === 'undefined') {
                    return;
                }

                Object.assign(DataTable.defaults, {
                    pagingType: 'simple_numbers',
                    paging: {
                        firstLast: false,
                    },
                    language: {
                        info: 'Show _START_ To _END_ Of _TOTAL_',
                        infoEmpty: 'Show 0 To 0 Of 0',
                        infoFiltered: '(filtered from _MAX_ total)',
                        paginate: {
                            first: @json(__('tables.buttons.first')),
                            last: @json(__('tables.buttons.last')),
                            previous: @json(__('tables.buttons.prev')),
                            next: @json(__('tables.buttons.next')),
                        },
                    },
                    stateSaveParams: function (settings, data) {
                        data.adminStateVersion = 2;
                    },
                    stateLoadParams: function (settings, data) {
                        if (!data || data.adminStateVersion !== 2) {
                            return false;
                        }
                    },
                });
            })();
        </script>
    @endpush
@endonce
