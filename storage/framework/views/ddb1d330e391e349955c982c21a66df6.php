<v-date-picker <?php echo e($attributes); ?>>
    <?php echo e($slot); ?>

</v-date-picker>

<?php if (! $__env->hasRenderedOnce('a5503860-1f47-4298-a21e-d2a4dd6b49ef')): $__env->markAsRenderedOnce('a5503860-1f47-4298-a21e-d2a4dd6b49ef');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-date-picker-template"
    >
        <span class="relative inline-block w-full">
            <slot></slot>

            <i class="icon-calendar pointer-events-none absolute top-1/2 -translate-y-1/2 text-2xl text-gray-400 ltr:right-2 rtl:left-2"></i>
        </span>
    </script>

    <script type="module">
        app.component('v-date-picker', {
            template: '#v-date-picker-template',

            props: {
                name: String,

                value: String,

                allowInput: {
                    type: Boolean,
                    default: true,
                },

                disable: Array,

                minDate: String,

                maxDate: String,
            },

            data: function() {
                return {
                    datepicker: null
                };
            },

            watch: {
                minDate: function (value) {
                    this.datepicker?.set('minDate', value ?? '');
                },

                maxDate: function (value) {
                    this.datepicker?.set('maxDate', value ?? '');
                },

                disable: function (value) {
                    this.datepicker?.set('disable', value ?? []);
                },
            },

            mounted: function() {
                let options = this.setOptions();

                this.activate(options);
            },

            methods: {
                setOptions: function() {
                    let self = this;

                    return {
                        allowInput: this.allowInput ?? true,
                        disable: this.disable ?? [],
                        minDate: this.minDate ?? '',
                        maxDate: this.maxDate ?? '',
                        altFormat: "Y-m-d",
                        dateFormat: "Y-m-d",
                        weekNumbers: true,

                        onChange: function(selectedDates, dateStr, instance) {
                            self.$emit("onChange", dateStr);
                        }
                    };
                },

                activate: function(options) {
                    let element = this.$el.getElementsByTagName("input")[0];

                    this.datepicker = new Flatpickr(element, options);
                },

                clear: function() {
                    this.datepicker.clear();
                }
            }
        });
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\laragon\www\E-Commerce-Platform-Full-Stack\AI-E-Commerce\packages\Webkul\Admin\src/resources/views/components/flat-picker/date.blade.php ENDPATH**/ ?>