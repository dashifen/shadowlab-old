<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Domains extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Interfaces\Domain\AbstractGateway'] = [
            'db' => $di->lazyNew('Shadowlab\Database\Database')
        ];

        $di->params['Shadowlab\Interfaces\Domain\AbstractDomain'] = [
            'payload' => $di->lazyNew('Shadowlab\Interfaces\Domain\Payloads\PayloadFactory'),
        ];

        $di->params['Shadowlab\Domains\User\User'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\User\UserFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\User\UserFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\User\UserGateway'),
        ];

        $di->params['Shadowlab\Domains\User\UserFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\User\UserEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Cheatsheets'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\CheatsheetsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\CheatsheetsEntity')
        ];

        /*
         * MAGIC SHEETS
         */

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowers'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowersFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowersFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowersGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowersFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowersEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWays'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWaysFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWaysFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWaysGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWaysFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWaysEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpirits'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpiritsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpiritsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpiritsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpiritsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpiritsEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\Metamagics\Metamagics'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Metamagics\MetamagicsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Metamagics\MetamagicsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Metamagics\MetamagicsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\Metamagics\MetamagicsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Metamagics\MetamagicsEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\Spells\Spells'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spells\SpellsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spells\SpellsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spells\SpellsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\Spells\SpellsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spells\SpellsEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowers'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowersFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowersFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowersGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowersFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowersEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\Spirits\Spirits'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spirits\SpiritsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spirits\SpiritsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spirits\SpiritsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Magic\Spirits\SpiritsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spirits\SpiritsEntity')
        ];

        /*
         * MATRIX SHEETS
         */

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexForms'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexFormsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexFormsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexFormsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexFormsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexFormsEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasures'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasuresFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasuresFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasuresGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasuresFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasuresEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActions'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActionsEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\Programs\Programs'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\Programs\ProgramsFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\Programs\ProgramsFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\Programs\ProgramsGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\Programs\ProgramsFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\Programs\ProgramsEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabase'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabaseFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabaseFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabaseGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabaseFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabaseEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowers'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowersFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowersFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowersGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowersFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowersEntity')
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Other\Qualities\Qualities'] = [
            'filter'  => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Other\Qualities\QualitiesFilter'),
            'factory' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Other\Qualities\QualitiesFactory'),
            'gateway' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Other\Qualities\QualitiesGateway'),
        ];

        $di->params['Shadowlab\Domains\Cheatsheets\Other\Qualities\QualitiesFilter'] = [
            'entity' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Other\Qualities\QualitiesEntity')
        ];
    }
}
