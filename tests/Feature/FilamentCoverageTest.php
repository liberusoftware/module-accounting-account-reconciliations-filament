<?php

declare(strict_types=1);

use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Liberu\Accounting\AccountReconciliationsFilament\AccountReconciliationsFilamentPlugin;
use Liberu\Accounting\AccountReconciliationsFilament\AccountReconciliationsFilamentServiceProvider;
use Liberu\Accounting\AccountReconciliationsFilament\Resources\AccountReconciliationResource;
use Liberu\Accounting\AccountReconciliationsFilament\Resources\AccountReconciliationResource\Pages\ListAccountReconciliations;

it('registers and configures accounting-account-reconciliations-filament filament resources', function (): void {
    $provider = $this->app->register(AccountReconciliationsFilamentServiceProvider::class, force: true);
    if (method_exists($provider, 'boot')) {
        $provider->boot();
    }
    expect($provider)->toBeInstanceOf(AccountReconciliationsFilamentServiceProvider::class);
    $plugin = AccountReconciliationsFilamentPlugin::make();
    $panel = Panel::make()->id('test-accounting-account-reconciliations-filament');
    $plugin->register($panel);
    $plugin->boot($panel);
    expect($plugin->getId())->toBeString()->not->toBeEmpty();
    $host = new ListAccountReconciliations();
    expect(AccountReconciliationResource::getPages())->toBeArray();
    expect(AccountReconciliationResource::form(Schema::make($host)))->toBeInstanceOf(Schema::class);
    expect(AccountReconciliationResource::table(Table::make($host)))->toBeInstanceOf(Table::class);
});
