<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // ── Confirm ───────────────────────────────────────────────────
            Actions\Action::make('confirm')
                ->label('Confirm Booking')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('Confirm this booking?')
                ->modalDescription('The guest will be considered confirmed. You can still edit or cancel it later.')
                ->modalSubmitActionLabel('Yes, Confirm')
                ->action(function () {
                    $this->record->update(['status' => 'confirmed']);
                    Notification::make()
                        ->title('Booking confirmed')
                        ->body($this->record->booking_number . ' — ' . $this->record->guest_name)
                        ->success()
                        ->send();
                    $this->redirect(BookingResource::getUrl('view', ['record' => $this->record]));
                }),

            // ── Mark Completed ────────────────────────────────────────────
            Actions\Action::make('complete')
                ->label('Mark as Completed')
                ->icon('heroicon-o-check-badge')
                ->color('info')
                ->visible(fn () => $this->record->status === 'confirmed')
                ->requiresConfirmation()
                ->modalHeading('Mark booking as completed?')
                ->modalDescription('This marks the stay or trip as finished. This action cannot be undone.')
                ->modalSubmitActionLabel('Mark Completed')
                ->action(function () {
                    $this->record->update(['status' => 'completed']);
                    Notification::make()
                        ->title('Booking marked as completed')
                        ->success()
                        ->send();
                    $this->redirect(BookingResource::getUrl('view', ['record' => $this->record]));
                }),

            // ── Cancel ────────────────────────────────────────────────────
            Actions\Action::make('cancel')
                ->label('Cancel Booking')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => in_array($this->record->status, ['pending', 'confirmed']))
                ->requiresConfirmation()
                ->modalHeading('Cancel this booking?')
                ->modalDescription('This will mark the booking as cancelled. The guest will NOT be automatically notified.')
                ->modalSubmitActionLabel('Yes, Cancel It')
                ->form([
                    \Filament\Forms\Components\Textarea::make('cancel_reason')
                        ->label('Cancellation Reason (optional)')
                        ->placeholder('Reason visible in admin notes...')
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    $notes = $this->record->admin_notes ?? '';
                    if (! empty($data['cancel_reason'])) {
                        $notes .= ($notes ? "\n\n" : '') . 'Cancellation reason: ' . $data['cancel_reason'];
                    }
                    $this->record->update([
                        'status'      => 'cancelled',
                        'admin_notes' => $notes ?: null,
                    ]);
                    Notification::make()
                        ->title('Booking cancelled')
                        ->body($this->record->booking_number)
                        ->danger()
                        ->send();
                    $this->redirect(BookingResource::getUrl('view', ['record' => $this->record]));
                }),

            // ── Reopen (cancelled → pending) ──────────────────────────────
            Actions\Action::make('reopen')
                ->label('Reopen Booking')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn () => $this->record->status === 'cancelled')
                ->requiresConfirmation()
                ->modalHeading('Reopen this cancelled booking?')
                ->modalSubmitActionLabel('Yes, Reopen')
                ->action(function () {
                    $this->record->update(['status' => 'pending']);
                    Notification::make()
                        ->title('Booking reopened as pending')
                        ->warning()
                        ->send();
                    $this->redirect(BookingResource::getUrl('view', ['record' => $this->record]));
                }),

            // ── Edit & Delete ─────────────────────────────────────────────
            Actions\EditAction::make()
                ->label('Edit / Update'),

            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete this booking?')
                ->modalDescription('This permanently removes the booking record. This cannot be undone.'),
        ];
    }
}
