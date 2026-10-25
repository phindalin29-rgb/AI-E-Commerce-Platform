<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['position' => 'bottom-left', 'fitToggle' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['position' => 'bottom-left', 'fitToggle' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<v-dropdown
    position="<?php echo e($position); ?>"
    :fit-toggle="<?php echo e($fitToggle ? 'true' : 'false'); ?>"
    <?php echo e($attributes->merge(['class' => 'relative'])); ?>

>
    <?php if(isset($toggle)): ?>
        <?php echo e($toggle); ?>


        <template v-slot:toggle>
            <?php echo e($toggle); ?>

        </template>
    <?php endif; ?>

    <?php if(isset($content)): ?>
        <template v-slot:content>
            <div <?php echo e($content->attributes->merge(['class' => 'p-5'])); ?>>
                <?php echo e($content); ?>

            </div>
        </template>
    <?php endif; ?>

    <?php if(isset($menu)): ?>
        <template v-slot:menu>
            <ul <?php echo e($menu->attributes->merge(['class' => 'py-4'])); ?>>
                <?php echo e($menu); ?>

            </ul>
        </template>
    <?php endif; ?>
</v-dropdown>

<?php if (! $__env->hasRenderedOnce('289c06f2-6d77-434c-8d76-d10f93824df6')): $__env->markAsRenderedOnce('289c06f2-6d77-434c-8d76-d10f93824df6');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-dropdown-template"
    >
        <div>
            <div
                class="flex select-none"
                ref="toggleBlock"
                @click="toggle()"
            >
                <slot name="toggle">Toggle</slot>
            </div>

            <transition
                tag="div"
                name="dropdown"
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="scale-95 transform opacity-0"
                enter-to-class="scale-100 transform opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="scale-100 transform opacity-100"
                leave-to-class="scale-95 transform opacity-0"
            >
                <div
                    class="absolute z-10 w-max rounded bg-white shadow-[0px_8px_10px_0px_rgba(0,0,0,0.20),0px_6px_30px_0px_rgba(0,0,0,0.12),0px_16px_24px_0px_rgba(0,0,0,0.14)] dark:bg-gray-900"
                    :style="positionStyles"
                    v-show="isActive"
                >
                    <slot name="content"></slot>

                    <slot name="menu"></slot>
                </div>
            </transition>
        </div>
    </script>

    <script type="module">
        app.component('v-dropdown', {
            template: '#v-dropdown-template',

            props: {
                position: String,

                fitToggle: {
                    type: Boolean,
                    required: false,
                    default: false,
                },

                closeOnClick: {
                    type: Boolean,
                    required: false,
                    default: true
                },
            },

            data() {
                return {
                    toggleBlockWidth: 0,

                    toggleBlockHeight: 0,

                    isActive: false,
                };
            },

            created() {
                window.addEventListener('click', this.handleFocusOut);
            },

            mounted() {
                this.toggleBlockWidth = this.$refs.toggleBlock.clientWidth;

                this.toggleBlockHeight = this.$refs.toggleBlock.clientHeight;
            },

            beforeDestroy() {
                window.removeEventListener('click', this.handleFocusOut);
            },

            computed: {
                positionStyles() {
                    /**
                     * Sizing is the same wherever the panel hangs, so it is shared and the switch
                     * below only decides which corner it is anchored to.
                     */
                    const sizeStyles = [
                        `min-width: ${this.toggleBlockWidth}px`,
                        this.fitToggle ? `max-width: ${this.toggleBlockWidth}px` : '',
                    ];

                    switch (this.position) {
                        case 'bottom-right':
                            return [
                                ...sizeStyles,
                                `top: ${this.toggleBlockHeight}px`,
                                'right: 0',
                            ];

                        case 'top-left':
                            return [
                                ...sizeStyles,
                                `bottom: ${this.toggleBlockHeight * 2}px`,
                                'left: 0',
                            ];

                        case 'top-right':
                            return [
                                ...sizeStyles,
                                `bottom: ${this.toggleBlockHeight * 2}px`,
                                'right: 0',
                            ];

                        default:
                            return [
                                ...sizeStyles,
                                `top: ${this.toggleBlockHeight}px`,
                                'left: 0',
                            ];
                    }
                },
            },

            methods: {
                toggle() {
                    this.isActive = ! this.isActive;

                    /**
                     * Re-measure on open so the width is correct even when the dropdown mounted while
                     * hidden (e.g. inside a closed filter drawer), which `fitToggle` relies on.
                     */
                    if (this.isActive) {
                        this.toggleBlockWidth = this.$refs.toggleBlock.clientWidth;

                        this.toggleBlockHeight = this.$refs.toggleBlock.clientHeight;
                    }
                },

                handleFocusOut(e) {
                    if (! this.$el.contains(e.target) || (this.closeOnClick && this.$el.children[1].contains(e.target))) {
                        this.isActive = false;
                    }
                },
            },
        });
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\laragon\www\E-Commerce-Platform-Full-Stack\AI-E-Commerce\packages\Webkul\Admin\src/resources/views/components/dropdown/index.blade.php ENDPATH**/ ?>