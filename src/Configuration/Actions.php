<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Actions extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Dispatcher\Dispatcher'] = [
            'container' => $di,
            'response'  => $di->lazyNew('Shadowlab\Responses\Blank'),
            'session'   => $di->lazyNew('Shadowlab\Session\Session'),
            'router'    => $di->lazyNew('Shadowlab\Router\Router')
        ];

        $di->params['Shadowlab\Interfaces\Action\AbstractAction'] = [
            'http'    => $di->lazyNew('Shadowlab\Responses\Blank'),
            'session' => $di->lazyNew('Shadowlab\Session\Session'),
            'request' => $di->lazyNew('Aura\Web\Request')
        ];

        $di->params['Shadowlab\Actions\User\LoginAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\User\AuthenticateAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\IndexAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Index')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\IndexCombatAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexCombat')
        ];

        /*
         * MAGIC SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexMagicAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexMagic')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\AdeptPowersAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowers'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\AdeptPowers')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\AdeptWaysAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWays'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\AdeptWays')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\MentorSpiritsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpirits'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\MentorSpirits')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\MetamagicsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Metamagics\Metamagics'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Metamagics')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\SpellsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spells\Spells'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Spells')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\SpiritPowersAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowers'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\SpiritPowers')
        ];

        /*
         * MATRIX SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexMatrixAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexMatrix')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\ComplexFormsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexForms'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\ComplexForms')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\IntrusionCountermeasuresAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasures'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\IntrusionCountermeasures')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\MatrixActionsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActions'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\MatrixActions')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\ProgramsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\Programs\Programs'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\Programs')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\SpriteDatabaseAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabase'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\SpriteDatabase')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\SpritePowersAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowers'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\SpritePowers')
        ];

        /*
         * OTHER SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexOtherAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexOther')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Other\QualitiesAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Other\Qualities\Qualities'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Other\Qualities')
        ];
    }
}
