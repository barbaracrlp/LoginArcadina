<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Support\Facades\FilamentIcon;

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
            'panels::global-search.field' => 'fas fa-search',
            'panels::pages.dashboard.actions.filter' => 'fas fa-filter',
            'panels::pages.dashboard.navigation-item' => 'fas fa-tachometer-alt',
            'panels::pages.password-reset.request-password-reset.actions.login' => 'fas fa-sign-in-alt',
            'panels::pages.password-reset.request-password-reset.actions.login.rtl' => 'fas fa-sign-in-alt', // Using the same icon as the LTR version
            'panels::resources.pages.edit-record.navigation-item' => 'fas fa-edit',
            'panels::resources.pages.manage-related-records.navigation-item' => 'fas fa-list-alt',
            'panels::resources.pages.view-record.navigation-item' => 'fas fa-eye',
            'panels::sidebar.collapse-button' => 'fas fa-chevron-left',
            'panels::sidebar.collapse-button.rtl' => 'fas fa-chevron-right',
            'panels::sidebar.expand-button' => 'fas fa-chevron-right',
            'panels::sidebar.expand-button.rtl' => 'fas fa-chevron-left',
            'panels::sidebar.group.collapse-button' => 'fas fa-minus-circle',
            'panels::tenant-menu.billing-button' => 'fas fa-file-invoice-dollar',
            'panels::tenant-menu.profile-button' => 'fas fa-user',
            'panels::tenant-menu.registration-button' => 'fas fa-user-plus',
            'panels::tenant-menu.toggle-button' => 'fas fa-bars',
            'panels::theme-switcher.light-button' => 'fas fa-sun',
            'panels::theme-switcher.dark-button' => 'fas fa-moon',
            'panels::theme-switcher.system-button' => 'fas fa-cog',
            'panels::topbar.close-sidebar-button' => 'fas fa-times',
            'panels::topbar.open-sidebar-button' => 'fas fa-bars',
            'panels::topbar.group.toggle-button' => 'fas fa-caret-down',
            'panels::topbar.open-database-notifications-button' => 'fas fa-bell',
            'panels::user-menu.profile-item' => 'fas fa-user-circle',
            'panels::user-menu.logout-button' => 'fas fa-sign-out-alt',
            'panels::widgets.account.logout-button' => 'fas fa-sign-out-alt',
            'panels::widgets.filament-info.open-documentation-button' => 'fas fa-book-open',
            'panels::widgets.filament-info.open-github-button' => 'fab fa-github',
            //ahora los de los formularios 
            'forms::components.builder.actions.clone' => 'fas fa-clone',
            'forms::components.builder.actions.collapse' => 'fas fa-minus-square',
            'forms::components.builder.actions.delete' => 'fas fa-trash-alt',
            'forms::components.builder.actions.expand' => 'fas fa-plus-square',
            'forms::components.builder.actions.move-down' => 'fas fa-arrow-down',
            'forms::components.builder.actions.move-up' => 'fas fa-arrow-up',
            'forms::components.builder.actions.reorder' => 'fas fa-sort',
            'forms::components.checkbox-list.search-field' => 'fas fa-search',
            'forms::components.file-upload.editor.actions.drag-crop' => 'fas fa-crop',
            'forms::components.file-upload.editor.actions.drag-move' => 'fas fa-arrows-alt',
            'forms::components.file-upload.editor.actions.flip-horizontal' => 'fas fa-arrows-alt-h',
            'forms::components.file-upload.editor.actions.flip-vertical' => 'fas fa-arrows-alt-v',
            'forms::components.file-upload.editor.actions.move-down' => 'fas fa-arrow-down',
            'forms::components.file-upload.editor.actions.move-left' => 'fas fa-arrow-left',
            'forms::components.file-upload.editor.actions.move-right' => 'fas fa-arrow-right',
            'forms::components.file-upload.editor.actions.move-up' => 'fas fa-arrow-up',
            'forms::components.file-upload.editor.actions.rotate-left' => 'fas fa-undo-alt',
            'forms::components.file-upload.editor.actions.rotate-right' => 'fas fa-redo-alt',
            'forms::components.file-upload.editor.actions.zoom-100' => 'fas fa-search-plus',
            'forms::components.file-upload.editor.actions.zoom-in' => 'fas fa-search-plus',
            'forms::components.file-upload.editor.actions.zoom-out' => 'fas fa-search-minus',
            'forms::components.key-value.actions.delete' => 'fas fa-trash-alt',
            'forms::components.key-value.actions.reorder' => 'fas fa-sort',
            'forms::components.repeater.actions.clone' => 'fas fa-clone',
            'forms::components.repeater.actions.collapse' => 'fas fa-minus-square',
            'forms::components.repeater.actions.delete' => 'fas fa-trash-alt',
            'forms::components.repeater.actions.expand' => 'fas fa-plus-square',
            'forms::components.repeater.actions.move-down' => 'fas fa-arrow-down',
            'forms::components.repeater.actions.move-up' => 'fas fa-arrow-up',
            'forms::components.repeater.actions.reorder' => 'fas fa-sort',
            'forms::components.select.actions.create-option' => 'fas fa-plus',
            'forms::components.select.actions.edit-option' => 'fas fa-edit',
            'forms::components.text-input.actions.hide-password' => 'fas fa-eye-slash',
            'forms::components.text-input.actions.show-password' => 'fas fa-eye',
            'forms::components.toggle-buttons.boolean.false' => 'fas fa-times',
            'forms::components.toggle-buttons.boolean.true' => 'fas fa-check',
            'forms::components.wizard.completed-step' => 'fas fa-check-circle',
            //a partir de ahora los de la tabla
            'tables::actions.disable-reordering' => 'fas fa-lock',
