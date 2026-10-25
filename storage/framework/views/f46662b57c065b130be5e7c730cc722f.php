<div class="fixed top-14 z-[1000] h-full w-[270px] bg-white pt-4 shadow-[0px_8px_10px_0px_rgba(0,_0,_0,_0.2)] transition-all duration-300 group-[.sidebar-collapsed]/container:w-[70px] dark:bg-gray-900 max-lg:hidden">
    <div class="journal-scroll h-[calc(100vh-100px)] overflow-auto group-[.sidebar-collapsed]/container:overflow-visible">
        <nav class="grid w-full gap-2">
            <!-- Navigation Menu -->
            <?php $__currentLoopData = menu()->getItems('admin'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    class="px-4 group/item <?php echo e($menuItem->isActive() ? 'active' : 'inactive'); ?>"
                    onmouseenter="adjustSubMenuPosition(event)"
                >
                    <a
                        href="<?php echo e($menuItem->getUrl()); ?>"
                        class="flex gap-2.5 p-1.5 items-center cursor-pointer hover:rounded-lg <?php echo e($menuItem->isActive() == 'active' ? 'bg-blue-600 rounded-lg' : ' hover:bg-gray-100 hover:dark:bg-gray-950'); ?> peer"
                    >
                        <span class="<?php echo e($menuItem->getIcon()); ?> text-2xl <?php echo e($menuItem->isActive() ? 'text-white' : ''); ?>"></span>

                        <p class="text-gray-600 dark:text-gray-300 font-semibold whitespace-nowrap group-[.sidebar-collapsed]/container:hidden <?php echo e($menuItem->isActive() ? 'text-white' : ''); ?>">
                            <?php echo e($menuItem->getName()); ?>

                        </p>
                    </a>

                    <?php if($menuItem->haveChildren()): ?>
                        <div class="<?php echo e($menuItem->isActive() ? '!grid bg-gray-100 dark:bg-gray-950' : ''); ?> hidden min-w-[180px] ltr:pl-10 rtl:pr-10 pb-2 rounded-b-lg z-[100] overflow-hidden group-[.sidebar-collapsed]/container:!hidden group-[.sidebar-collapsed]/container:fixed group-[.sidebar-collapsed]/container:ltr:!left-[70px] group-[.sidebar-collapsed]/container:rtl:!right-[70px] group-[.sidebar-collapsed]/container:p-[0] group-[.sidebar-collapsed]/container:bg-white dark:group-[.sidebar-collapsed]/container:bg-gray-900 group-[.sidebar-collapsed]/container:border group-[.sidebar-collapsed]/container:ltr:rounded-r-lg group-[.sidebar-collapsed]/container:rtl:rounded-l-lg group-[.sidebar-collapsed]/container:border-gray-300 group-[.sidebar-collapsed]/container:dark:border-gray-800 group-[.sidebar-collapsed]/container:rounded-none group-[.sidebar-collapsed]/container:ltr:shadow-[34px_10px_14px_rgba(0,0,0,0.01),19px_6px_12px_rgba(0,0,0,0.03),9px_3px_9px_rgba(0,0,0,0.04),2px_1px_5px_rgba(0,0,0,0.05),0px_0px_0px_rgba(0,0,0,0.05)] group-[.sidebar-collapsed]/container:rtl:shadow-[-34px_10px_14px_rgba(0,0,0,0.01),-19px_6px_12px_rgba(0,0,0,0.03),-9px_3px_9px_rgba(0,0,0,0.04),-2px_1px_5px_rgba(0,0,0,0.05),-0px_0px_0px_rgba(0,0,0,0.05)] group-[.sidebar-collapsed]/container:max-h-[calc(100vh-3.5rem)] group-[.sidebar-collapsed]/container:overflow-y-auto group-[.sidebar-collapsed]/container:group-hover/item:!grid group-[.inactive]/item:hidden group-[.inactive]/item:fixed group-[.inactive]/item:ltr:left-[270px] group-[.inactive]/item:rtl:right-[270px] group-[.inactive]/item:p-[0] group-[.inactive]/item:bg-white dark:group-[.inactive]/item:bg-gray-900 group-[.inactive]/item:border group-[.inactive]/item:ltr:rounded-r-lg group-[.inactive]/item:rtl:rounded-l-lg group-[.inactive]/item:border-gray-300 group-[.inactive]/item:dark:border-gray-800 group-[.inactive]/item:rounded-none group-[.inactive]/item:ltr:shadow-[34px_10px_14px_rgba(0,0,0,0.01),19px_6px_12px_rgba(0,0,0,0.03),9px_3px_9px_rgba(0,0,0,0.04),2px_1px_5px_rgba(0,0,0,0.05),0px_0px_0px_rgba(0,0,0,0.05)] group-[.inactive]/item:rtl:shadow-[-34px_10px_14px_rgba(0,0,0,0.01),-19px_6px_12px_rgba(0,0,0,0.03),-9px_3px_9px_rgba(0,0,0,0.04),-2px_1px_5px_rgba(0,0,0,0.05),-0px_0px_0px_rgba(0,0,0,0.05)] group-[.inactive]/item:max-h-[calc(100vh-3.5rem)] group-[.inactive]/item:overflow-y-auto group-[.inactive]/item:group-hover/item:!grid journal-scroll">
                            <?php $__currentLoopData = $menuItem->getChildren(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a
                                    href="<?php echo e($subMenuItem->getUrl()); ?>"
                                    class="<?php echo e($subMenuItem->haveChildren() ? 'font-medium' : ''); ?> text-sm text-<?php echo e($subMenuItem->isActive() ? 'blue':'gray'); ?>-600 dark:text-<?php echo e($subMenuItem->isActive() ? 'blue':'gray'); ?>-300 whitespace-nowrap py-1 group-[.sidebar-collapsed]/container:px-5 group-[.sidebar-collapsed]/container:py-2.5 group-[.inactive]/item:px-5 group-[.inactive]/item:py-2.5 hover:text-blue-600 dark:hover:bg-gray-950"
                                >
                                    <?php echo e($subMenuItem->getName()); ?>

                                </a>

                                <?php if($subMenuItem->haveChildren()): ?>
                                    <div class="grid ltr:pl-4 rtl:pr-4 group-[.inactive]/item:ltr:pl-5 group-[.inactive]/item:rtl:pr-5 group-[.inactive]/item:pb-1 group-[.sidebar-collapsed]/container:ltr:pl-5 group-[.sidebar-collapsed]/container:rtl:pr-5 group-[.sidebar-collapsed]/container:pb-1">
                                        <?php $__currentLoopData = $subMenuItem->getChildren(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subSubMenuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a
                                                href="<?php echo e($subSubMenuItem->getUrl()); ?>"
                                                class="text-sm text-<?php echo e($subSubMenuItem->isActive() ? 'blue':'gray'); ?>-600 dark:text-<?php echo e($subSubMenuItem->isActive() ? 'blue':'gray'); ?>-300 whitespace-nowrap py-1 group-[.sidebar-collapsed]/container:px-5 group-[.sidebar-collapsed]/container:py-2.5 group-[.inactive]/item:px-5 group-[.inactive]/item:py-2.5 hover:text-blue-600 dark:hover:bg-gray-950"
                                            >
                                                <?php echo e($subSubMenuItem->getName()); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Help & Resources (Always Visible) -->
            <?php
                $isHelpActive = request()->routeIs('admin.help.index');
            ?>

            <!-- Divider -->
            <div class="mx-4 my-1 border-t border-gray-200 dark:border-gray-800"></div>

            <div class="px-4 group/item">
                <a
                    href="<?php echo e(route('admin.help.index')); ?>"
                    class="flex gap-2.5 p-1.5 items-center cursor-pointer hover:rounded-lg <?php echo e($isHelpActive ? 'bg-blue-600 rounded-lg' : 'hover:bg-gray-100 hover:dark:bg-gray-950'); ?>"
                >
                    <svg
                        class="h-6 w-6 shrink-0 <?php echo e($isHelpActive ? 'text-white' : 'text-gray-600 dark:text-gray-300'); ?>"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M9.4 9.3a2.6 2.6 0 0 1 5.05.85c0 1.7-2.45 2.05-2.45 3.6"></path>
                        <path d="M12 17.2h.01"></path>
                    </svg>

                    <p class="text-gray-600 dark:text-gray-300 font-semibold whitespace-nowrap group-[.sidebar-collapsed]/container:hidden <?php echo e($isHelpActive ? 'text-white' : ''); ?>">
                        <?php echo app('translator')->get('admin::app.components.layouts.sidebar.help'); ?>
                    </p>
                </a>
            </div>
        </nav>
    </div>

    <!-- Collapse menu -->
    <v-sidebar-collapse></v-sidebar-collapse>
</div>

<?php if (! $__env->hasRenderedOnce('c7b10f98-6681-4c37-965d-a7bbd4843185')): $__env->markAsRenderedOnce('c7b10f98-6681-4c37-965d-a7bbd4843185');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-sidebar-collapse-template"
    >
        <div
            class="fixed bottom-0 w-full max-w-[270px] cursor-pointer border-t border-gray-200 bg-white px-4 transition-all duration-300 hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-900 dark:hover:bg-gray-950"
            :class="{'max-w-[70px]': isCollapsed}"
            @click="toggle"
        >
            <div class="flex items-center gap-2.5 p-1.5">
                <span
                    class="icon-collapse text-2xl transition-all"
                    :class="[isCollapsed ? 'ltr:rotate-[180deg] rtl:rotate-[0]' : 'ltr:rotate-[0] rtl:rotate-[180deg]']"
                ></span>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-sidebar-collapse', {
            template: '#v-sidebar-collapse-template',

            data() {
                return {
                    isCollapsed: <?php echo e(request()->cookie('sidebar_collapsed') ?? 0); ?>,
                }
            },

            methods: {
                toggle() {
                    this.isCollapsed = parseInt(this.isCollapsedCookie()) ? 0 : 1;

                    var expiryDate = new Date();

                    expiryDate.setMonth(expiryDate.getMonth() + 1);

                    document.cookie = 'sidebar_collapsed=' + this.isCollapsed + '; path=/; expires=' + expiryDate.toGMTString();

                    this.$root.$refs.appLayout.classList.toggle('sidebar-collapsed');
                },

                isCollapsedCookie() {
                    const cookies = document.cookie.split(';');

                    for (const cookie of cookies) {
                        const [name, value] = cookie.trim().split('=');

                        if (name === 'sidebar_collapsed') {
                            return value;
                        }
                    }

                    return 0;
                },
            },
        });
    </script>

    <script>
        const headerHeight = 56;

        const adjustSubMenuPosition = (event) => {
            let menuContainer = event.currentTarget;

            let subMenuContainer = menuContainer.lastElementChild;

            if (subMenuContainer) {
                const menuTopOffset = menuContainer.getBoundingClientRect().top;

                const subMenuHeight = subMenuContainer.offsetHeight;

                const availableHeight = window.innerHeight - menuTopOffset;

                let subMenuTopOffset = menuTopOffset;

                if (subMenuHeight > availableHeight) {
                    subMenuTopOffset = menuTopOffset - (subMenuHeight - availableHeight);
                }

                subMenuContainer.style.top = `${Math.max(headerHeight, subMenuTopOffset)}px`;
            }
        };
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\laragon\www\E-Commerce-Platform-Full-Stack\AI-E-Commerce\packages\Webkul\Admin\src/resources/views/components/layouts/sidebar/index.blade.php ENDPATH**/ ?>