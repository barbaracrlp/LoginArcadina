<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentView;

use Illuminate\Contracts\View\View;
use Filament\View\PanelsRenderHook;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //aqui voy a poner el registro de los iconos 
        FilamentIcon::register([
            // 'panels::topbar.global-search.field' => 'fas-magnifying-glass',
            // 'panels::topbar.global-search.field' => 'fas-magnifying-glass',
            'panels::global-search.field' => 'fas-search',
            'panels::pages.dashboard.actions.filter' => 'fas-filter',
            'panels::pages.dashboard.navigation-item' => 'fas-tachometer-alt',
            'panels::pages.password-reset.request-password-reset.actions.login' => 'fas-sign-in-alt',
            'panels::pages.password-reset.request-password-reset.actions.login.rtl' => 'fas-sign-in-alt', // Using the same icon as the LTR version
            'panels::resources.pages.edit-record.navigation-item' => 'fas-edit',
            'panels::resources.pages.manage-related-records.navigation-item' => 'fas-list-alt',
            'panels::resources.pages.view-record.navigation-item' => 'fas-eye',
            'panels::sidebar.collapse-button' => 'fas-chevron-left',
            'panels::sidebar.collapse-button.rtl' => 'fas-chevron-right',
            'panels::sidebar.expand-button' => 'fas-chevron-right',
            'panels::sidebar.expand-button.rtl' => 'fas-chevron-left',
            'panels::sidebar.group.collapse-button' => null,
            'panels::tenant-menu.billing-button' => 'fas-file-invoice-dollar',
            'panels::tenant-menu.profile-button' => 'fas-user',
            'panels::tenant-menu.registration-button' => 'fas-user-plus',
            'panels::tenant-menu.toggle-button' => 'fas-bars',
            'panels::theme-switcher.light-button' => 'fas-sun',
            'panels::theme-switcher.dark-button' => 'fas-moon',
            'panels::theme-switcher.system-button' => 'fas-cog',
            'panels::topbar.close-sidebar-button' => 'fas-times',
            'panels::topbar.open-sidebar-button' => 'fas-bars',
            'panels::topbar.group.toggle-button' => 'fas-caret-down',
            'panels::topbar.open-database-notifications-button' => 'fas-bell',
            'panels::user-menu.profile-item' => 'fas-user-circle',
            'panels::user-menu.logout-button' => 'fas-sign-out-alt',
            'panels::widgets.account.logout-button' => 'fas-sign-out-alt',
            'panels::widgets.filament-info.open-documentation-button' => 'fas-book-open',
            'panels::widgets.filament-info.open-github-button' => 'fab-github',

            //ahora los de los formularios 
            'forms::components.builder.actions.clone' => 'fas-clone',
            'forms::components.builder.actions.collapse' => 'fas-minus-square',
            'forms::components.builder.actions.delete' => 'fas-trash-alt',
            'forms::components.builder.actions.expand' => 'fas-plus-square',
            'forms::components.builder.actions.move-down' => 'fas-arrow-down',
            'forms::components.builder.actions.move-up' => 'fas-arrow-up',
            'forms::components.builder.actions.reorder' => 'fas-sort',
            'forms::components.checkbox-list.search-field' => 'fas-search',
            'forms::components.file-upload.editor.actions.drag-crop' => 'fas-crop',
            'forms::components.file-upload.editor.actions.drag-move' => 'fas-arrows-alt',
            'forms::components.file-upload.editor.actions.flip-horizontal' => 'fas-arrows-alt-h',
            'forms::components.file-upload.editor.actions.flip-vertical' => 'fas-arrows-alt-v',
            'forms::components.file-upload.editor.actions.move-down' => 'fas-arrow-down',
            'forms::components.file-upload.editor.actions.move-left' => 'fas-arrow-left',
            'forms::components.file-upload.editor.actions.move-right' => 'fas-arrow-right',
            'forms::components.file-upload.editor.actions.move-up' => 'fas-arrow-up',
            'forms::components.file-upload.editor.actions.rotate-left' => 'fas-undo-alt',
            'forms::components.file-upload.editor.actions.rotate-right' => 'fas-redo-alt',
            'forms::components.file-upload.editor.actions.zoom-100' => 'fas-search-plus',
            'forms::components.file-upload.editor.actions.zoom-in' => 'fas-search-plus',
            'forms::components.file-upload.editor.actions.zoom-out' => 'fas-search-minus',
            'forms::components.key-value.actions.delete' => 'fas-trash-alt',
            'forms::components.key-value.actions.reorder' => 'fas-sort',
            'forms::components.repeater.actions.clone' => 'fas-clone',
            'forms::components.repeater.actions.collapse' => 'fas-minus-square',
            'forms::components.repeater.actions.delete' => 'fas-trash-alt',
            'forms::components.repeater.actions.expand' => 'fas-plus-square',
            'forms::components.repeater.actions.move-down' => 'fas-arrow-down',
            'forms::components.repeater.actions.move-up' => 'fas-arrow-up',
            'forms::components.repeater.actions.reorder' => 'fas-sort',
            'forms::components.select.actions.create-option' => 'fas-plus',
            'forms::components.select.actions.edit-option' => 'fas-edit',
            'forms::components.text-input.actions.hide-password' => 'fas-eye-slash',
            'forms::components.text-input.actions.show-password' => 'fas-eye',
            'forms::components.toggle-buttons.boolean.false' => 'fas-times',
            'forms::components.toggle-buttons.boolean.true' => 'fas-check',
            'forms::components.wizard.completed-step' => 'fas-check-circle',

            //a partir de ahora los de la tabla
            'tables::actions.disable-reordering' => 'fas-lock',
            'tables::actions.enable-reordering' => 'fas-unlock',
            'tables::actions.filter' => 'fas-filter',
            'tables::actions.group' => 'fas-object-group',
            'tables::actions.open-bulk-actions' => 'fas-tasks',
            'tables::actions.toggle-columns' => 'fas-columns',
            'tables::columns.collapse-button' => 'fas-minus-square',
            'tables::columns.icon-column.false' => 'fas-times-circle',
            'tables::columns.icon-column.true' => 'fas-check-circle',
            'tables::empty-state' => 'fas-inbox',
            'tables::filters.query-builder.constraints.boolean' => 'fas-toggle-off',
            'tables::filters.query-builder.constraints.date' => 'far-calendar-alt',
            'tables::filters.query-builder.constraints.number' => 'fas-hashtag',
            'tables::filters.query-builder.constraints.relationship' => 'fas-link',
            'tables::filters.query-builder.constraints.select' => 'far-caret-square-down',
            'tables::filters.query-builder.constraints.text' => 'fas-font',
            'tables::filters.remove-all-button' => 'fas-times-circle',
            'tables::grouping.collapse-button' => 'fas-minus-square',
            'tables::header-cell.sort-asc-button' => 'fas-sort-up',
            'tables::header-cell.sort-desc-button' => 'fas-sort-down',
            'tables::reorder.handle' => 'fas-grip-vertical',
            'tables::search-field' => 'fas-search',

            //ahora de notificaciones 
            'notifications::database.modal.empty-state' => 'fas-inbox',
            'notifications::notification.close-button' => 'fas-times',
            'notifications::notification.danger' => 'fas-exclamation-circle',
            'notifications::notification.info' => 'fas-info-circle',
            'notifications::notification.success' => 'fas-check-circle',
            'notifications::notification.warning' => 'fas-exclamation-triangle',

            //acciones
            'actions::action-group' => 'fas-folder',
            'actions::create-action.grouped' => 'fas-plus-square',
            'actions::delete-action' => 'fas-trash-alt',
            'actions::delete-action.grouped' => 'fas-trash-alt',
            'actions::delete-action.modal' => 'fas-trash-alt',
            'actions::detach-action' => 'fas-unlink',
            'actions::detach-action.modal' => 'fas-unlink',
            'actions::dissociate-action' => 'fas-chain-broken',
            'actions::dissociate-action.modal' => 'fas-chain-broken',
            'actions::edit-action' => 'fas-edit',
            'actions::edit-action.grouped' => 'fas-edit',
            'actions::export-action.grouped' => 'fas-file-export',
            'actions::force-delete-action' => 'fas-trash-alt',
            'actions::force-delete-action.grouped' => 'fas-trash-alt',
            'actions::force-delete-action.modal' => 'fas-trash-alt',
            'actions::import-action.grouped' => 'fas-file-import',
            'actions::modal.confirmation' => 'fas-exclamation-triangle',
            'actions::replicate-action' => 'fas-copy',
            'actions::replicate-action.grouped' => 'fas-copy',
            'actions::restore-action' => 'fas-undo-alt',
            'actions::restore-action.grouped' => 'fas-undo-alt',
            'actions::restore-action.modal' => 'fas-undo-alt',
            'actions::view-action' => 'fas-eye',
            'actions::view-action.grouped' => 'fas-eye',

            //infolist
            'infolists::components.icon-entry.false' => 'fas-times-circle',
            'infolists::components.icon-entry.true' => 'fas-check-circle',

            //UUI
            'badge.delete-button' => 'fas-times-circle',
            'breadcrumbs.separator' => 'fas-angle-right',
            'breadcrumbs.separator.rtl' => 'fas-angle-left', // Mirrored for right-to-left direction
            'modal.close-button' => 'fas-times',
            'pagination.first-button' => 'fas-angle-double-left',
            'pagination.first-button.rtl' => 'fas-angle-double-right', // Mirrored for right-to-left direction
            'pagination.last-button' => 'fas-angle-double-right',
            'pagination.last-button.rtl' => 'fas-angle-double-left', // Mirrored for right-to-left direction
            'pagination.next-button' => 'fas-chevron-right',
            'pagination.next-button.rtl' => 'fas-chevron-left', // Mirrored for right-to-left direction
            'pagination.previous-button' => 'fas-chevron-left',
            'pagination.previous-button.rtl' => 'fas-chevron-right', // Mirrored for right-to-left direction
            'section.collapse-button' => 'fas-minus-square',



        ]);

        //aqui le añado la view al login 
        /**para conseguir lo que quiero añado dos,y creare contenedores que abran en uno y cierren 
         * en el otro
         */
        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
        //     fn():View=>view('extra_login_head')
        // );
        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
        //     fn():View=>view('extra_login_foot')
        // );

    }
}
