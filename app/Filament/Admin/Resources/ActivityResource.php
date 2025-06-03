<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ActivityResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity as ActivityLog;

class ActivityResource extends Resource
{
    protected static ?string $model = ActivityLog::class;
    protected static ?string $navigationLabel = 'Logs';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('causer.name')
                    ->label('Pengguna')
                    ->state(fn ($record) => $record->causer?->name
                        ?? ($record->properties['attributes']['name'] ?? '-'))
                    ->searchable(),

                TextColumn::make('aktivitas')
                    ->label('Aktivitas')
                    ->state(function ($record) {
                        $state = $record->description;

                        if ($state === 'created') {
                            return 'Register';
                        }

                        if ($state === 'Join batch') {
                            $batchName = $record->subject?->name;
                            return $batchName ? "Join batch $batchName" : 'Join batch';
                        }

                        return $state;
                    })
                    ->searchable(query: fn (Builder $query, string $search) => $query->orWhereHas('subject', fn ($q) => $q->where('name', 'like', "%{$search}%")))
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->paginated([50])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
        ];
    }
}