'tables::actions.enable-reordering' => 'fas fa-unlock',
'tables::actions.filter' => 'fas fa-filter',
'tables::actions.group' => 'fas fa-object-group',
'tables::actions.open-bulk-actions' => 'fas fa-tasks',
'tables::actions.toggle-columns' => 'fas fa-columns',
'tables::columns.collapse-button' => 'fas fa-minus-square',
'tables::columns.icon-column.false' => 'fas fa-times-circle',
'tables::columns.icon-column.true' => 'fas fa-check-circle',
'tables::empty-state' => 'fas fa-inbox',
'tables::filters.query-builder.constraints.boolean' => 'fas fa-toggle-off',
'tables::filters.query-builder.constraints.date' => 'far fa-calendar-alt',
'tables::filters.query-builder.constraints.number' => 'fas fa-hashtag',
'tables::filters.query-builder.constraints.relationship' => 'fas fa-link',
'tables::filters.query-builder.constraints.select' => 'far fa-caret-square-down',
'tables::filters.query-builder.constraints.text' => 'fas fa-font',
'tables::filters.remove-all-button' => 'fas fa-times-circle',
'tables::grouping.collapse-button' => 'fas fa-minus-square',
'tables::header-cell.sort-asc-button' => 'fas fa-sort-up',
'tables::header-cell.sort-desc-button' => 'fas fa-sort-down',
'tables::reorder.handle' => 'fas fa-grip-vertical',
'tables::search-field' => 'fas fa-search',
//ahora de notificaciones 
'notifications::database.modal.empty-state' => 'fas fa-inbox',
'notifications::notification.close-button' => 'fas fa-times',
'notifications::notification.danger' => 'fas fa-exclamation-circle',
'notifications::notification.info' => 'fas fa-info-circle',
'notifications::notification.success' => 'fas fa-check-circle',
'notifications::notification.warning' => 'fas fa-exclamation-triangle',
//acciones
'actions::action-group' => 'fas fa-folder',
'actions::create-action.grouped' => 'fas fa-plus-square',
'actions::delete-action' => 'fas fa-trash-alt',
'actions::delete-action.grouped' => 'fas fa-trash-alt',
'actions::delete-action.modal' => 'fas fa-trash-alt',
'actions::detach-action' => 'fas fa-unlink',
'actions::detach-action.modal' => 'fas fa-unlink',
'actions::dissociate-action' => 'fas fa-chain-broken',
'actions::dissociate-action.modal' => 'fas fa-chain-broken',
'actions::edit-action' => 'fas fa-edit',
'actions::edit-action.grouped' => 'fas fa-edit',
'actions::export-action.grouped' => 'fas fa-file-export',
'actions::force-delete-action' => 'fas fa-trash-alt',
'actions::force-delete-action.grouped' => 'fas fa-trash-alt',
'actions::force-delete-action.modal' => 'fas fa-trash-alt',
'actions::import-action.grouped' => 'fas fa-file-import',
'actions::modal.confirmation' => 'fas fa-exclamation-triangle',
'actions::replicate-action' => 'fas fa-copy',
'actions::replicate-action.grouped' => 'fas fa-copy',
'actions::restore-action' => 'fas fa-undo-alt',
'actions::restore-action.grouped' => 'fas fa-undo-alt',
'actions::restore-action.modal' => 'fas fa-undo-alt',
'actions::view-action' => 'fas fa-eye',
'actions::view-action.grouped' => 'fas fa-eye',
//infolist
'infolists::components.icon-entry.false' => 'fas fa-times-circle',
'infolists::components.icon-entry.true' => 'fas fa-check-circle',
//UUI
'badge.delete-button' => 'fas fa-times-circle',
'breadcrumbs.separator' => 'fas fa-angle-right',
'breadcrumbs.separator.rtl' => 'fas fa-angle-left', // Mirrored for right-to-left direction
'modal.close-button' => 'fas fa-times',
'pagination.first-button' => 'fas fa-angle-double-left',
'pagination.first-button.rtl' => 'fas fa-angle-double-right', // Mirrored for right-to-left direction
'pagination.last-button' => 'fas fa-angle-double-right',
'pagination.last-button.rtl' => 'fas fa-angle-double-left', // Mirrored for right-to-left direction
'pagination.next-button' => 'fas fa-chevron-right',
'pagination.next-button.rtl' => 'fas fa-chevron-left', // Mirrored for right-to-left direction
'pagination.previous-button' => 'fas fa-chevron-left',
'pagination.previous-button.rtl' => 'fas fa-chevron-right', // Mirrored for right-to-left direction
'section.collapse-button' => 'fas fa-minus-square',


        ]);
    }
}
